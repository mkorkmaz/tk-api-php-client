# Calculate Flight Miles

## Description

 Calculates miles for flight.
  
## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/calculate-flight-miles) on Turkish Airlines Developer Portal

## Endpoint Method
```php
$this->client->calculateFlightMiles($calculateFlightMilesParameters);

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

$respon$response = $this->client->calculateFlightMiles($calculateFlightMilesParameters);

```
