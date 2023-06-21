<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Enquiry;
use App\Models\EnquiryQuestion;
use App\Models\Faq;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields=Config::where('division','enquiry_form')->get()->toArray();
        $fields=array_column($fields,null,'label');
        $fields=array_map(function($field){
            return json_decode($field['value']);
        },$fields);
        if(!isset($fields) && sizeof($fields)==0){
            return Inertia::render('Error',[
                'message'=>'Enquiry Config missing or data corrupted!'
            ]);
        };
        return Inertia::render('Enquiry/Form',[
            'fields'=>Config::enquiryFormFields(),
            'lang'=>'zh',
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
        $enquiry=new Enquiry();
        $enquiry->department_id=1;
        $enquiry->lang=$request->lang;
        $enquiry->origin=$request->origin;
        $enquiry->degree=$request->degree;
        $enquiry->admission=$request->admission;
        $enquiry->profile=$request->profile;
        $enquiry->apply=$request->apply;
        $enquiry->surname=$request->surname;
        $enquiry->givenname=$request->givenname;
        $enquiry->email=$request->email;
        $enquiry->areacode=$request->areacode;
        $enquiry->phone=$request->phone;
        $enquiry->subjects=json_encode($request->subjects);
        $enquiry->token=Enquiry::token();
        $enquiry->is_closed=isset($request->is_closed)?$request->is_closed:0;
        $enquiry->save();
        return to_route('enquiry.answerQuestion',[
            'enquiry'=>$enquiry->id,
            'token'=>$enquiry->token
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Enquiry $enquiry)
    {
        return redirect()->route('enquiry.question',[
            'enquiry'=>$enquiry->id,
            'token'=>$enquiry->token
        ]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function answerQuestion(Enquiry $enquiry,$token){
        if($enquiry->has_question){
            return to_route('enquiry.index');
        };
        if($enquiry->token!=$token){
            return to_route('enquiry.index');
        };
        if($enquiry->has_question!==null){
            return Inertia::render('Error',[
                'message'=>'The inquiry question already submit!'
            ]);
        };
        // $enquiry->has_question=true;
        // $enquiry->save();
        $subjects=json_decode($enquiry->subjects);
        $faqs=Faq::getBySubjects($subjects);
        return Inertia::render('Enquiry/Question',[
            'enquiry'=>$enquiry,
            'faqs'=>$faqs,
        ]);
    }
    public function noQuestion(Enquiry $enquiry){
        if($enquiry->has_question!==null){
            return Inertia::render('Error',[
                'message'=>'The inquiry question already submit!'
            ]);
        }
        $enquiry->has_question=false;
        $enquiry->save();
        return to_route('enquiry.thankQuestion');
    }

    public function submitQuestion(Enquiry $enquiry, Request $request){
        if($enquiry->token!=$request->token){
            return to_route('enquiry.index');
        };
        if($enquiry->has_question!==null){
            return Inertia::render('Error',[
                'message'=>'The inquiry question already submit!'
            ]);
        }
        $enquiry->has_question=true;
        $enquiry->save();
        $enquiryQuestion= new EnquiryQuestion();
        $enquiryQuestion->enquiry_id=$enquiry->id;
        $enquiryQuestion->content=$request->content;
        $enquiryQuestion->token=Enquiry::token();
        $enquiryQuestion->is_closed=isset($request->is_closed)?$request->is_closed:0;
        $enquiryQuestion->save();

        if($request->file('fileList')){
            foreach($request->file('fileList') as $file){
                $enquiry_question->addMedia($file['originFileObj'])
                    ->toMediaCollection('enquiryQuestionAttachments');
            }
        }
        return to_route('enquiry.thankQuestion');
    }
    public function thankQuestion(){
        return Inertia::render('Enquiry/ThankQuestion',[

        ]);

    }

    public function faqs(){
        return Inertia::render('Enquiry/Faqs',[
            'faqs'=>Faq::all()
        ]);
    }

}

