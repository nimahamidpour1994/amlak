<?php

namespace App\Traits;

trait HasScope
{
    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int $limit
     * @param  array $columns
     * @param  string|null $pageName
     * @param  int|null $page
     *
     * @return  \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopePaginate($query, int $limit = 25, array $columns = ['*'], $pageName = null, $page = null)
    {
        if ($pageName === null) $pageName = \Str::snake(class_basename($this)) . '_page';
        return $query->paginate($limit, $columns, $pageName, \Request::get($pageName) ?: $page);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Carbon\Carbon $date
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreateFrom($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Carbon\Carbon $date
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreateTo($query, $date)
    {
        return $query->where('created_at', '<=', $date);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string $relation
     * @param  string $direction
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByCount($query, string $relation, string $direction = 'desc')
    {
        return $query->withCount($relation)->orderBy(\Str::snake($relation) . '_count', $direction);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string $relation
     * @param  string $column
     * @param  string $mode
     * @param  string $direction
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByRelation($query, string $relation, string $column, string $mode = 'sum', string $direction = 'desc')
    {
        $list = [];
        foreach (app(self::class)->with($relation)->get() as $model) {
            $computed = $model->$relation->$mode($column);
            if (filled($computed)) $list[$model->id] = $computed;
        }
        if (filled($list)) {
            asort($list);
            return $query->orderByRaw(\DB::raw('FIELD(id, ' . implode(',', array_keys($list)) . ') ' . $direction));
        }
        return $query;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string $relation
     * @param  string $column
     * @param  mixed $value
     * @param  string $operator
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByRelation($query, string $relation, string $column, $value, string $operator = '=')
    {
        return $query->whereHas($relation, function ($queryWhereHas) use ($column, $value, $operator) {
            $queryWhereHas->where($column, $operator, $value);
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed $relation
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForModel($query, $relation)
    {
        return $query->where('model', class_basename($relation))->where('model_id', $relation->id);
    }
}
