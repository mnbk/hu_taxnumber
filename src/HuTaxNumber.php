<?php

namespace HuTaxnumberValidators;

use HuTaxnumberValidators\Exception\InvalidTaxNumberFormatException;
use HuTaxnumberValidators\Exception\WrongCheckDigitException;

class HuTaxNumber
{

    const FORMAT_DEFAULT = -1;
    const FORMAT_FORMATTED = 0;
    const FORMAT_JUSTDIGIT = 1;

    private $taxNumber;

    private $primeNumber;
    /* @var HuTaxNumberVatCode $vatCode */
    private $vatCode;
    /* @var HuTaxNumberVatCode $vatCode */
    private $countyCode;

    private $justDigit = 1;

    private $formatCheck = [
        0 => ['regExp' => "/^\d{8}-\d{1}-\d{2}$/", 'message' => "Invalid Taxnumber format [valid format: 99999999-9-99]!"],
        1 => ['regExp' => "/^\d{11}$/", 'message' => "Invalid Taxnumber format [valid format: 99999999999]!"],
    ];

    /**
     * HuTaxNumber constructor.
     * @param      $taxNumber
     * @param bool $justDigit
     * @throws InvalidTaxNumberFormatException
     */
    public function __construct($taxNumber, $justDigit = true)
    {
        $this->justDigit = $justDigit ? 1 : 0;
        $this->taxNumber = $taxNumber;
        $this->verifyFormat();
        $this->explodeTaxNumber();
    }

    private function explodeTaxNumber()
    {
        $number = str_replace("-", "", $this->taxNumber);
        $this->primeNumber = substr($number, 0, 8);
        $this->vatCode = new HuTaxNumberVatCode(substr($number, 8, 1));
        $this->countyCode = new HuTaxNumberCountyCode(substr($number, 9, 2));
    }

    /**
     * @return bool
     * @throws InvalidTaxNumberFormatException
     */
    public function verifyFormat()
    {

        if (preg_match($this->formatCheck[$this->justDigit]['regExp'], $this->taxNumber))
        {
            return true;
        }
        throw new InvalidTaxNumberFormatException($this->formatCheck[$this->justDigit]['message']);

    }

    /**
     * @return bool
     * @throws WrongCheckDigitException
     * @throws Exception\InvalidCheckDigitTypeException
     * @throws Exception\InvalidNumberFormatException
     */
    public function verifyCheckDigit()
    {
        $checkDigitGenerator = new CheckDigitGenerator(CheckDigitGenerator::CHECKSUMDIGIT_9731, substr($this->primeNumber,0,7));
        if((integer)substr($this->primeNumber,7, 1) !== $checkDigitGenerator->getCheckDigit()){
            throw new WrongCheckDigitException("Invalid TaxNumber checkdigit!");
        }
        return true;
    }

    /**
     * @return bool
     * @throws WrongCheckDigitException
     * @throws Exception\InvalidCheckDigitTypeException
     * @throws Exception\InvalidNumberFormatException
     * @throws Exception\WrongVatCodeException
     */
    public function verify(){
        return $this->verifyCheckDigit() && $this->vatCode->verify() && $this->countyCode->verify();
    }

    /**
     * @return string
     */
    public function getFormattedTaxNumber()
    {
        return $this->createTaxNumber(self::FORMAT_FORMATTED);
    }

    /**
     * @return string
     */
    public function getTaxNumberDigits()
    {
        return $this->createTaxNumber(self::FORMAT_JUSTDIGIT);
    }

    /**
     * @return string
     */
    public function getTaxNumber()
    {
        return $this->createTaxNumber(self::FORMAT_DEFAULT);
    }

    /**
     * @param $format
     * @return string
     */
    private function createTaxNumber($format)
    {
        $glueMap = ["-", ""];

        switch ($format)
        {
            case self::FORMAT_FORMATTED:
            case self::FORMAT_JUSTDIGIT:
                $glueType = $format;
                break;

            default:
                $glueType = $this->justDigit;
        }

        return implode($glueMap[$glueType], [$this->primeNumber, $this->vatCode->getCode(), $this->countyCode->getCode()]);
    }

    /**
     * @return mixed
     */
    public function getPrimeNumber()
    {
        return $this->primeNumber;
    }

    /**
     * @return string
     */
    public function getEuVatNumber()
    {
        return "HU" . $this->primeNumber;
    }

    /**
     * @return mixed
     */
    public function getVatCode()
    {
        return $this->vatCode;
    }

    /**
     * @return HuTaxNumberVatCode
     */
    public function getCountyCode()
    {
        return $this->countyCode;
    }

}