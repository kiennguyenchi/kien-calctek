<?php

namespace App\Services;

use Exception;
use NXP\MathExecutor;

class CalculatorService
{
    public function calculate(string $expression): float
    {
        if (!preg_match('/^([0-9\+\-\*\/\(\)\.\^\s]|sqrt)+$/i', $expression)) {
            throw new Exception("Invalid or unsupported mathematical characters detected.");
        }

        //Removing whitespace
        $expression = str_replace(' ', '', $expression);

        try {
            $executor = new MathExecutor();
            return $executor->execute($expression);
        } catch (Exception $e) {
            throw new Exception("Invalid characters entered");
        }
    }
}
