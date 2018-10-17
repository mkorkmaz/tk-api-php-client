<?php
declare(strict_types=1);

namespace TK\SDK\Helper;

class GetTimetableHelper
{
    public $responseData;

    public function __construct(array $responseData)
    {
        $this->responseData = $responseData;
    }

    public function getFlightExtraInfo() : array
    {
        $extraOTAAirScheduleRS = $this->responseData['extendedOTAAirScheduleRS']['extraOTAAirScheduleRS'];
        $flightExtraInfo = $extraOTAAirScheduleRS['extraOTAAirScheduleRSListType']['flightExtraInfo'][0];
        return [
            'totalDuration' => DurationConverter::toMinute($flightExtraInfo['totalDuration']),
            'flightDuration' => DurationConverter::toMinute($flightExtraInfo['flightDuration']),
            'transferDuration' => DurationConverter::toMinute($flightExtraInfo['transferDuration']),
            'durationType' => 'minute'
        ];
    }

    public function getOriginDestinationOptions() : array
    {
        $airScheduleRS = $this->responseData['extendedOTAAirScheduleRS']['OTA_AirScheduleRS'];
        return $airScheduleRS['OriginDestinationOptions']['OriginDestinationOption'];
    }

    public function getOperationAirline(array $originDestinationOption) : array
    {
        return $originDestinationOption['FlightSegment']['OperatingAirline'];
    }

    public function getFlightDetails(array $originDestinationOption) : array
    {
        $flightExtraInfo = $this->getFlightExtraInfo();
        return [
            'ScheduleValidStartDate' => $originDestinationOption['FlightSegment']['ScheduleValidStartDate'],
            'ScheduleValidEndDate' => $originDestinationOption['FlightSegment']['ScheduleValidEndDate'],
            'DepartureAirport' => $originDestinationOption['FlightSegment']['DepartureAirport']['LocationCode'],
            'ArrivalAirport' => $originDestinationOption['FlightSegment']['ArrivalAirport']['LocationCode'],
            'OperationTime' => $originDestinationOption['FlightSegment']['DaysOfOperation']['OperationSchedule']
                ['OperationTimes']['OperationTime']['Text'],
            'DepartureDateTime' => $originDestinationOption['FlightSegment']['DepartureDateTime'],
            'ArrivalDateTime' => $originDestinationOption['FlightSegment']['ArrivalDateTime'],
            'FlightNumber' => $originDestinationOption['FlightSegment']['FlightNumber'],
            'JourneyDuration' => DurationConverter::toMinute(
                $originDestinationOption['FlightSegment']['JourneyDuration'],
                DurationConverter::FORMAT_SHORT
            ),
            'totalDuration' => $flightExtraInfo['totalDuration'],
            'flightDuration' => $flightExtraInfo['flightDuration'],
            'transferDuration' => $flightExtraInfo['transferDuration'],
            'durationType' => 'minute'
        ];
    }
}
