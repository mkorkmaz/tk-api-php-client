<?php
declare(strict_types=1);

namespace TK\API\Helper;

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
        $flightExtraInfo = $this
            ->getFlightExtraInfoData($extraOTAAirScheduleRS['extraOTAAirScheduleRSListType']['flightExtraInfo']);
        return [
            'totalDuration' => DurationConverter::toMinute($flightExtraInfo['totalDuration']),
            'flightDuration' => DurationConverter::toMinute($flightExtraInfo['flightDuration']),
            'transferDuration' => DurationConverter::toMinute($flightExtraInfo['transferDuration']),
            'durationType' => 'minute'
        ];
    }

    private function getFlightExtraInfoData($flightExtraInfo) : array
    {
        if (array_key_exists('totalDuration', $flightExtraInfo)) {
            return $flightExtraInfo;
        }
        return $flightExtraInfo[0];
    }

    public function getOriginDestinationOptions() : array
    {
        $airScheduleRS = $this->responseData['extendedOTAAirScheduleRS']['OTA_AirScheduleRS'];
        if (array_key_exists('FlightSegment', $airScheduleRS['OriginDestinationOptions']['OriginDestinationOption'])) {
            return [$airScheduleRS['OriginDestinationOptions']['OriginDestinationOption']];
        }
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
            'AirlineCode' => $originDestinationOption['FlightSegment']['OperatingAirline']['Code'],
            'JourneyDuration' => DurationConverter::toMinute(
                $originDestinationOption['FlightSegment']['JourneyDuration'],
                DurationConverter::FORMAT_SHORT
            ),
            'TotalDuration' => $flightExtraInfo['totalDuration'],
            'FlightDuration' => $flightExtraInfo['flightDuration'],
            'TransferDuration' => $flightExtraInfo['transferDuration'],
            'DurationType' => 'minute'
        ];
    }
}
