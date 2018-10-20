<?php
declare(strict_types=1);

namespace TK\Test\Unit;

use TypeError;
use Dotenv;
use TK\SDK\Environment;

class EnvironmentTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $apiUrl;
    private $apiKey;
    private $apiSecret;

    protected function _before()
    {
        if (file_exists(__DIR__.'/../../..')) {
            $dotenv = new Dotenv\Dotenv(__DIR__ . '/../..');
            $dotenv->load();
        }
        $this->apiUrl  = getenv('TK_API_URL');
        $this->apiKey  = getenv('TK_API_KEY');
        $this->apiSecret  = getenv('TK_API_SECRET');
    }

    protected function _after()
    {
    }

    /**
     * @test
     */
    public function shouldReturnValuesSuccessfully() : void
    {
        $environment = new Environment($this->apiUrl, $this->apiKey, $this->apiSecret);
        $this->assertEquals($this->apiUrl, $environment->getApiUrl());
        $this->assertEquals($this->apiKey, $environment->getApiKey());
        $this->assertEquals($this->apiSecret, $environment->getApiSecret());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionSuccessfullyForInvalidApiUrl() : void
    {
        $this->expectException(TypeError::class);
        new Environment(null, $this->apiKey, $this->apiSecret);
        new Environment($this->apiUrl, null, $this->apiSecret);
        new Environment($this->apiUrl, $this->apiKey, null);
    }

    /**
     * @test
    */
    public function shouldThrowExceptionSuccessfullyForInvalidApiKey() : void
    {
        $this->expectException(TypeError::class);
        new Environment($this->apiUrl, null, $this->apiSecret);
    }
    /**
     * @test
     */
    public function shouldThrowExceptionSuccessfullyForInvalidApiSecret() : void
    {
        $this->expectException(TypeError::class);
        new Environment($this->apiUrl, $this->apiKey, null);
    }
}
