<?php

namespace Tests\Unit;

use App\Services\CalculatorService;
use PHPUnit\Framework\TestCase;
use Exception;

class CalculatorServiceTest extends TestCase
{
    protected $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new CalculatorService();
    }

    public function test_it_calculates_simple_addition(): void
    {
        $result = $this->calculator->calculate('5 + 5');
        $this->assertEquals(10, $result);
    }

    public function test_it_handles_operator_precedence(): void
    {
        $result = $this->calculator->calculate('5 + 2 * 10');
        $this->assertEquals(25, $result);
    }

    public function test_it_calculates_complex_expressions_with_parentheses(): void
    {
        $result = $this->calculator->calculate('(10 + 2) / 4');
        $this->assertEquals(3, $result);
    }

    public function test_it_handles_exponentiation(): void
    {
        $result = $this->calculator->calculate('2 ^ 3');
        $this->assertEquals(8, $result);
    }

    public function test_it_throws_exception_for_invalid_characters(): void
    {
        $this->expectException(Exception::class);
        $this->calculator->calculate('5 + 2a');
    }

    public function test_it_handles_division_by_zero_gracefully(): void
    {
        $this->expectException(\Throwable::class);
        $this->calculator->calculate('10 / 0');
    }

    public function test_it_with_stretch_goals_requirements(): void
    {
        // In the stretch goal, the complex expression contains extra parenthese ) at the end
        // Requirement:     sqrt((((9*9)/12)+(13-4))*2)^2)
        // Should be:       sqrt((((9*9)/12)+(13-4))*2)^2
        $result = $this->calculator->calculate('sqrt((((9*9)/12)+(13-4))*2)^2');
        $this->assertEquals(31.5, $result);
    }
}
