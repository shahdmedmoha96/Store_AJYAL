<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboaedController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}
