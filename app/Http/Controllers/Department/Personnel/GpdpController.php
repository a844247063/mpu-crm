<?php

namespace App\Http\Controllers\Department\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Gpdp;
use App\Models\Department;
use Illuminate\Support\Facades\Mail;
use App\Mail\GpdpReminderMail;
//use Mail;

class GpdpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Department/Personnel/Gpdps',[
            'department'=>session('department'),
            'gpdps'=>Gpdp::all()
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
    public function store(Request $request)
    {
        // dd($request->all());
        Gpdp::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Gpdp $gpdp, Request $request)
    {
        $gpdp->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gpdp $gpdp)
    {
        $gpdp->delete();
        return redirect()->back();
    }

    public function listEmail(Gpdp $gpdp){

        // $gpdpEmail = Gpdp::create($request->all());
        
        //if($request->by_email){
            $email=[
                'address'=>$gpdp->email,
                'subject'=>'test',
                'name_zh'=>$gpdp->name_zh,
                'name_fr'=>$gpdp->name_fr,
                'date_remind'=>$gpdp->date_remind   
            ];
            // $this->sendEmail($email);
            Mail::to($email['address'])->send(new GpdpReminderMail($email));

        //}
            
        
    }

    public function sendEmail( $email ){
        Mail::to($email['address'])->send(new GpdpReminderMail($email));

        // Mail::send('emails.gpdpReminder',$email, function($message) use($email){
        //     $message->to($email["address"])
        //             ->subject($email["subject"]);
          
        // });
 
            
        
    }
}
