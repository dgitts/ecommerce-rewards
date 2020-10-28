<?php

namespace App\Imports;

use App\Jobs\ProcessTimesheet;
use App\Timesheet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TimesheetImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $timesheet = Timesheet::firstOrCreate([
                'employee_id' => $row['employee_id'],
                'week_ending' => Carbon::make($row['date']),
            ]);
            $timesheet->hours = $row['total'];
            $timesheet->save();
            ProcessTimesheet::dispatch($timesheet);
        }
    }
}
