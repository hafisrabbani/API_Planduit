<?php


use Illuminate\Support\Facades\Route;

if(!function_exists('activeState')){
    function activeState($route, $output = "active")
    {
        if(str_starts_with(Route::currentRouteName(), $route)){
            return $output;
        }
        return '';
    }
}
