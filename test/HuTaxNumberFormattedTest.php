<?php

use HuTaxnumberValidators\HuTaxNumber;
use PHPUnit\Framework\TestCase;

class HuTaxNumberFormattedTest extends TestCase
{

    public function test_Good_TaxNumber_CheckFormat_Formatted()
    {
        $taxNumber = new HuTaxNumber("12345678-9-01", false);
        $this->assertTrue($taxNumber->verifyFormat());
    }

    public function test_Empty_TaxNumber_CheckFormat_Formatted()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("");
    }

    public function test_Wrong_Short_TaxNumber_CheckFormat_Formatted()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("12345-678");
    }

    public function test_Wrong_Long_TaxNumber_CheckFormat_Formatted()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("12345678-9-012");
    }

    public function test_Wrong_Alpha_TaxNumber_CheckFormat_Formatted()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("123A678-9-BB");
    }

}
