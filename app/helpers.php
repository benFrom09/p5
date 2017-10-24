<?php


if(! function_exists('pageTitle')) {
    function pageTitle($title) {
        $appName = 'App-Name';
        if($title === '') {
            return $appName;
        } else {
            return $title . ' -/- ' . $appName;
        }
    }
}