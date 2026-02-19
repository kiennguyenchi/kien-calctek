<?php

namespace App\Services;

use Exception;

class CalculatorService
{
    public function calculate(string $expression): float
    {
        // Basic validation to prevent code injection and ensure only valid characters are processed
        // This is a temporary fix to use eval() for math execution
        // Better solutions would be to use a proper math expression parser library, or write our own parser
        if (!preg_match('/^([0-9\+\-\*\/\(\)\.\^\s]|sqrt)+$/i', $expression)) {
            throw new Exception("Invalid or unsupported mathematical characters detected.");
        }

        //Removing whitespace
        $expression = str_replace(' ', '', $expression);

        //PHP treats ^ as bitwise logic, so we must convert it to ** for math powers
        $expression = str_replace('^', '**', $expression);

        try {
            $result =  eval('return ' . $expression . ';');
            return $result;
        } catch (\Throwable $e) {
            throw new Exception("Invalid characters entered");
        }
    }
}
