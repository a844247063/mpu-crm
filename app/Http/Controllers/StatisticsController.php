<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Department;
use App\Models\Enquiry;
use App\Models\EnquiryResponse;
use Mail;

class StatisticsController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Department::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 获取所有询问
        $enquiries = Enquiry::all(); 
            dd($enquiries);
    
    
        return Inertia::render('Statistics', [
          
            'enquiries' => $enquiries, 
            'fields' => Config::enquiryFormFields(), 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Enquiry $enquiry)
    {
        $this->authorize('view',$enquiry->department);
        //$enquiry=$enquiry->with('responses');
        $enquiry->department;
        $enquiry->questions;
        return Inertia::render('Department/Enquiry/EnquiryShow',[
            'fields'=>Config::enquiryFormFields(),
            'enquiry'=>$enquiry,
        ]);
    }


   

    
}
