<?php

namespace App\Models;

use App\Traits\HasMeta;
use Illuminate\Database\Eloquent\Model;


class Advertisment extends Model
{
    use HasMeta;

    protected $fillable=['name','category','state','mobile','details','who',
        'slug','icon','latitude','longitude','owner_name','owner_mobile','owner_address','owner_price','owner_details','messageAdmin'];

    protected $attributes=['show'=>'success', 'verify'=>1];


    public function Status(){
        return $this->belongsTo(Setting::class,'show','value');
    }

    public function State(){
        return $this->belongsTo(State::class,'state','id');
    }

    public function Category(){
        return $this->belongsTo(Category::class,'category','id');
    }

    public function Meta(){
        return $this->hasMany('App\Models\Meta', 'model_id','id');
    }

}
