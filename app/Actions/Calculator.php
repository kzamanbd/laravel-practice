<?php

namespace App\Actions;

class Calculator
{
    /**
     * Adds two numbers.
     * @param int $firstNumber
     * @param int $secondNumber
     * @return int
     */
    public function addition(int $firstNumber, int $secondNumber): int
    {
        return $firstNumber + $secondNumber;
    }

    /**
     * Subtracts two numbers.
     * @param int $firstNumber
     * @param int $secondNumber
     * @return int
     */
    public function subtraction(int $firstNumber, int $secondNumber): int
    {
        return $firstNumber - $secondNumber;
    }

    /**
     * Multiplies two numbers.
     * @param int $firstNumber
     * @param int $secondNumber
     * @return int
     */
    public function multiplication(int $firstNumber, int $secondNumber): int
    {
        return $firstNumber * $secondNumber;
    }
}
