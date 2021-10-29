<?php

namespace App\Domain;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

abstract class Repository
{
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resetModel();
    }

    /**
     * Repository에서 사용할 모델을 정의합니다.
     */
    abstract protected function model();

    /**
     * 모델을 리셋합니다.
     */
    public function resetModel()
    {
        $this->model = $this->model();
    }

    /**
     * 모델을 반환합니다.
     *
     * @return \Illuminate\Database\Eloquent\Model $model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * 데이터를 조회하여 반환합니다.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get($columns = ['*'])
    {
        $resources = $this->model->get($columns);

        $this->resetModel();

        return $resources;
    }

    /**
     * 데이터를 페이징처리하여 반환합니다.
     *
     * @param  int|null  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $resources = $this->model->paginate($perPage, $columns, $pageName, $page);

        $this->resetModel();

        return $resources;
    }

    /**
     * 데이터를 조회하여 반환합니다.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model $model
     */
    public function find($id)
    {
        $resource = $this->model->find($id);

        $this->resetModel();

        return $resource;
    }
}
