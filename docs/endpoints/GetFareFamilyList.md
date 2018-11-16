# Get Fare Family List

## Description

This is a lookup method that gives fare family list to be used for getAvailability request. The output changes depending on ports location (domestic or international) and ticket type (award ticket or not). 

## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/getFareFamilyList) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$this->client->getFareFamilyList($getFareFamilyListParameters);

```

### Example with Factory Using JSON Query

```php
<?php

use TK\API\ValueObject\Factory\GetFareFamilyListParametersFactory;

$json =<<<JSON
{
    "portList":[
        "IST",
        "JFK"
    ],
    "isMilesRequest" : "T"
}
JSON;
$parameterObject = GetFareFamilyListParametersFactory::createFromJson($json);

$response = $client->getFareFamilyList($parameterObject);

```

### Example with Factory Using An Array

You can build an array that is basically json_encode version of the object mentioned in the previous example.

```php
<?php

use TK\API\ValueObject\Factory\GetFareFamilyListParametersFactory;

$parameterObject = GetFareFamilyListParametersFactory::createFromArray($parametersArray);

$response = $client->getFareFamilyList($parameterObject);

```

### Example with ValueObjects
```php
<?php

use TK\API\ValueObject\GetFareFamilyListParameters;

$getFareFamilyListParameters = (new GetFareFamilyListParameters())
	->withAirportIataCode('IST')
	->withMilesRequest();

$response = $this->client->getFareFamilyList($getFareFamilyListParameters);

```
