# Get Port List

## Description

Lists all ports in details.

## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/getPortList) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$client->getPortList($getPortListParametersObject);

```

### Example with Factory Using JSON Query

```php
<?php

use TK\API\ValueObject\Factory\GetPortListParametersFactory;

$json =<<<JSON
{
    "airlineCode": "TK",
    "languageCode": "TR"
}
JSON;
$parameterObject = GetPortListParametersFactory::createFromJson($json);
$response = $client->getPortList($parameterObject);

```

### Example with Factory Using An Array

You can build an array that is basically json_encode version of the object mentioned in the previous example.

```php
<?php

use TK\API\ValueObject\Factory\GetPortListParametersFactory;

$parameterObject = GetPortListParametersFactory::createFromArray($parametersArray);

$response = $client->getPortList($parameterObject);

```

### Example with ValueObjects

```php
<?php

use TK\API\ValueObject\GetPortListParameters;

$getPortListParameters = (new GetPortListParameters(
	GetPortListParameters::AIRLINE_CODE_TURKISH_AIRLINES
))->withLanguageCode(GetPortListParameters::LANGUAGE_CODE_EN);

$response = $this->client->getPortList($getPortListParameters);

```
