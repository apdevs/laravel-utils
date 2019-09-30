<?php

namespace App\Http\Traits;

namespace APDevs\LaravelUtils\Http\Traits\Resources;

trait StoreTrait
{

    public function store(Request $request)
    {
        $resource = $this->model->newInstance($request->all());
        $resource->saveOrFail();

        return $resource;
    }

}
