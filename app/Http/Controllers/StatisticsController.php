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
    public function Statistics()
    {
        $enquiryAll = Enquiry::all();

        $enquiriesWithHour = $enquiryAll->map(function ($enquiry) {
            $hour = Carbon::parse($enquiry->created_at)->format('H');
            $enquiry->hour = $hour;

            return $enquiry;
        });
        $enquiriesWithday = $enquiryAll->map(function ($enquiry) {
            $day = Carbon::parse($enquiry->created_at)->format('d');
            $enquiry->day = $day;

            return $enquiry;
        })
        ;
        $enquiriesWithQuestion = $enquiryAll->map(function ($enquiry) {
            $has_question = $enquiry->has_question;
            $enquiry->has_question = $has_question;
        
       
            return $enquiry;
        });


        return Inertia::render('Statistics', [
            'enquiriesWithHour' => $enquiriesWithHour,
            'enquiriesWithday' => $enquiriesWithday,
            'enquiriesWithQuestion' => $enquiriesWithQuestion,
            'enquiryAll' => $enquiryAll,
            'fields' => Config::enquiryFormFields(),
        ]);
    }

}
