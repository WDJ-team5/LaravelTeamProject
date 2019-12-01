<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRmind()
    {
        return view('passwords.remind');
    }

    public function postRmind()
    {
        
    }

}
