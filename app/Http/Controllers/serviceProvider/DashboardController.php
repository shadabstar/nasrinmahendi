<?php

namespace App\Http\Controllers\serviceProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view("service_provider.dashboard");
    }
}
