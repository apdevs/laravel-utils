<?php

namespace APDevs\LaravelUtils\Http\Traits\Resources;

use Illuminate\Http\Request;

trait DeleteTrait
{

    public function destroy(Request $request, $resource_id)
    {
        $resource = $this->model->findOrFail($resource_id);
        $resource->delete();

        return $resource;
    }

}
