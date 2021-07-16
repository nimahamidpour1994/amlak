<?php

namespace App\Models;

use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMeta;


class Form extends Model
{
    use HasMeta,HasScope;

    protected $fillable=['parent','name','value','field','unit','force','show_thumbnail'];

    public $timestamps=false;

    public function FormatField()
    {
        return $this->belongsTo(Setting::class,'field','value');
    }



}
