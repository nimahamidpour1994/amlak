<?php

namespace App\Models;

use App\Traits\HasMeta;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasScope,HasMeta;

    protected $guarded = [];

    protected $visible = ['key', 'value','unique'];

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = \Str::slug($value, '_');
    }

    public function scopeShowHiddenMeta($query, array $visible)
    {
        $this->meta_visible = filled($this->meta_visible) ? array_merge($visible, $this->meta_visible) : $visible;
        return $query;
    }

    public function hydrate(array $items)
    {
        $collection = parent::hydrate($items);
        $metaVisible = (array) $this->meta_visible;
        if (filled(optional($collection->first())->model)) {
            $modelMetaVisible = app('App\Models\\' . $collection->first()->model)->meta_visible;
            $metaVisible = filled($metaVisible) ? array_merge($metaVisible, $modelMetaVisible) : $modelMetaVisible;
        }
        $isForResponse = collect(debug_backtrace())->whereIn('class', ['Illuminate\Routing\Router', 'Illuminate\Foundation\Http\Kernel'])->count() > 0;
        if ($isForResponse && filled($metaVisible)) {
            $collection = $collection->whereIn('key', $metaVisible);
        }
        return $collection;
    }

    public function Form(){
        return $this->belongsTo(Form::class,'unique','id');
    }

    public function Advertisment(){
        return $this->belongsTo(Advertisment::class,'model_id','id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category','model_id','id');
    }

    public function Page()
    {
        return $this->belongsTo('App\Models\Page','model_id','id');
    }
}
