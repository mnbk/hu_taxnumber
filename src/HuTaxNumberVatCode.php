<?php
/**
 * Created by PhpStorm.
 * User: nmajsa
 * Date: 2018.03.04.
 * Time: 17:54
 */

namespace Validators;


use Validators\exceptions\WrongVatCodeException;

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

    public function __construct($vatCode)
    {
        $this->code = $vatCode;
    }

    public function verify()
    {
        if(!in_array($this->code, array_keys($this->vatCodes))){
            throw new WrongVatCodeException();
        }
        return true;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getInfo()
    {
        return $this->vatCodes[$this->code];
    }

}