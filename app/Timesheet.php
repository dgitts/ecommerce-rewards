<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\Customer;

class Timesheet extends Model
{
    protected $fillable = [
        'employee_id',
        'hours',
        'week_ending',
        'processed'
    ];

    protected $dates = ['week_ending'];

    public function customer()
    {
        return $this->belongsTo('Webkul\Customer\Models\Customer', 'employee_id', 'employee_id');
    }
}
