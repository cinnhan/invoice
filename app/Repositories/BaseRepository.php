<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository // apply singleton here
{

    /**
     * @var $model Model
     */
    protected $model;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * get Model Class
     * @return mixed
     */
    abstract public function getModel();

    /**
     * extra Listing Query
     * @param EloquentBuilder|QueryBuilder $query
     * @param array $whereColumn_value
     * @param array $orderBys
     * @param string $whereRaw
     * @param int $limit
     * @return EloquentBuilder|QueryBuilder
     */
    public function extraListingQuery(EloquentBuilder|QueryBuilder $query, array $whereColumn_value = [],
                                      array $orderBys = [], string $whereRaw = '', int $limit = 0)
    {
        foreach ($whereColumn_value as $column => $value) {
            $query->where($column, $value);
        }

        foreach ($orderBys as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        if ($whereRaw) {
            $query->whereRaw($whereRaw);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * get By Ids
     * @param array|int $ids
     * @param array $columns
     * @return EloquentBuilder|EloquentBuilder[]|Collection|Model|object|null
     */
    public function getByIds(array|int $ids, array $columns = ['*'])
    {
        $query = $this->model::whereIn('id', (array) $ids)->select($columns);

        if (is_array($ids)) {
            $data = $query->get();
        } else { // is_numeric
            $data = $query->first();
        }

        return $data;
    }

    /**
     * get By Uniques
     * @param string $uniqueColumn
     * @param array|int|string $uniques
     * @param array $columns
     * @return EloquentBuilder|EloquentBuilder[]|Collection|Model|object|null
     */
    public function getByUniques(string $uniqueColumn, array|int|string $uniques, array $columns = ['*'])
    {
        $query = $this->model::whereIn($uniqueColumn, (array) $uniques)->select($columns);

        if (is_array($uniques)) {
            $data = $query->get();
        } else { // is_numeric
            $data = $query->first();
        }

        return $data;
    }

    /**
     * insert single data
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        $model = new $this->model;

        foreach ($data as $column => $value) {
            $model->{$column} = $value;
        }
        $model->save();

        return $model;
    }

    /**
     * insert Many
     * @param array $data
     * @return bool
     */
    public function insertMany(array $data)
    {
        return DB::table($this->model->getTable())->insert($data);
    }

    /**
     * update By Ids (can update only id)
     * @param array|int $ids
     * @param array $data
     * @return int
     */
    public function updateById(array|int $ids, array $data)
    {
        return $this->model::whereIn('id', (array) $ids)->update($data);
    }

    /**
     * delete By Ids (can update only id)
     * @param array|int $ids
     * @return mixed
     */
    public function deleteByIds(array|int $ids)
    {
        return $this->model::whereIn('id', (array) $ids)->delete();
    }

    /**
     * upsert data
     * @param array $values
     * @param array $uniqueBy
     * @param array $update
     * @return mixed
     */
    public function upsert(array $values, array $uniqueBy, array $update = [])
    {
        return $this->model::upsert($values, $uniqueBy, $update);
    }

}
