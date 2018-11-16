<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\API\Exception\InvalidArgumentException;
use TK\API\ValueObject\Factory\RetrieveReservationDetailParametersFactory;
use TK\API\ValueObject\RetrieveReservationDetailParameters;

class RetrieveReservationDetailParametersFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @test
     * @throws \Exception
     */
    public function shouldReturnRetrieveReservationDetailParameters() : void
    {
        $json =<<<JSON
{
    "UniqueId": "TT8VN8",
    "Surname": "CELIKTAS"
}
JSON;
        $parameterObject = RetrieveReservationDetailParametersFactory::createFromJson($json);
        $this->assertInstanceOf(RetrieveReservationDetailParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }

    /**
     * @test
     * @throws \Exception
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidJson() : void
    {
        $json =<<<JSON
{
    "UniqueId: "TT8VN8",
    "Surname": "CELIKTAS"
}
JSON;
        RetrieveReservationDetailParametersFactory::createFromJson($json);
    }
}
