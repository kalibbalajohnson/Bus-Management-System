<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PassesController extends Controller
{
    public function index()
    {   
        $passes = DB::select('select * from passes');
        return view('pages.passes',compact('passes'));
    }
}
