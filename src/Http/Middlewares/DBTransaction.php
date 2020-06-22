<?php

namespace APDevs\LaravelUtils\Http\Middlewares;

use DB;
use Closure;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class DBTransaction
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        DB::beginTransaction();

        try {
            $response = $next($request);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($response instanceof Response && $response->getStatusCode() > 399) {
            DB::rollBack();
        } elseif ($response instanceof JsonResponse && $response->getStatusCode() > 399) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $response;
    }

}
