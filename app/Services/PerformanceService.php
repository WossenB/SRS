<?php

namespace App\Services;

use App\Models\PerformanceReview;
use App\Models\PerformanceGoal;
use Illuminate\Support\Facades\DB;

class PerformanceService
{
    public function setGoals(int $employeeId, int $cycleId, array $goals)
    {
        return DB::transaction(function () use ($employeeId, $cycleId, $goals) {
            $totalWeight = array_sum(array_column($goals, 'weight'));

            if ($totalWeight !== 100) {
                throw new \Exception("The total weight of goals must sum to exactly 100%. Current sum: {$totalWeight}%");
            }

            PerformanceGoal::where('employee_id', $employeeId)
                ->where('performance_cycle_id', $cycleId)
                ->delete();

            foreach ($goals as $goal) {
                PerformanceGoal::create([
                    'employee_id' => $employeeId,
                    'performance_cycle_id' => $cycleId,
                    'title' => $goal['title'],
                    'description' => $goal['description'],
                    'weight' => $goal['weight'],
                ]);
            }
        });
    }

    public function publishReview(PerformanceReview $review)
    {
        $review->logStatusChange('published', $review->status);
    }
}
