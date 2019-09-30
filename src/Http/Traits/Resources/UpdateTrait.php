<?php

namespace App\Http\Traits;

namespace APDevs\LaravelUtils\Http\Traits\Resources;

trait UpdateTrait
{

    public function update(Request $request, $resource_id)
    {
        $resource = $this->model->findOrFail($resource_id);
        $resource->fill($request->all());
        $resource->saveOrFail();

        return $resource;
    }

}
