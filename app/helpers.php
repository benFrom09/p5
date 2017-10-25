<?php


if(! function_exists('pageTitle')) {
    function pageTitle($title) {
        $appName = config('app.name');
        if($title === '') {
            return $appName;
        } else {
            return $title . ' -/- ' . $appName;
        }
    }
}

if(! function_exists('routeIsActive')) {
    function routeIsActive($route) {
        return Route::is($route) ? 'active' : '';
    }
}