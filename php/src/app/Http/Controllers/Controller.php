<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    /**
     * 요청에서 parameter를 추출합니다.
     *
     * @param  string  $name
     */
    protected function interceptParameter($name)
    {
        $route = request()->route();

        if ($route->hasParameter($name)) {

            $parameter = $route->parameter($name);
            $route->forgetParameter($name);

            return $parameter;
        }

        return null;
    }

    /**
     * JSON Response를 반환합니다.
     *
     * @param  array  $data
     * @param  int  $status
     * @return @return \Illuminate\Http\JsonResponse
     */
    protected function response($data = [], $status = 200)
    {
        return response()->json($data, $status);
    }
}
