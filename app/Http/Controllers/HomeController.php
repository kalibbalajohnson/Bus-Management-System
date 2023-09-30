<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {   
        $routes = DB::select('select * from routes');
        $stops = DB::select('SELECT * FROM stops');
        $buses = DB::select('select * from buses ');
        $parked = DB::select("SELECT * FROM `buses` WHERE `status` = 'Parked' ");
        $loading = DB::select("SELECT * FROM `buses` WHERE `status` = 'Loading' ");
        $travelling = DB::select("SELECT * FROM `buses` WHERE `status` = 'Travelling' ");
        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $passes = DB::select('select * from passes');        
        $customers = DB::select('SELECT DISTINCT `telephone` FROM `passes` ');
        $sum = DB::select('SELECT SUM(cost) AS sum FROM passes');
        return view('pages.dashboard',compact('routes','stops','buses','parked','loading','travelling','drivers','codrivers','passes','sum','customers'));
    }

    public function loadbus($bus)
    {
        $status = 'Loading';
        DB::update('UPDATE `buses` SET `status`=? WHERE `numberPlate`=?',[$status,$bus]);

        for ($i=1; $i < 68; $i++) { 
            DB::insert('INSERT INTO `seats`(`numberPlate`, `seatNo`) VALUES (?,?)',[$bus,$i]);
        }


        $routes = DB::select('select * from routes');
        $stops = DB::select('SELECT * FROM stops');
        $buses = DB::select('select * from buses ');
        $parked = DB::select("SELECT * FROM `buses` WHERE `status` = 'Parked' ");
        $loading = DB::select("SELECT * FROM `buses` WHERE `status` = 'Loading' ");
        $travelling = DB::select("SELECT * FROM `buses` WHERE `status` = 'Travelling' ");
        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $passes = DB::select('select * from passes');
        $customers = DB::select('SELECT DISTINCT `telephone` FROM `passes` ');
        $sum = DB::select('SELECT SUM(cost) AS sum FROM passes');
        return view('pages.dashboard',compact('routes','stops','buses','parked','loading','travelling','drivers','codrivers','passes','sum','customers'));
    }

    public function setoffbus($bus)
    {
        $status = 'Travelling';
        DB::update('UPDATE `buses` SET `status`=? WHERE `numberPlate`=?',[$status,$bus]);

        DB::delete('DELETE FROM `seats` WHERE `numberPlate`=?',[$bus]);

        $routes = DB::select('select * from routes');
        $stops = DB::select('SELECT * FROM stops');
        $buses = DB::select('select * from buses ');
        $parked = DB::select("SELECT * FROM `buses` WHERE `status` = 'Parked' ");
        $loading = DB::select("SELECT * FROM `buses` WHERE `status` = 'Loading' ");
        $travelling = DB::select("SELECT * FROM `buses` WHERE `status` = 'Travelling' ");
        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $passes = DB::select('select * from passes');
        $customers = DB::select('SELECT DISTINCT `telephone` FROM `passes` ');
        $sum = DB::select('SELECT SUM(cost) AS sum FROM passes');
        return view('pages.dashboard',compact('routes','stops','buses','parked','loading','travelling','drivers','codrivers','passes','sum','customers'));
    }

    public function parkbus($bus)
    {
        $status = 'Parked';
        DB::update('UPDATE `buses` SET `status`=? WHERE `numberPlate`=?',[$status,$bus]);

        DB::delete('DELETE FROM `seats` WHERE `numberPlate`=?',[$bus]);

        $routes = DB::select('select * from routes');
        $stops = DB::select('SELECT * FROM stops');
        $buses = DB::select('select * from buses ');
        $parked = DB::select("SELECT * FROM `buses` WHERE `status` = 'Parked' ");
        $loading = DB::select("SELECT * FROM `buses` WHERE `status` = 'Loading' ");
        $travelling = DB::select("SELECT * FROM `buses` WHERE `status` = 'Travelling' ");
        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $passes = DB::select('select * from passes');
        $customers = DB::select('SELECT DISTINCT `telephone` FROM `passes` ');
        $sum = DB::select('SELECT SUM(cost) AS sum FROM passes');
        return view('pages.dashboard',compact('routes','stops','buses','parked','loading','travelling','drivers','codrivers','passes','sum','customers'));
    }
}
