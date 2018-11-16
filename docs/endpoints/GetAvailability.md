# Get Availability

## Description

The Availability Request message requests Flight Availability for a city pair on a specific date for a specific number and type of passengers. Calendar with best price of each day in a week and full flight list with their price depending on cabin will be provided. 

## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/GetAvailability) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$client->getAvailability($getAvailabilityParametersObject);

```

### Example with Factory Using JSON Query

```php
<?php

use TK\API\ValueObject\Factory\GetAvailabilityParametersFactory;

$json =<<<JSON
{
  "ReducedDataIndicator":false,
  "RoutingType":"r",
  "PassengerTypeQuantity":[
    {
      "Code":"adult",
      "Quantity":1
    },
    {
      "Code":"child",
      "Quantity":1
    },
    {
      "Code":"infant",
      "Quantity":0
    }
  ],
  "OriginDestinationInformation":[
    {
      "DepartureDateTime":{
        "WindowAfter":"P0D",
        "WindowBefore":"P0D",
        "Date":"14OCT"
      },
      "OriginLocation":{
        "LocationCode":"IST",
        "MultiAirportCityInd":true
      },
      "DestinationLocation":{
        "LocationCode":"ESB",
        "MultiAirportCityInd":true
      },
      "CabinPreferences":[
        {
          "Cabin":"ECONOMY"
        },
        {
          "Cabin":"BUSINESS"
        }
      ]
    },
    {
      "DepartureDateTime":{
        "WindowAfter":"P0D",
        "WindowBefore":"P0D",
        "Date":"09JAN"
      },
      "OriginLocation":{
        "LocationCode":"ESB",
        "MultiAirportCityInd":false
      },
      "DestinationLocation":{
        "LocationCode":"IST",
        "MultiAirportCityInd":false
      },
      "CabinPreferences":[
        {
          "Cabin":"ECONOMY"
        },
        {
          "Cabin":"BUSINESS"
        }
      ]
    }
  ]
}
JSON;

$getAvailabilityParameters = GetAvailabilityParametersFactory::createFromJson($json);
$response = $client->getAvailability($getAvailabilityParameters);

```

### Example with Factory Using An Array

You can build an array that is basically json_encode version of the object mentioned in the previous example.

```php
<?php

use TK\API\ValueObject\Factory\GetAvailabilityParametersFactory;

$getAvailabilityParameters = GetAvailabilityParametersFactory::createFromArray($parametersArray);

$response = $client->getAvailability($getAvailabilityParameters);

```

### Example with ValueObjects

```php
<?php

use DateTimeImmutable;
use TK\API\ValueObject\Location;
use TK\API\ValueObject\DepartureDateTime;
use TK\API\ValueObject\OriginDestinationInformation;
use TK\API\ValueObject\PassengerTypeQuantity;
use TK\API\ValueObject\GetAvailabilityParameters;

$departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
$departureDateTime = (new DepartureDateTime(
	new DateTimeImmutable($departureTime),
	'P3D',
	'P3D'
))->withDateFormat('dM');

$originLocation = new Location('IST', Location::MULTIPLE_AIRPORT_TRUE);
$destinationLocation  = new Location('ESB', Location::MULTIPLE_AIRPORT_TRUE);

$originDestinationInformation = (new OriginDestinationInformation(
	$departureDateTime,
	$originLocation,
	$destinationLocation
))->withCabinPreferences(OriginDestinationInformation::CABIN_PREFERENCE_ECONOMY);

$passengerTypeQuantity = (new PassengerTypeQuantity())
	->withQuantity(PassengerTypeQuantity::PASSENGER_TYPE_ADULT, 1)
	->withQuantity(PassengerTypeQuantity::PASSENGER_TYPE_CHILD, 2);
	
$getAvailabilityParameters = new GetAvailabilityParameters(
	GetAvailabilityParameters::REDUCED_DATA_INDICATOR_FALSE,
	GetAvailabilityParameters::ROUTING_TYPE_ONE_WAY,
	$passengerTypeQuantity
);

$getAvailabilityParameters = $getAvailabilityParameters
	->withOriginDestinationInformation($originDestinationInformation);
        
$response = $this->client->getAvailability($getAvailabilityParameters);

```

