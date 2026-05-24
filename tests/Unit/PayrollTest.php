<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PayrollService;
use App\Support\Money;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TaxSlab;
use App\Models\PensionRate;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;

class PayrollTest extends TestCase
{
    use RefreshDatabase;

    public function test_ethiopian_tax_calculation()
    {
        // Seed tax slabs
        $slabs = [
            ['min_income' => 0, 'max_income' => 600, 'rate' => 0, 'deduction' => 0],
            ['min_income' => 601, 'max_income' => 1650, 'rate' => 10, 'deduction' => 60],
            ['min_income' => 1651, 'max_income' => 3200, 'rate' => 15, 'deduction' => 142.5],
            ['min_income' => 3201, 'max_income' => 5250, 'rate' => 20, 'deduction' => 302.5],
            ['min_income' => 5251, 'max_income' => 7800, 'rate' => 25, 'deduction' => 565],
            ['min_income' => 7801, 'max_income' => 10900, 'rate' => 30, 'deduction' => 955],
            ['min_income' => 10901, 'max_income' => null, 'rate' => 35, 'deduction' => 1500],
        ];
        foreach ($slabs as $s) TaxSlab::create($s);

        $service = new PayrollService();
        $reflect = new \ReflectionClass($service);
        $method = $reflect->getMethod('calculateIncomeTax');
        $method->setAccessible(true);

        // Case 1: 500 ETB (Exempt)
        $this->assertEquals(0, $method->invokeArgs($service, [500, $slabs]));

        // Case 2: 10,000 ETB
        // Tax = (10000 * 0.30) - 955 = 3000 - 955 = 2045
        $this->assertEquals(2045, $method->invokeArgs($service, [10000, $slabs]));

        // Case 3: 20,000 ETB
        // Tax = (20000 * 0.35) - 1500 = 7000 - 1500 = 5500
        $this->assertEquals(5500, $method->invokeArgs($service, [20000, $slabs]));
    }

    public function test_payroll_run_idempotency()
    {
        $user = User::factory()->create();
        $service = new PayrollService();

        $period = '2024-05';
        $service->initiateRun($period, 'regular', $user->id);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Payroll run for this period already exists.");

        $service->initiateRun($period, 'regular', $user->id);
    }
}
