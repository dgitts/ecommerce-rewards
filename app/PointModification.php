<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointModification extends Model
{
    protected $fillable = [
        'employee_id',
        'points',
        'notes',
        'processed',
        'add'
    ];

    public function customer()
    {
        return $this->belongsTo('Webkul\Customer\Models\Customer', 'employee_id', 'employee_id');
    }
}
