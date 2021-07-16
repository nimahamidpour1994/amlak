<?php

namespace App\Traits;

trait HasSlug
{
    /**
     * @return  void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected static function bootHasSlug()
    {
        static::saving(function ($model) {
            $table = (new static())->getTable();
            $source = self::$slug_source;
            $value = $model[$source];
            $slug = \Str::slug($value, optional(new static())->slug_separator ?: '-', '');

            $attribute = array_key_exists($source, (array) trans('validation.attributes'))
                ? trans('validation.attributes')[$source]
                : trans($source);
            $attribute .= trans($table);

            $errors = [];
            if (blank($value)) {
                $errors[] = trans('validation.required', ['attribute' => $attribute]);
            }
            if (\DB::table($table)->where($source, $value)->orWhere('slug', $slug)->exists()) {
                if (blank($model->slug) || (filled($model->slug) && $slug !== $model->slug)) {
                    $errors[] = trans('validation.unique', ['attribute' => $attribute]);
                }
            }

            abort_if(filled($errors), 422, reset($errors));
            $model->slug = $slug;
        });
    }

    /**
     * @return  void
     */
    public function initializeHasSlug()
    {
        foreach (['slug', 'id'] as $column) {
            if (!in_array($column, $this->hidden)) {
                $this->hidden[] = $column;
            }
        }

        if (!in_array('url', $this->appends)) {
            $this->appends[] = 'url';
        }
    }

    /**
     * @return  string
     */
    public function getUrlAttribute()
    {
        return '/' . \Str::snake(class_basename($this)) . '/' . $this->slug;
    }

    /**
     * @return  string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
