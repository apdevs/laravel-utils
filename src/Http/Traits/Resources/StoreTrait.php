<?php

namespace APDevs\LaravelUtils\Http\Traits\Resources;

use Illuminate\Http\Request;

trait StoreTrait
{

    public function store(Request $request)
    {
        $resource = $this->model->newInstance($request->all());
        $resource->saveOrFail();

        return $resource;
    }

}
