<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Imports\TimesheetImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    protected $_config;

    public function __construct()
    {
        $this->_config = request('_config');

        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        return view($this->_config['view']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file'    => 'required',
        ]);

        Excel::import(new TimesheetImport(), $request->file('file'));

        session()->flash('success', trans('app.response.import-success', ['name' => 'Timesheet']));

        return redirect()->route($this->_config['redirect']);
    }
}
