# Turkish Airlines API PHP SDK (Unofficial)

Documentation needs to be updated.


### Creating API Client


```PHP
use TK\SDK\ClientBuilder;
use DateTimeImmutable;
use TK\SDK\ValueObject;

$client = ClientBuilder::create()
	->setEnvironment(getenv('TK_API_URL'), getenv('TK_API_KEY'), getenv('TK_API_SECRET'))
	->build();
```
### Calling Get Timetable Example
```PHP
$departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
$originLocation = new ValueObject\Location('IST', true);
$destinationLocation  = new ValueObject\Location('JFK', true);
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