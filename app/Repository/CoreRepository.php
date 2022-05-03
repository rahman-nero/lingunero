<?php


namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
*/
abstract class CoreRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->model = app($this->getModel());
    }

    abstract protected function getModel(): string;

    public function model()
    {
        return $this->model->newQuery();
    }
}
