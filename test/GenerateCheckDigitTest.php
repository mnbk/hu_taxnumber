<?php
/**
 * Created by PhpStorm.
 * User: nmajsa
 * Date: 2018.03.04.
 * Time: 7:37
 */

use Validators\GenerateCheckDigit;
use PHPUnit\Framework\TestCase;

class GenerateCheckDigitTest extends TestCase
{

    public function test_InvalidNumberFormat()
    {
        $this->expectException(\Validators\InvalidNumberFormat::class);
        $checkDigitGenerator = new GenerateCheckDigit(GenerateCheckDigit::CHECKDIGIT_9731, "asd987");
    }

    public function test_InvalidCheckDigitType()
    {
        $this->expectException(\Validators\InvalidCheckDigitType::class);
        $checkDigitGenerator = new GenerateCheckDigit(999876, "123456");
    }

    public function test_CheckDigitSum_9731()
    {
        $checkDigitGenerator = new GenerateCheckDigit(GenerateCheckDigit::CHECKDIGIT_9731, "123456");
        $this->assertEquals(123, $checkDigitGenerator->getMultipliedSumForCheckDigit());
    }

    public function test_CheckDigit_9731()
    {
        $checkDigitGenerator = new GenerateCheckDigit(GenerateCheckDigit::CHECKDIGIT_9731, 123456);
        $this->assertEquals(7, $checkDigitGenerator->getCheckDigit());
    }

}
