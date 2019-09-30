<?php

namespace APDevs\LaravelUtils\Http\Controllers;

use Illuminate\Routing\Controller;
use APDevs\LaravelUtils\Http\Traits\Resources\IndexTrait;
use APDevs\LaravelUtils\Http\Traits\Resources\StoreTrait;
use APDevs\LaravelUtils\Http\Traits\Resources\ShowTrait;
use APDevs\LaravelUtils\Http\Traits\Resources\UpdateTrait;
use APDevs\LaravelUtils\Http\Traits\Resources\DeleteTrait;

class ResourceController extends Controller
{
    use IndexTrait, StoreTrait, ShowTrait, UpdateTrait, DeleteTrait;

    protected $model;

    function __construct($model)
    {
        $this->model = $model;
    }

}
