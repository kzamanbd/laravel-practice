<?php

namespace App\Services;

class Calculator
{
    /**
     * Adds two numbers.

     * @param  mixed $firstNumber
     * @param  mixed $secondNumber
     * @return mixed
     */
    public function addition($firstNumber, $secondNumber)
    {
        return $firstNumber + $secondNumber;
    }

    /**
     * Subtracts two numbers.

     * @param  mixed $firstNumber
     * @param  mixed $secondNumber
     * @return mixed
     */
    public function subtraction($firstNumber, $secondNumber)
    {
        return $firstNumber - $secondNumber;
    }

    /**
     * Multiplies two numbers.

     * @param  mixed $firstNumber
     * @param  mixed $secondNumber
     * @return mixed
     */
    public function multiplication($firstNumber, $secondNumber)
    {
        return $firstNumber * $secondNumber;
    }
}
