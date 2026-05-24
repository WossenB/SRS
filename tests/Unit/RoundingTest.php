<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\Money;

class RoundingTest extends TestCase
{
    public function test_tax_rounding_half_down()
    {
        // 10.555 -> 10.55
        $this->assertEquals(10.55, Money::roundTax(10.555));
        // 10.554 -> 10.55
        $this->assertEquals(10.55, Money::roundTax(10.554));
    }

    public function test_net_pension_rounding_half_up()
    {
        // 10.555 -> 10.56
        $this->assertEquals(10.56, Money::roundNet(10.555));
        $this->assertEquals(10.56, Money::roundPension(10.555));

        // 10.554 -> 10.55
        $this->assertEquals(10.55, Money::roundNet(10.554));
    }
}
