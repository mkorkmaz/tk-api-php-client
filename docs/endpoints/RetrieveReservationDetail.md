# Retrieve Reservation Detail

## Description

This method returns the detailed information of the reservations created through our reservation system in XML format. It covers reservations made from all sales channels.
 
## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/retrieveReservationDetail) on Turkish Airlines Developer Portal

## Endpoint Method

```php
$this->client->retrieveReservationDetail($retrieveReservationDetailParameters);

```

### Example with Factory Using JSON Query

```php
<?php

use TK\SDK\ValueObject\Factory\RetrieveReservationDetailParametersFactory;

$json =<<<JSON
{
    "airlineCode": "TK",
    "languageCode": "TR"
}
JSON;
$parameterObject = RetrieveReservationDetailParametersFactory::createFromJson($json);
$response = $client->retrieveReservationDetail($parameterObject);

```

### Example with Factory Using An Array

You can build an array that is basically json_encode version of the object mentioned in the previous example.

```php
<?php

use TK\SDK\ValueObject\Factory\RetrieveReservationDetailParametersFactory;

$parameterObject = RetrieveReservationDetailParametersFactory::createFromArray($parametersArray);

$response = $client->retrieveReservationDetail($parameterObject);

```


### Example with ValueObjects

```php
<?php

use TK\SDK\ValueObject\RetrieveReservationDetailParameters;

$retrieveReservationDetailParameters = new RetrieveReservationDetailParameters(
	'TT8VN8',
	'CELIKTAS'
);

$response = $this->client->retrieveReservationDetail($retrieveReservationDetailParameters);

```