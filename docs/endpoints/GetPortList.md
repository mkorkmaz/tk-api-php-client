# Get Port List

## Description

Lists all ports in details.

## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/getPortList) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$client->getPortList($getPortListParametersObject);

```

### Example with ValueObjects

```php
<?php

use TK\SDK\ValueObject\GetPortListParameters;

$getPortListParameters = (new GetPortListParameters(
	GetPortListParameters::AIRLINE_CODE_TURKISH_AIRLINES
))->withLanguageCode(GetPortListParameters::LANGUAGE_CODE_EN);

$response = $this->client->getPortList($getPortListParameters);

```