<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'id',
        'firstName',
        'lastName',
        'email',
        'cellPhone'
    ];
}
