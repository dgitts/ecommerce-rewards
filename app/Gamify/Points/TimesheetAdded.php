<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class TimesheetAdded extends PointType
{
    // prevent duplicate point
    public $allowDuplicates = false;

    protected $payee = 'customer';

    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function getPoints()
    {
        return $this->getSubject()->hours;
    }
}
