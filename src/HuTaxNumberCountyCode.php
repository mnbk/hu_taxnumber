<?php
/**
 * Created by PhpStorm.
 * User: nmajsa
 * Date: 2018.03.04.
 * Time: 17:54
 */

namespace Validators;


use Validators\exceptions\WrongCountyCodeException;

class HuTaxNumberCountyCode
{
    private $countyCodes = [
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

    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function verify()
    {
        if(!in_array($this->code, array_keys($this->countyCodes))){
            throw new WrongCountyCodeException("Invalid county code!");
        }
        return true;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getInfo()
    {
        return $this->countyCodes[$this->code];
    }

}