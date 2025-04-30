<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SgDashboardController extends Controller
{
    public function index()
    {
        return view('sg.dashboard');
    }
}