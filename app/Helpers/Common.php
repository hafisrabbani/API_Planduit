<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (!function_exists('activeState')) {
    function activeState($route, $output = "active")
    {
        $fixedRoute = strtok($route, '{');
        if (Str::startsWith(url()->current(), url($fixedRoute))) {
            return $output;
        }
        return '';
    }
}


