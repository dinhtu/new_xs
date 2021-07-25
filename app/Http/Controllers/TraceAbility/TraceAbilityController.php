<?php

namespace App\Http\Controllers\TraceAbility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TraceAbilityController extends Controller
{
    public function index()
    {
        return view('traceAbility.index');
    }

    public function edit()
    {
        return view('traceAbility.edit');
    }
}
