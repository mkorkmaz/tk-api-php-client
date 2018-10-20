# Calculate Flight Miles

## Description

 Calculates miles for flight.
  
## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/calculate-flight-miles) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$this->client->calculateFlightMiles($calculateFlightMilesParameters);

```

### Example with Factory Using JSON Query

```php
<?php

use TK\SDK\ValueObject\Factory\CalculateFlightMilesParametersFactory;

$json =<<<JSON
{
    "cabin_code": "Y",
    "card_type": "EP",
    "destination": "IST",
    "flightDate": "21.04.2017",
    "operatingFlightNumber": "TK1000",
    "origin": "FRA"
}

JSON;
$parameterObject = CalculateFlightMilesParametersFactory::createFromJson($json);

$response = $client->calculateFlightMiles($parameterObject);

```

### Example with Factory Using An Array

You can build an array that is basically json_encode version of the object mentioned in the previous example.

```php
<?php

use TK\SDK\ValueObject\Factory\CalculateFlightMilesParametersFactory;

$parameterObject = CalculateFlightMilesParametersFactory::createFromArray($parametersArray);

$response = $client->calculateFlightMiles($parameterObject);

```

### Example with ValueObjects

```php
<?php

use TK\SDK\ValueObject\CalculateFlightMilesParameters;

$flightDate = gmdate('Y-m-d H:i:s', strtotime('+4 days'));

$calculateFlightMilesParameters = (new CalculateFlightMilesParameters(
	'FRA',
	'IST'
))->withCabinCode()
  	->withCardType('EP')
	->withOperatingFlightNumber('TK1000')
	->withFlightDate(new DateTimeImmutable($flightDate));

$response = $this->client->calculateFlightMiles($calculateFlightMilesParameters);

```
