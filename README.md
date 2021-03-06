# Turkish Airlines' TK API Unofficial PHP API

[![Build Status](https://api.travis-ci.org/mkorkmaz/tk-api-php-client.svg?branch=master)](https://travis-ci.org/mkorkmaz/tk-api-php-client) 
[![Coverage Status](https://coveralls.io/repos/github/mkorkmaz/tk-api-php-client/badge.svg?branch=master)](https://coveralls.io/github/mkorkmaz/tk-api-php-client?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mkorkmaz/tk-api-php-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mkorkmaz/tk-api-php-client/?branch=master) 

See the official documentation at [Turkish Airlines Developer Portal](https://developer.turkishairlines.com/)

To use this library, one has to create a developer account on Developer Portal and create an application to get required API Key and API Secret.


### Installation

```bash
composer require mkorkmaz/tk-api-php-client
```

### Configuration

Put your API Key and API Secret securely in a configuration file or .env etc. Since calling an API endpoint is rate-limited, it is important to secure these information.

Use https://api.turkishairlines.com/test as your api test url during development.


### Creating API Client


```PHP
<?php

include 'vendor/autoload.php';
use TK\API\ClientBuilder;

$client = ClientBuilder::create()
	->setEnvironment(getenv('TK_API_URL'), getenv('TK_API_KEY'), getenv('TK_API_SECRET'))
	->build();
```

### Endpoints

[See the list of endpoints](docs/endpoints/index.md)
### Disclaimer

This TK API Client Library is not officially recognized by Turkish Airlines. 
