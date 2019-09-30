<?php

namespace APDevs\LaravelUtils\Http\Traits\Resources;

trait IndexTrait
{

    public function index()
    {
        $query = $this->model->query();
        $query = $this->setIndexFiltersToQuery($query);

        return $query->get();
    }

    public function setIndexFiltersToQuery($query)
    {
        return $query;
    }

}
