<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\Money;

class MoneyRoundingTest extends TestCase
{
    /**
     * RULE: Rounding Policy
     * Enforcement: Central App\Support\Money: tax = HALF_DOWN, net/pension = HALF_UP.
     */

    public function test_tax_rounding_is_half_down()
    {
        // 10.505 rounded to 2 decimals with HALF_DOWN should be 10.50
        $this->assertEquals(10.50, Money::roundTax(10.505));
        $this->assertEquals(10.51, Money::roundTax(10.514));
    }

    public function test_net_rounding_is_half_up()
    {
        // 10.505 rounded to 2 decimals with HALF_UP should be 10.51
        $this->assertEquals(10.51, Money::roundNet(10.505));
    }

    public function test_pension_rounding_is_half_up()
    {
        $this->assertEquals(10.51, Money::roundPension(10.505));
    }
}
