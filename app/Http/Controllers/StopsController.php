<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StopsController extends Controller
{
    public function index($route){
        $route = DB::select('SELECT * FROM `routes` WHERE `routeNo` = ?',[$route]);
        $stops = DB::select('SELECT * FROM stops where routeNo =? AND `stop` <> ? ORDER BY distance ASC',[$route[0]->routeNo,$route[0]->destination]);
        return view('pages.stops',compact('stops','route'));
    }

    public function add(Request $request,$route)
    {
        $stop = request('stop');
        $distance = request('distance');
        $cost = request('cost');
        $result = "Stop not added";
        try {
            DB::insert('INSERT INTO stops (`routeNo`,`stop`,`distance`,`cost`) VALUES (?,?,?,?)', [$route,$stop,$distance,$cost]);
            $result =  'Stop inserted successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                // Handle the duplicate entry error here
                $result = 'Duplicate entry error: The stop, "'.$stop.'", is already present in the system.';
            }
        }
        $route = DB::select('SELECT * FROM `routes` WHERE `routeNo` = ?',[$route]);
        $stops = DB::select('SELECT * FROM stops where routeNo =? AND `stop` <> ? ORDER BY distance ASC',[$route[0]->routeNo,$route[0]->destination]);
        return view('pages.stops',compact('stops','route'));
    }

    public function update(Request $request,$route,$stop)
    {
        $newstop = request('stop');
        $distance = request('distance');
        $cost = request('cost');
        $result = "Stop not added";
        try {
            DB::update('UPDATE `stops` SET `stop`= ?,`distance`= ? ,`cost`= ? WHERE `routeNo` = ? AND `stop` = ?', [$newstop,$distance,$cost,$route,$stop]);
            $result =  'Stop updated successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                // Handle the duplicate entry error here
                $result = 'Duplicate entry error: The stop, "'.$stop.'", is already present in the system.';
            }
        }
        $route = DB::select('SELECT * FROM `routes` WHERE `routeNo` = ?',[$route]);
        $stops = DB::select('SELECT * FROM stops where routeNo =? AND `stop` <> ? ORDER BY distance ASC',[$route[0]->routeNo,$route[0]->destination]);
        return view('pages.stops',compact('stops','route'));
    }


    public function delete($route,$stop){
        try {
            DB::delete('DELETE FROM `stops` WHERE routeNo=? AND stop=? ',[$route,$stop]);
            $result =  'Stop deleted successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            $result = "Error: Stop not deleted.";
        }

        $route = DB::select('SELECT * FROM `routes` WHERE `routeNo` = ?',[$route]);
        $stops = DB::select('SELECT * FROM stops where routeNo =? AND `stop` <> ? ORDER BY distance ASC',[$route[0]->routeNo,$route[0]->destination]);
        return view('pages.stops',compact('stops','route'));
    }
}
