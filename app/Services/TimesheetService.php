<?php

namespace App\Services;

use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use Illuminate\Support\Facades\DB;
use App\Traits\HasStatusHistory;

class TimesheetService
{
    /**
     * Submit a timesheet for approval.
     * SRS Ref: FR-TIME-01-05
     */
    public function submitTimesheet(Timesheet $timesheet)
    {
        return DB::transaction(function () use ($timesheet) {
            // Validate that there are entries
            if ($timesheet->entries()->count() === 0) {
                throw new \Exception("Cannot submit an empty timesheet.");
            }

            $timesheet->logStatusChange('submitted', $timesheet->status);
            return $timesheet;
        });
    }

    public function approveTimesheet(Timesheet $timesheet, int $userId)
    {
        return DB::transaction(function () use ($timesheet, $userId) {
            $timesheet->supervisor_id = $userId;
            $timesheet->logStatusChange('approved', $timesheet->status);
            return $timesheet;
        });
    }

    public function returnTimesheet(Timesheet $timesheet, string $reason)
    {
        return DB::transaction(function () use ($timesheet, $reason) {
            $timesheet->logStatusChange('returned', $timesheet->status, ['reason' => $reason]);
            return $timesheet;
        });
    }
}
