<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecVacancy extends Model
{
    use HasFactory;
    protected $fillable=['type','code','title_zh','title_en','title_pt','education','vechicle','apply_id','apply_title','description','date_start','date_end',
                        'supplement_start','supplement_end','date_publish','attach_zh','attach_en','attach_pt','progress','active'];
    protected $casts=['progress'=>'boolean','active'=>'boolean'];

    public function applications(){
        return $this->hasMany(RecApplication::class);
    }
    public function notifications(){
        return $this->hasMany(RecNotification::class);
    }
}
