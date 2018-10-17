# Turkish Airlines' TK API Unofficial PHP SDK

See the official documentation at [Turkish Airlines Developer Portal](https://developer.turkishairlines.com/)

To use this library, one has to create a developer account on Developer Portal and create an application to get required API Key and API Secret.


### Installation

```bash
composer require mkorkmaz/tk-api-php-sdk
```

### Configuration

Put your API Key and API Secret securely in a configuration file or .env etc. Since calling an API endpoint is rate-limited, it is important to secure these information.

Use https://api.turkishairlines.com/test as your api test url during development.


### Creating API Client


```PHP
<?php

include 'vendor/autoload.php';
use TK\SDK\ClientBuilder;

$client = ClientBuilder::create()
	->setEnvironment(getenv('TK_API_URL'), getenv('TK_API_KEY'), getenv('TK_API_SECRET'))
	->build();
```
### Calling Get Timetable Example
```PHP
<?php

use DateTimeImmutable;
use TK\SDK\ValueObject;

$departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
$originLocation = new ValueObject\Location('IST', ValueObject\Location::MILTIPLE_AIRPORT_TRUE);
$destinationLocation  = new ValueObject\Location('JFK', ValueObject\Location::MILTIPLE_AIRPORT_TRUE);
$departureDateTime = new ValueObject\DepartureDateTime(
	new DateTimeImmutable($departureTime),
	'P3D',
	'P3D'
);
$originDestinationInformation = new ValueObject\OriginDestinationInformation(
	$departureDateTime,
	$originLocation,
	$destinationLocation
);
$airScheduleRQ = (new ValueObject\AirScheduleRQ($originDestinationInformation))
	->withAirlineCode(ValueObject\AirScheduleRQ::AIRLINE_TURKISH_AIRLINES)
	->withDirectAndNonStopOnlyInd();
$getTimetableParameters = new ValueObject\GetTimetableParameters(
	$airScheduleRQ,
	ValueObject\GetTimetableParameters::SCHEDULE_TYPE_WEEKLY,
	ValueObject\GetTimetableParameters::TRIP_TYPE_ONE_WAY
);

$response = $client->getTimetable($getTimetableParameters);

```

### Disclaimer

This SDK is not officially recognized by Turkish Airlines. 