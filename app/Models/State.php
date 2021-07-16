<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable=['name','latitude','longitude','parent'];

    public $timestamps=false;

    public function Parent(){
        return $this->belongsTo(City::class,'parent','id');
    }
}
