<?php

namespace App\Models;

use App\Traits\HasFile;
use App\Traits\HasMeta;
use App\Traits\HasScope;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasScope;
    use HasSlug;
    use HasFile;
    use HasMeta;

    protected $guarded = [];

    protected static $slug_source = 'title';


    protected $has_file = [
        'name' => 'title',
        'source' => 'thumbnail',
        'image' => [
            'fit' => ['500']
        ]
    ];


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = \Str::slug($value, ' ', '');
    }


    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function Category()
    {
        return $this->belongsTo('App\Models\Category','parent');
    }
}
