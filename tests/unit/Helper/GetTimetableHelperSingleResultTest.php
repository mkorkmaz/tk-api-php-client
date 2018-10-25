<?php namespace Helper;

use TK\SDK\ClientBuilder;
use DateTimeImmutable;
use TK\SDK\Helper\GetTimetableHelper;
use TK\SDK\ValueObject;
use Dotenv;

class GetTimetableHelperSingleResultTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $response;
    
    protected function _before()
    {
        if (file_exists(__DIR__.'/../../../.env')) {
            $dotenv = new Dotenv\Dotenv(__DIR__ . '/../../..');
            $dotenv->load();
        }
        $client = ClientBuilder::create()
            ->setEnvironment(getenv('TK_API_URL'), getenv('TK_API_KEY'), getenv('TK_API_SECRET'))
            ->build();
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', ValueObject\Location::MULTIPLE_AIRPORT_FALSE);
        $destinationLocation  = new ValueObject\Location('ESB', ValueObject\Location::MULTIPLE_AIRPORT_FALSE);
        $departureDateTime = new ValueObject\DepartureDateTime(
            new DateTimeImmutable($departureTime),
            'P0D',
            'P0D'
        );
        $originDestinationInformation = new ValueObject\OriginDestinationInformation(
            $departureDateTime,
            $originLocation,
            $destinationLocation
        );
        $airScheduleRQ = (new ValueObject\AirScheduleRQ($originDestinationInformation))
            ->withDirectAndNonStopOnlyInd();
        $getTimetableParameters = new ValueObject\GetTimetableParameters(
            $airScheduleRQ,
            ValueObject\GetTimetableParameters::SCHEDULE_TYPE_DAILY,
            ValueObject\GetTimetableParameters::TRIP_TYPE_ONE_WAY
        );
        $this->response = $client->getTimetable($getTimetableParameters);
        $this->response['data']['extendedOTAAirScheduleRS']['OTA_AirScheduleRS']
        ['OriginDestinationOptions']['OriginDestinationOption']
            = $this->response['data']['extendedOTAAirScheduleRS']['OTA_AirScheduleRS']
        ['OriginDestinationOptions']['OriginDestinationOption'][0];

        $this->response['data']['extendedOTAAirScheduleRS']['extraOTAAirScheduleRS']
        ['extraOTAAirScheduleRSListType']['flightExtraInfo'] =  $this->response['data']['extendedOTAAirScheduleRS']
        ['extraOTAAirScheduleRS']
        ['extraOTAAirScheduleRSListType']['flightExtraInfo'][0];
    }

    protected function _after()
    {
    }

    /**
     * @test
     */
    public function shouldGetDataSuccessfully() : void
    {
        $helper = new GetTimetableHelper($this->response['data']);
        $flightInfo = $helper->getFlightExtraInfo();
        $this->assertArrayHasKey('durationType', $flightInfo);
        foreach ($helper->getOriginDestinationOptions() as $originDestinationOption) {
            $flightDetails = $helper->getFlightDetails($originDestinationOption);
            $this->assertArrayHasKey('FlightNumber', $flightDetails);
            $this->assertArrayHasKey('DepartureDateTime', $flightDetails);
            $this->assertArrayHasKey('OperationTime', $flightDetails);
            $this->assertArrayHasKey('ScheduleValidEndDate', $flightDetails);
            $operationAirline = $helper->getOperationAirline($originDestinationOption);
            $this->assertArrayHasKey('FlightNumber', $operationAirline);
            $this->assertArrayHasKey('Code', $operationAirline);
        }
    }
}
