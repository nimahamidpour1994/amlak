<?php

namespace App\Models;

use App\Traits\HasMeta;
use Illuminate\Database\Eloquent\Model;

class ListenBell extends Model
{
    use HasMeta;

    public function State(){
        return $this->belongsTo(State::class,'state','id');
    }

    public function Category(){
        return $this->belongsTo(Category::class,'category','id');
    }

    protected $guarded=[];
}
