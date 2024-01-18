<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Department;
use App\Models\Enquiry;
use App\Models\EnquiryResponse;
use Mail;
use Carbon\Carbon;

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
    public function Statistics()
    {
        $enquiryAll = Enquiry::all();         
  
        $enquiriesWithHour = $enquiryAll->map(function ($enquiry) {      
            $hour = Carbon::parse($enquiry->created_at)->format('H');
            $enquiry->hour = $hour;
    
            return $enquiry;
        });
        
    
        return Inertia::render('Statistics', [
            'enquiriesWithHour' => $enquiriesWithHour,
            'enquiryAll' => $enquiryAll, 
            'fields' => Config::enquiryFormFields(), 
        ]);
    }


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
 


   

    
}
