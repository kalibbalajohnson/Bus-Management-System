<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
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
        $staff = DB::select('SELECT * FROM `staff` ');
        $positions = DB::select('SELECT DISTINCT `position` FROM `staff` ');
        return view('pages.staff',compact('staff','positions'));
    }

    public function add(Request $request)
    {
        $name = request('name');
        $position = request('position');
        $telephone = request('telephone');
        $permit = request('permitNo');
        $result = 'Error: No action performed.';
        
        try {
            DB::insert('INSERT INTO `staff`(`name`, `position`, `telephone`, `permitNo`) VALUES (?,?,?,?)', [$name,$position,$telephone,$permit]);
            $result =  'Staff member added successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                // Handle the duplicate entry error here
                $result = 'Duplicate entry error: The staff member is already present in the system.';
            }
        }

        $staff = DB::select('SELECT * FROM `staff` ');
        $positions = DB::select('SELECT DISTINCT `position` FROM `staff` ');
        return view('pages.staff',compact('staff','positions','result'));
    }

    public function update($staff)
    {
        $name = request('name');
        $position = request('position');
        $telephone = request('telephone');
        $permit = request('permitNo');
        $result = 'Error: No action performed.';

        try {
            DB::insert('UPDATE `staff` SET `name`=?,`position`=?,`telephone`=?,`permitNo`=? WHERE `staffNo` = ?', [$name,$position,$telephone,$permit,$staff]);
            $result =  'Staff member added successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                // Handle the duplicate entry error here
                $result = 'Duplicate entry error: The staff member is already present in the system.';
            }
        }

        $staff = DB::select('SELECT * FROM `staff` ');
        $positions = DB::select('SELECT DISTINCT `position` FROM `staff` ');
        return view('pages.staff',compact('staff','positions','result'));
    }

    public function delete($staff){
        try {
            DB::delete('DELETE FROM `staff` WHERE `staffNo`=?',[$staff]);
            $result =  'Staff member deleted successfully.';
        } catch (\Illuminate\Database\QueryException $exception) {
            $result = "Error: Staff member not deleted.";
        }

        $staff = DB::select('SELECT * FROM `staff` ');
        $positions = DB::select('SELECT DISTINCT `position` FROM `staff` ');
        return view('pages.staff',compact('staff','positions','result'));
    }
}
