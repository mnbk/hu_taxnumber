<?php

use HuTaxnumberValidators\HuTaxNumber;
use PHPUnit\Framework\TestCase;

class HuTaxNumberTest extends TestCase
{

    public function test_TaxNumber_CheckWrongCheckDigit()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\WrongCheckDigitException::class);
        $taxNumber = new HuTaxNumber("12345678901");
        $taxNumber->verifyCheckDigit();
    }

    public function test_TaxNumber_CheckCheckDigit()
    {
        $taxNumber = new HuTaxNumber("12345676801");
        $this->assertTrue($taxNumber->verifyCheckDigit());
    }

    public function test_TaxNumber_CheckWrongVatCode()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\WrongVatCodeException::class);
        $taxNumber = new HuTaxNumber("12345676801");
        $this->assertTrue($taxNumber->getVatCode()->verify());
    }

    public function test_TaxNumber_CheckVatCode()
    {
        $taxNumber = new HuTaxNumber("12345676101");
        $this->assertTrue($taxNumber->getVatCode()->verify());
    }

    public function test_TaxNumber_CheckWrongCountyCode()
    {
        $this->expectException(\HuTaxnumberValidators\Exception\WrongCountyCodeException::class);
        $taxNumber = new HuTaxNumber("12345676801");
        $this->assertTrue($taxNumber->getCountyCode()->verify());
    }

    public function test_TaxNumber_CheckCountyCode()
    {
        $taxNumber = new HuTaxNumber("12345676102");
        $this->assertTrue($taxNumber->getCountyCode()->verify());
    }

    public function test_TaxNumber_CheckCheckTaxNUmber()
    {
        $taxNumber = new HuTaxNumber("12345676102");
        $this->assertTrue($taxNumber->verify());
    }

    public function test_TaxNumber_getTaxNumber()
    {

        $taxNumber = new HuTaxNumber("12345676102");
        $this->assertEquals("12345676102", $taxNumber->getTaxNumber());

        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertEquals("12345676-1-02", $taxNumber->getTaxNumber());

    }

    public function test_TaxNumber_getFormattedTaxNumber()
    {

        $taxNumber = new HuTaxNumber("12345676102");
        $this->assertEquals("12345676-1-02", $taxNumber->getFormattedTaxNumber());

    }

    public function test_TaxNumber_getTaxNumberDigits()
    {

        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertEquals("12345676102", $taxNumber->getTaxNumberDigits());

    }

    public function test_TaxNumber_getVatCode()
    {
        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertEquals("1", $taxNumber->getVatCode()->getCode());
    }

    public function test_TaxNumber_getVatCodeInfo()
    {
        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertNotEmpty($taxNumber->getVatCode()->getInfo());
    }

    public function test_TaxNumber_getCountyCode()
    {
        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertEquals("02", $taxNumber->getCountyCode()->getCode());
    }

    public function test_TaxNumber_getCountyCodeInfo()
    {
        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertNotEmpty($taxNumber->getCountyCode()->getInfo());
    }

    public function test_TaxNumber_getPrimeNumber()
    {
        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertEquals("12345676", $taxNumber->getPrimeNumber());
    }

    public function test_TaxNumber_getEuVatNumber()
    {
        $taxNumber = new HuTaxNumber("12345676-1-02", false);
        $this->assertEquals("HU12345676", $taxNumber->getEuVatNumber());
    }

}
