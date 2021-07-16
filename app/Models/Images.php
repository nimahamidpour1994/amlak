<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable=['addvertisment_id','img'];
    public $timestamps=false;

}
