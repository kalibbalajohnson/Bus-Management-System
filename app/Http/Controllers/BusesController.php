<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusesController extends Controller
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
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $buses = DB::select('select * from buses ORDER BY numberPlate ASC');
        $routes = DB::select('select * from routes');
        return view('pages.buses',compact('buses','routes','drivers','codrivers'));
    }

    public function add(Request $request)
    {
        $plate = str_replace(' ', '',strtoupper(request('plate')));
        $routeNo = request('routeNo');
        $driver = request('driver');
        $codriver = request('codriver');
        try {
            DB::insert('INSERT INTO `buses`(`numberPlate`, `routeNo`, `driver`, `codriver`) VALUES (?,?,?,?)', [$plate,$routeNo,$driver,$codriver]);
            $result =  'Bus added successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                // Handle the duplicate entry error here
                $result = 'Duplicate entry error: The bus is already present in the system.';
            }
        }
        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $buses = DB::select('select * from buses ORDER BY numberPlate ASC');
        $routes = DB::select('select * from routes');
        return view('pages.buses',compact('buses','routes','result','drivers','codrivers'));
    }

    
    public function update(Request $request,$plate)
    {
        $newplate = str_replace(' ', '',strtoupper(request('plate')));
        $routeNo = request('routeNo');
        $driver = request('driver');
        $codriver = request('codriver');
        try {
            DB::update('UPDATE `buses` SET `numberPlate`=?,`routeNo`=?,`driver`=?,`codriver`=? WHERE `numberPlate` = ?', [$newplate,$routeNo,$driver,$codriver,$plate]);
            $result =  'Bus details updated successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            $result = 'Error: Bus details not updated not updated.';
        }

        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $buses = DB::select('select * from buses ORDER BY numberPlate ASC');
        $routes = DB::select('select * from routes');
        return view('pages.buses',compact('buses','routes','result','drivers','codrivers'));
    }


    public function delete($plate){
        try {
            DB::delete('DELETE FROM `buses` WHERE `numberPlate`=?',[$plate]);
            $result =  'Bus deleted successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            $result = "Error: Bus not deleted.";
        }

        $drivers = DB::select("select * from staff where position = 'Driver'");
        $codrivers = DB::select("select * from staff where position = 'Co-driver'");
        $buses = DB::select('select * from buses ORDER BY numberPlate ASC');
        $routes = DB::select('select * from routes');
        return view('pages.buses',compact('buses','routes','result','drivers','codrivers'));
    }
}