<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordExpiredRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExpiredPasswordController extends Controller
{
    protected $_config;

    public function __construct()
    {
        $this->_config = request('_config');
    }

    public function create()
    {
        return view($this->_config['view']);
    }

    public function store(PasswordExpiredRequest $request)
    {
        // Verify current password
        if (!Hash::check($request->current_password, auth()->guard('customer')->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
        }

        auth()->guard('customer')->user()->update([
            'password' => bcrypt($request->password),
            'password_changed_at' => Carbon::now()->toDateTimeString()
        ]);

        session()->flash('success', 'Password changed successfully');
        return redirect('/');
    }
}
