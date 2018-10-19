# Calculate Award Miles With Tax

## Description

Calculates award miles with tax.
  
## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/calculate-award-miles-with-tax) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$this->client->calculateAwardMilesWithTax($calculateAwardMilesWithTaxParameters);

```

### Example with ValueObjects

```php
<?php

use TK\SDK\ValueObject\CalculateAwardMilesWithTaxParameters;

$departureDate = gmdate('Y-m-d H:i:s', strtotime('-4 days'));

$calculateAwardMilesWithTaxParameters = (new CalculateAwardMilesWithTaxParameters(
	CalculateAwardMilesWithTaxParameters::AWARD_TYPE_ECONOMY
))->withOneWay()
	->withSeatGuaranteed()
	->withDepartureOrigin('IST')
	->withDepartureDestination('JFK')
	->withDepartureDate(new DateTimeImmutable($departureDate));
       
$response = $this->client->calculateAwardMilesWithTax($calculateAwardMilesWithTaxParameters);
```
