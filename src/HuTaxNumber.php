<?php
/**
 * Created by PhpStorm.
 * User: nmajsa
 * Date: 2018.03.02.
 * Time: 15:44
 */

namespace Validators;

class HuTaxNumber
{

    const FORMAT_DEFAULT = -1;
    const FORMAT_FORMATTED = 0;
    const FORMAT_JUSTDIGIT = 1;

    private $countieCodes = [
        "02" => "Baranya", "22" => "Baranya",
        "03" => "Bács-Kiskun", "23" => "Bács-Kiskun",
        "04" => "Békés", "24" => "Békés",
        "05" => "Borsod-Abaúj-Zemplén", "25" => "Borsod-Abaúj-Zemplén",
        "06" => "Csongrád", "26" => "Csongrád",
        "07" => "Fejér", "27" => "Fejér",
        "08" => "Győr-Moson-Sopron", "28" => "Győr-Moson-Sopron",
        "09" => "Hajdú-Bihar", "29" => "Hajdú-Bihar",
        "10" => "Heves", "30" => "Heves",
        "11" => "Komárom-Esztergom", "31" => "Komárom-Esztergom",
        "12" => "Nógrád", "32" => "Nógrád",
        "13" => "Pest", "33" => "Pest",
        "14" => "Somogy", "34" => "Somogy",
        "15" => "Szabolcs-Szatmár-Bereg", "35" => "Szabolcs-Szatmár-Bereg",
        "16" => "Jász-Nagykun-Szolnok", "36" => "Jász-Nagykun-Szolnok",
        "17" => "Tolna", "37" => "Tolna",
        "18" => "Vas", "38" => "Vas",
        "19" => "Veszprém", "39" => "Veszprém",
        "20" => "Zala", "40" => "Zala",
        "41" => "Észak-Budapest",
        "42" => "Kelet-Budapest",
        "43" => "Dél-Budapest",
        "44" => "Kiemelt Adózók Adóigazgatósága",
        "51" => "Kiemelt Ügyek Adóigazgatósága",
    ];
    private $vatCodes = [
        1 => "alanyi adómentes adóalany, kizárólag adólevonási joggal nem járó adómentes tevékenységet végzó adóalany Áfa kódja",
        2 => "általános szabályok szerint adózó adóalany Áfa kódja",
        3 => "egyszerűsített vállalkozási adózás (EVA) alá tartozó adóalany Áfa kódja",
        4 => "Áfa körbe tartozó csoportos adóalanyiságot választó adózó Áfa kódja",
        5 => "Áfa körbe tartozó csoportos közös adószám Áfa kódja",
    ];

    private $taxNumber;

    private $primeNumber;
    private $vatCode;
    private $countyCode;

    private $justDigit = 1;

    private $formatCheck = [
        0 => ['regExp' => "/^\d{8}-\d{1}-\d{2}$/", 'message' => "Invalid Taxnumber format [valid format: 99999999-9-99]!"],
        1 => ['regExp' => "/^\d{11}$/", 'message' => "Invalid Taxnumber format [valid format: 99999999999]!"],
    ];

    public function __construct($taxNumber, $justDigit = true)
    {
        $this->justDigit = $justDigit ? 1 : 0;
        $this->taxNumber = $taxNumber;
        $this->checkFormat();
        $this->explodeTaxNumber();
    }

    private function explodeTaxNumber()
    {
        $number = str_replace("-", "", $this->taxNumber);
        $this->primeNumber = substr($number, 0, 8);
        $this->vatCode = substr($number, 8, 1);
        $this->countyCode = substr($number, 9, 2);
    }

    public function checkFormat()
    {

        if (preg_match($this->formatCheck[$this->justDigit]['regExp'], $this->taxNumber))
        {
            return true;
        }
        throw new InvalidTaxNumberFormat($this->formatCheck[$this->justDigit]['message']);

    }

    public function checkCheckDigit()
    {
        $checkDigitGenerator = new GenerateCheckDigit(GenerateCheckDigit::CHECKDIGIT_9731, substr($this->primeNumber,0,7));
        if((integer)substr($this->primeNumber,7, 1) !== $checkDigitGenerator->getCheckDigit()){
            throw new WrongCheckDigit();
        }
        return true;
    }

    public function checkVatCode()
    {
        if(!in_array($this->vatCode, array_keys($this->vatCodes))){
            throw new WrongVatCode();
        }
        return true;
    }
    
    public function checkCountyCode()
    {
        if(!in_array($this->countyCode, array_keys($this->countieCodes))){
            throw new WrongCountyCode();
        }
        return true;
    }

    public function checkTaxNumber(){
        return $this->checkCheckDigit() && $this->checkVatCode() && $this->checkCountyCode();
    }

    public function getFormattedTaxNumber()
    {
        return $this->createTaxNumber(self::FORMAT_FORMATTED);
    }

    public function getTaxNumberDigits()
    {
        return $this->createTaxNumber(self::FORMAT_JUSTDIGIT);
    }

    public function getTaxNumber()
    {
        return $this->createTaxNumber(self::FORMAT_DEFAULT);
    }

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

        return implode($glueMap[$glueType], [$this->primeNumber, $this->vatCode, $this->countyCode]);
    }

    public function getVatCode()
    {
        return $this->vatCode;
    }

    public function getVatCodeInfo()
    {
        return $this->vatCodes[$this->vatCode];
    }

    public function getCountyCode()
    {
        return $this->countyCode;
    }

    public function getCountyCodeInfo()
    {
        return $this->countieCodes[$this->countyCode];
    }

    public function getPrimeNumber()
    {
        return $this->primeNumber;
    }

    public function getEuVatNumber()
    {
        return "HU" . $this->primeNumber;
    }

}