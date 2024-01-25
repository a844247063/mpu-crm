<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AdminUser;
use App\Models\Department;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Department::class);
    }

    public function index()
    {
        session()->forget('department');
        //dd(Department::whereIn('abbr',auth()->user()->roles->pluck('name'))->first());
       // session(['department'=>Department::whereIn('abbr',auth()->user()->roles->pluck('name'))->first()]);
        //$defaultRoute=auth()->user()->roles->first()->default_route;
        // if(session('department')->default_route){
        //     return redirect()->route(session('department')->default_route);
        // }

        return Inertia::render('Department/Dashboard',[
            'departments' => Department::all(),
        ]);

    }

    public function masqueradeAdminUser(Department $department){
        session()->forget('department');
        session(['department'=>$department]);
        if(session('department')->default_route){
            return redirect()->route(session('department')->default_route);
        }

        return Inertia::render('Department/Dashboard',[
            'departments' => Department::all(),
        ]);
    }
    
}
