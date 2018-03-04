<?php
/**
 * Created by PhpStorm.
 * User: nmajsa
 * Date: 2018.03.04.
 * Time: 7:29
 */

namespace Validators;


class GenerateCheckDigit
{

    const CHECKDIGIT_9731 = '9731';

    private $type;
    private $number;

    private $multiplierArrays = [
        self::CHECKDIGIT_9731 => [9, 7, 3, 1]
    ];

    public function __construct($type, $number)
    {

        if(!preg_match("/^\d+$/", $number)){
            throw new InvalidNumberFormat();
        }

        if(!in_array($type, array_keys($this->multiplierArrays))){
            throw new InvalidCheckDigitType();
        }

        $this->type = $type;
        $this->number = (string)$number;

    }

    public function getMultipliedSumForCheckDigit()
    {
        $multiplierCount = count($this->multiplierArrays[$this->type]);

        $total = 0;
        foreach (str_split($this->number) as $place => $number)
        {
            $total += (integer)$number * $this->multiplierArrays[$this->type][$place % $multiplierCount];
        }

        return $total;
    }

    public function getCheckDigit(){

        $checkDigit = $this->getMultipliedSumForCheckDigit();
        return (10 - $checkDigit % 10) % 10;

    }

}