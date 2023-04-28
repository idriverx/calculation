<?php

use App\BinProvider;
use App\CommissionCalculator;
use App\CurrencyRatesProvider;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculateCommissionWithEmptyRow()
    {
        $calculator = new CommissionCalculator('');
        $this->assertNull($calculator->calculateCommission());
    }

    public function testRoundCommission()
    {
        $calculator = new CommissionCalculator('');
        $this->assertEquals(10.01, $calculator->roundCommission(10.005));
        $this->assertEquals(10.00, $calculator->roundCommission(10));
        $this->assertEquals(10.01, $calculator->roundCommission(10.01));
    }

    public function testIsEuReturnsTrueForEUAlpha2Code()
    {
        $calculator = new CommissionCalculator('');
        $this->assertTrue($calculator->isEu('AT'));
    }

    public function testIsEuReturnsFalseForNonEUAlpha2Code()
    {
        $calculator = new CommissionCalculator('');
        $this->assertFalse($calculator->isEu('US'));
    }

    public function testRoundCommissionRoundsUpToTwoDecimalPlaces()
    {
        $calculator = new CommissionCalculator('');
        $this->assertEquals(1.24, $calculator->roundCommission(1.234));
    }
}