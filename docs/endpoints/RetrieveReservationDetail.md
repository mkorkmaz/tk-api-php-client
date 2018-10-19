# Retrieve Reservation Detail

## Description

This method returns the detailed information of the reservations created through our reservation system in XML format. It covers reservations made from all sales channels.
 
## Endpoint Documentation

See [the API documentation page](https://developer.turkishairlines.com/documentation/retrieveReservationDetail) on Turkish Airlines Developer Portal

## Endpoint Method
```php
$this->client->retrieveReservationDetail($retrieveReservationDetailParameters);

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
