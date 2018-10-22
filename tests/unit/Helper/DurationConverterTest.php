<?php
namespace TK\Test\Unit\Helper;

use TK\SDK\Helper\DurationConverter;

class DurationConverterTest extends \Codeception\Test\Unit
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
     */
    public function shouldConvertDurationToSecondsSuccessfully() : void
    {
        $duration = 'P0Y0M0DT1H5M0S';
        $expected = 1*60*60 + 5*60 + 0;
        $result = DurationConverter::toSeconds($duration);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldConvertDurationToYearSuccessfully() : void
    {
        $duration = 'P1Y9M4DT1H5M0S';
        $expected = round(1 + 9*30/365 + 4/365 + 1/365/60 + 5/365/60/60, 2);
        $result = DurationConverter::toYear($duration);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldConvertDurationToMonthSuccessfully() : void
    {
        $duration = 'P0Y9M4DT1H5M0S';
        $expected = round( 9*30/365 + 4/365 + 1/365/60 + 5/365/60/60, 2);
        $result = DurationConverter::toYear($duration);
        $this->assertEquals($expected, $result);
    }
}
