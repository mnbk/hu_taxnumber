<?php
/**
 * Created by PhpStorm.
 * User: nmajsa
 * Date: 2018.03.03.
 * Time: 6:33
 */

use Validators\HuTaxNumber;
use PHPUnit\Framework\TestCase;

class HuTaxNumberTestJustDigit extends TestCase
{

    public function test_Good_TaxNumber_CheckFormat_JustDigit()
    {
        $taxNumber = new HuTaxNumber("12345678901");
        $this->assertTrue($taxNumber->checkFormat());
    }

    public function test_Empty_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\Validators\InvalidTaxNumberFormat::class);
        $taxNumber = new HuTaxNumber("");
    }

    public function test_Wrong_Short_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\Validators\InvalidTaxNumberFormat::class);
        $taxNumber = new HuTaxNumber("12345678");
    }

    public function test_Wrong_Long_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\Validators\InvalidTaxNumberFormat::class);
        $taxNumber = new HuTaxNumber("123456789012");
    }

    public function test_Wrong_Alpha_TaxNumber_CheckFormat_JustDigit()
    {
        $this->expectException(\Validators\InvalidTaxNumberFormat::class);
        $taxNumber = new HuTaxNumber("123A-6789012");
    }

}
