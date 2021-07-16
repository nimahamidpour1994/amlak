<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable=['name','slug','parent','type'];

    public $timestamps=false;



    public function Child()
    {
        return $this->hasMany('app\models\Category','parent','id')->orderBy('id','ASC');
    }

    public function Parent()
    {
        return $this->belongsTo(Category::class,'parent');
    }

    public function Self()
    {
        return $this->belongsTo(Category::class,'id');
    }


}
