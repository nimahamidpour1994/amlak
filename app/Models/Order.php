<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['advertisment','discount','price','pay'];

    public function Advertisment()
    {
        return $this->belongsTo(Advertisment::class,'advertisment','id');
    }

}
