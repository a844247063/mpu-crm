<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable=['department_id','category_id','origins','degrees','subjects','question_zh','answer_zh','question_ne','answer_en','question_pt','answer_pt'];
    protected $casts = ['origins'=>'json','degrees'=>'json','subjects'=>'json'];
    
    public static function getByEnquiry($enquiry){
        return Faq::where(function ($q) use ($enquiry){
            $q->whereJsonContains('degrees',$enquiry->degree);
            $q->whereJsonContains('origins',$enquiry->origin);
            $q->where(function ($s) use ($enquiry){
                foreach($enquiry->subjects as $item){
                    $s->orWhereJsonContains('subjects',$item);
                }
            });
        })->get();
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
