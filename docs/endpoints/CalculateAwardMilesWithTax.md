# Calculate Award Miles With Tax

## Description

Calculates award miles with tax.
  
## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/calculate-award-miles-with-tax) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$this->client->calculateAwardMilesWithTax($calculateAwardMilesWithTaxParameters);

```

### Example with Factory Using JSON Query

```php
<?php

use TK\SDK\ValueObject\Factory\CalculateAwardMilesWithTaxParametersFactory;

$json =<<<JSON
{
    "awardType": "E",
    "wantMoreMiles": "T",
    "isOneWay": "T",
    "departureOrigin": "IST",
    "departureDestination": "FRA",
    "departureDateDay": 12,
    "departureDateMonth": 11,
    "departureDateYear": 2017
}
JSON;
$parameterObject = CalculateAwardMilesWithTaxParametersFactory::createFromJson($json);

$response = $client->calculateAwardMilesWithTax($parameterObject);

```

### Example with Factory Using An Array

You can build an array that is basically json_encode version of the object mentioned in the previous example.

```php
<?php

use TK\SDK\ValueObject\Factory\CalculateAwardMilesWithTaxParametersFactory;

$parameterObject = CalculateAwardMilesWithTaxParametersFactory::createFromArray($parametersArray);

$response = $client->calculateAwardMilesWithTax($parameterObject);

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
