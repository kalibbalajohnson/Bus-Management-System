<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PassController extends Controller
{
    public function create()
    {        
        $routes = DB::select('select * from routes');
        $stops = DB::select('SELECT * FROM stops ORDER BY distance ASC');
        $buses = DB::select("SELECT * FROM `buses` WHERE `status` = 'Loading'");
        $seats = DB::select('select * from seats');          
        return view('pages.pass',compact('routes','stops','buses','seats'));
    }

    public function print()
    {
        $station = 'Kampala-';
        $name = request('name');
        $telephone = request('telephone');
        $journey = $station.request('stop');
        $bus = request('bus');
        $seatNo = request('seatNo');
        $cost = request('cost');

        DB::insert('INSERT INTO `passes`(`name`, `telephone`, `journey`, `bus`, `seatNo`, `cost`) VALUES (?,?,?,?,?,?)',[$name,$telephone,$journey,$bus,$seatNo,$cost]);

        DB::delete('DELETE FROM `seats` WHERE `numberPlate` =? AND `seatNo` =?',[$bus,$seatNo]);
                 
        return view('pages.thank');
    }
}
