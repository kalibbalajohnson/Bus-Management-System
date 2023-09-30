<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutesController extends Controller
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
        $routes = DB::select('select * from routes');
        return view('pages.routes',compact('routes'));
    }

    public function add(Request $request)
    {
        $destination = request('destination');
        $distance = request('distance');
        $cost = request('cost');
        try {
            DB::insert('INSERT INTO routes (`destination`,`distance`,`cost`) VALUES (?,?,?)', [$destination,$distance,$cost]);
            $result = "Route added successfully.";
            
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                // Handle the duplicate entry error here
                $result = 'Duplicate entry error: The destination you are trying to add is already present in the system.';
            }
        }

        $routeNo = DB::select('SELECT `routeNo` FROM `routes` WHERE `destination` = ?',[$destination]);
        DB::insert('INSERT INTO stops (`routeNo`,`stop`,`distance`,`cost`) VALUES (?,?,?,?)', [$routeNo[0]->routeNo,$destination,$distance,$cost]);

        $routes = DB::select('select * from routes');
        return view('pages.routes',compact('result','routes'));
    }
    
    public function delete(Request $request,$route)
    {
        try {
            DB::delete('DELETE FROM `routes` WHERE routeNo=? ',[$route]);
            $result =  'Route deleted successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            $result = "Error: Route not deleted.";
        }

        $routes = DB::select('select * from routes');
        return view('pages.routes',compact('result','routes'));
    }
    public function update (Request $request,$route)
    {
        $route_old = DB::select('SELECT * FROM `routes` WHERE `routeNo` = ?',[$route]);
        $destination = request('destination');
        $distance = request('distance');
        $cost = request('cost');
        try {
            DB::update('UPDATE `routes` SET `destination`=?,`distance`=?,`cost`=? WHERE `routeNo`=? ', [$destination,$distance,$cost,$route]);
            $result = "Route details updated successfully.";            
        } catch (\Illuminate\Database\QueryException $exception) {
            $result = "Error: Route details not updated.";
        }

        DB::update('UPDATE `stops` SET `stop`=?,`distance`=?,`cost`=? WHERE `routeNo`=? AND `stop`=?', [$destination,$distance,$cost,$route_old[0]->routeNo,$route_old[0]->destination]);
 
        $route = DB::select('SELECT * FROM `routes` WHERE `routeNo` = ?',[$route]);
        $stops = DB::select('SELECT * FROM stops where routeNo =? AND `stop` <> ? ORDER BY distance ASC',[$route[0]->routeNo,$route[0]->destination]);
        return view('pages.stops',compact('stops','route'));
    }

}