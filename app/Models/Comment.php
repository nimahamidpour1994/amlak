<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['name','email','content','model','model_id','writer','publish','like','dislike'];
}
