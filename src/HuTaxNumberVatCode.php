<?php

namespace HuTaxnumberValidators;


use HuTaxnumberValidators\Exception\WrongVatCodeException;

class HuTaxNumberVatCode
{
    private $vatCodes = [
        1 => "alanyi adómentes adóalany, kizárólag adólevonási joggal nem járó adómentes tevékenységet végzó adóalany Áfa kódja",
        2 => "általános szabályok szerint adózó adóalany Áfa kódja",
        3 => "egyszerűsített vállalkozási adózás (EVA) alá tartozó adóalany Áfa kódja",
        4 => "Áfa körbe tartozó csoportos adóalanyiságot választó adózó Áfa kódja",
        5 => "Áfa körbe tartozó csoportos közös adószám Áfa kódja",
    ];

    private $code;

    /**
     * HuTaxNumberVatCode constructor.
     * @param $vatCode
     */
    public function __construct($vatCode)
    {
        $this->code = $vatCode;
    }

    /**
     * @return bool
     * @throws WrongVatCodeException
     */
    public function verify()
    {
        if(!in_array($this->code, array_keys($this->vatCodes))){
            throw new WrongVatCodeException();
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->vatCodes[$this->code];
    }

}