<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    public static function inquiryFormFields(){
        $fields=Config::where('division','inquiry_form')->get()->toArray();
        $fields=array_column($fields,null,'label');
        $fields=array_map(function($field){
            return json_decode($field['value']);
        },$fields);
        return $fields;
    }
    public static function inquirySubjects(){
        $item=Config::where('division','inquiry_form')->where('label','subjects')->first();
        return json_decode($item->value)->options;
    }
}
