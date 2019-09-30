<?php

namespace APDevs\LaravelUtils\Http\Traits\Resources;

trait ShowTrait
{

    public function show($resource_id)
    {
        $resource = $this->model->findOrFail($resource_id);

        return $resource;
    }

}
