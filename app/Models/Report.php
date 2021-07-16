<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable=['advertisment','mobile','message','category'];
    protected $attributes=['read'=>'unread','result'=>''];

    public function Advertisment(){
        return $this->belongsTo(Advertisment::class,'advertisment','id');
    }
}
