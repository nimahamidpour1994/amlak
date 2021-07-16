<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable=['sender','receiver','message','read','advertisment','reply','is_start','tracking_code'];

    protected $attributes=['read'=>'unread'];

    public function Advertisment()
    {
        return $this->belongsTo(Advertisment::class,'advertisment','id');
    }
}
