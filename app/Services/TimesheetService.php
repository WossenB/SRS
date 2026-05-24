<?php

namespace App\Services;

use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use App\Models\Employee;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TimesheetService
{
    public function createWeeklyTimesheet(Employee $employee, \Carbon\Carbon $weekStart)
    {
        return DB::transaction(function () use ($employee, $weekStart) {
            $existing = Timesheet::where('employee_id', $employee->id)
                ->where('week_start', $weekStart->format('Y-m-d'))
                ->first();

            if ($existing) return $existing;

            $timesheet = Timesheet::create([
                'employee_id' => $employee->id,
                'week_start' => $weekStart->format('Y-m-d'),
                'week_end' => $weekStart->copy()->addDays(6)->format('Y-m-d'),
                'status' => 'draft',
            ]);

            $schedule = WorkSchedule::where('is_default', true)->first();
            $workingDays = $schedule?->working_days_json ?? ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

            for ($i = 0; $i < 7; $i++) {
                $date = $weekStart->copy()->addDays($i);
                $dayName = $date->format('l');

                TimesheetEntry::create([
                    'timesheet_id' => $timesheet->id,
                    'date' => $date->format('Y-m-d'),
                    'day_of_week' => $dayName,
                    'hours_worked' => in_array($dayName, $workingDays) ? ($schedule->standard_hours ?? 8) : 0,
                    'overtime_hours' => 0,
                    'is_working_day' => in_array($dayName, $workingDays),
                ]);
            }

            return $timesheet;
        });
    }

    public function submitTimesheet(Timesheet $timesheet, array $entries)
    {
        return DB::transaction(function () use ($timesheet, $entries) {
            if (empty($entries)) throw new \Exception('Timesheet must have entries.');

            foreach ($entries as $entryId => $data) {
                TimesheetEntry::where('id', $entryId)->update([
                    'hours_worked' => $data['hours_worked'],
                    'overtime_hours' => $data['overtime_hours'] ?? 0,
                    'remarks' => $data['remarks'] ?? null,
                ]);
            }

            $timesheet->status = 'submitted';
            $timesheet->submitted_at = now();
            $timesheet->submitted_by = Auth::id();
            $timesheet->save();

            $timesheet->logStatusChange('submitted', 'draft');

            return $timesheet;
        });
    }

    public function approveBySupervisor(Timesheet $timesheet)
    {
        return DB::transaction(function () use ($timesheet) {
            $timesheet->status = 'approved';
            $timesheet->supervisor_approved_by = Auth::id();
            $timesheet->supervisor_approved_at = now();
            $timesheet->save();

            $timesheet->logStatusChange('approved', 'submitted');

            return $timesheet;
        });
    }
}
