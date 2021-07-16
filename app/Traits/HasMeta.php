<?php

namespace App\Traits;

trait HasMeta
{
    /**
     * @return  void
     */
    protected static function bootHasMeta()
    {
        static::deleting(function ($model) {
            $model->truncateMeta();
        });
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Meta()
    {
        return $this->hasMany('App\Models\Meta', 'model_id')->where('model', class_basename($this));
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null $key
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scopeMetaKey($query, $key)
    {
       return $this->Meta()->where('key', $key);
    }

    /**
     * @param  string|null $key
     *
     * @return  bool
     */
    public function hasMeta($key = null)
    {
        if (blank($key)) {
            return $this->Meta()->exists();
        }
        return $this->MetaKey($key)->exists();
    }

    /**
     * @param  string $key
     * @param  bool $multiple
     *
     * @return  string|array|null
     */
    public function getMeta(string $key, bool $multiple = false)
    {
        if ($multiple) {
            if ($this->MetaKey($key)->whereNotNull('unique')->exists()) {
                return $this->MetaKey($key)->pluck('value', 'unique')->toArray();
            }
            return $this->MetaKey($key)->pluck('value')->toArray();
        }
        return optional($this->MetaKey($key)->first())->value;
    }

    /**
     * @param  array $array
     * @param  bool $multiple
     * @param  string|null $unique
     *
     * @return  void
     */
    public function setMeta(array $array, bool $multiple = false, $unique = null)
    {
        foreach ($array as $key => $value) {
            if (blank($value)) {
                $this->deleteMeta((string) $key);
                continue;
            }
            if ($multiple && blank($unique)) {
                \App\Models\Meta::showHiddenMeta([$key])->create([
                    'key' => $key,
                    'model' => class_basename($this),
                    'model_id' => $this->id,
                    'value' => $value
                ]);
                continue;
            }
            \App\Models\Meta::showHiddenMeta([$key])->updateOrCreate([
                'key' => $key,
                'unique' => $unique,
                'model' => class_basename($this),
                'model_id' => $this->id
            ], [
                'value' => $value
            ]);
        }
    }

    /**
     * @param  string $key
     * @param  string|null $value
     *
     * @return  bool
     */
    public function deleteMeta(string $key, $value = null)
    {
        return (bool) $this->MetaKey($key)->when(isset($value), function ($query) use ($value) {
            return $query->where('value', $value);
        })->delete();
    }

    /**
     * @return  bool
     */
    public function truncateMeta()
    {
        return (bool) $this->Meta()->delete();
    }
}
