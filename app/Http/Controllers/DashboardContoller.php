<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardContoller extends Controller
{
    // we can use this or in the route
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        return view('dashboard');
    }
}
