# Get Timetable

## Description

This method retrieves schedule info. It lists all flights in requested route and operation days in a week.
 
## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/GetTimetable) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$client->getTimetable($getTimetableParametersObject);

```

### Example with Factory Using JSON Query

```php
<?php

use TK\SDK\ValueObject\Factory\GetTimetableParametersFactory;

$jsonQuery =<<<JSON
{
  "OTA_AirScheduleRQ":{
    "OriginDestinationInformation":{
      "DepartureDateTime":{
        "WindowAfter":"P3D",
        "WindowBefore":"P3D",
        "Date":"2017-10-14"
      },
      "OriginLocation":{
        "LocationCode":"IST",
        "MultiAirportCityInd":true
      },
      "DestinationLocation":{
        "LocationCode":"ESB",
        "MultiAirportCityInd":false
      }
    },
    "AirlineCode":"TK",
    "FlightTypePref":{
      "DirectAndNonStopOnlyInd":true
    }
  },
  "returnDate":"2017-10-20",
  "scheduleType":"W",
  "tripType":"R"
}
JSON;

$getTimetableParametersObject = GetTimetableParametersFactory::createFromJson($jsonQuery);

$response = $client->getTimetable($getTimetableParametersObject);

```

### Example with Factory Using An Array

You can build an array that is basically json_encode version of the object mentioned in the previous example.

```php
<?php

use TK\SDK\ValueObject\Factory\GetTimetableParametersFactory;

$getTimetableParametersObject = GetTimetableParametersFactory::createFromArray($parametersArray);

$response = $client->getTimetable($getTimetableParametersObject);

```

### Example with ValueObjects (Recomended)

```php
<?php

use DateTimeImmutable;
use TK\SDK\ValueObject\Location;
use TK\SDK\ValueObject\DepartureDateTime;
use TK\SDK\ValueObject\OriginDestinationInformation;
use TK\SDK\ValueObject\AirScheduleRQ;
use TK\SDK\ValueObject\GetTimetableParameters;

$originLocation = new Location('IST', Location::MULTIPLE_AIRPORT_TRUE);
$destinationLocation  = new Location('JFK', Location::MULTIPLE_AIRPORT_TRUE);
$departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));

$departureDateTime = new DepartureDateTime(
	new DateTimeImmutable($departureTime),
	'P3D',
	'P3D'
);

$originDestinationInformation = new OriginDestinationInformation(
	$departureDateTime,
	$originLocation,
	$destinationLocation
);

$airScheduleRQ = (new AirScheduleRQ($originDestinationInformation))
	->withAirlineCode(AirScheduleRQ::AIRLINE_TURKISH_AIRLINES)
	->withDirectAndNonStopOnlyInd();
	
$getTimetableParametersObject = new GetTimetableParameters(
	$airScheduleRQ,
	GetTimetableParameters::SCHEDULE_TYPE_WEEKLY,
	GetTimetableParameters::TRIP_TYPE_ONE_WAY
);

$response = $client->getTimetable($getTimetableParametersObject);

```
