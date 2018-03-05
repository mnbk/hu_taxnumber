<?php

namespace HuTaxnumberValidators;


use HuTaxnumberValidators\Exception\InvalidCheckDigitTypeException;
use HuTaxnumberValidators\Exception\InvalidNumberFormatException;

class CheckDigitGenerator
{

    const CHECKSUMDIGIT_9731 = 1;

    private $type;
    private $number;

    private $multiplierArrays = [
        self::CHECKSUMDIGIT_9731 => [9, 7, 3, 1]
    ];

    /**
     * CheckDigitGenerator constructor.
     * @param $type
     * @param $number
     * @throws InvalidCheckDigitTypeException
     * @throws InvalidNumberFormatException
     */
    public function __construct($type, $number)
    {

        if(!preg_match("/^\d+$/", $number)){
            throw new InvalidNumberFormatException();
        }

        if(!in_array($type, array_keys($this->multiplierArrays))){
            throw new InvalidCheckDigitTypeException();
        }

        $this->type = $type;
        $this->number = (string)$number;

    }

    /**
     * @return float|int
     */
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

    /**
     * @return int
     */
    public function getCheckDigit(){

        $checkDigit = $this->getMultipliedSumForCheckDigit();
        return (10 - $checkDigit % 10) % 10;

    }

}