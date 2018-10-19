# Get Fare Family List

## Description

This is a lookup method that gives fare family list to be used for getAvailability request. The output changes depending on ports location (domestic or international) and ticket type (award ticket or not). 

## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/getFareFamilyList) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$this->client->getFareFamilyList($getFareFamilyListParameters);

```

### Example with ValueObjects
```php
<?php

use TK\SDK\ValueObject\GetFareFamilyListParameters;

$getFareFamilyListParameters = (new GetFareFamilyListParameters())
	->withAirportIataCode('IST')
	->withMilesRequest();

$response = $this->client->getFareFamilyList($getFareFamilyListParameters);

```