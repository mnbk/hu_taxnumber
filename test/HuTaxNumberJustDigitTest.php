<?php

use HuTaxnumberValidators\HuTaxNumber;
use PHPUnit\Framework\TestCase;

class HuTaxNumberJustDigitTest extends TestCase
{

    public function test_Good_TaxNumber_CheckFormat_JustDigit()
    {
        $taxNumber = new HuTaxNumber("12345678901");
        $this->assertTrue($taxNumber->verifyFormat());
    }

    public function test_Empty_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("");
    }

    public function test_Wrong_Short_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("12345678");
    }

    public function test_Wrong_Long_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("123456789012");
    }

    public function test_Wrong_Alpha_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException::class);
        $taxNumber = new HuTaxNumber("123A-6789012");
    }

}
