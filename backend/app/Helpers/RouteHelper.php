<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Exception;
use Route;

class RouteHelper
{
    public static function isValidRoute($uri)
    {
        $request = Request::create($uri);
        $routes  = Route::getRoutes();
        try {
            $route = $routes->match($request);
            return true;
        } catch (Exception $e) {
            // No matching route was found.
            return false;
        }
    }
}
