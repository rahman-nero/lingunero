<?php


namespace App\Repository;


abstract class CoreRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = app($this->getModel());
    }

    abstract protected function getModel(): string;

    public function model()
    {
        return clone $this->model;
    }
}
