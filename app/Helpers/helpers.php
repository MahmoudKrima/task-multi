<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if (!function_exists('displayImage')) {
    function displayImage($object)
    {
        if (Storage::exists('public/' . $object)) {
            return url(asset('storage/' . $object));
        }
        return url(asset($object));
    }
}

if (!function_exists('isRoute')) {
    function isRoute(array $routes)
    {
        foreach ($routes as $route) {
            if (Route::is($route)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('getAssetLang')) {
    function getAssetLang()
    {
        if (app()->getLocale() == 'ar') {
            return 'ar';
        } else {
            return 'en';
        }
    }
}


if (!function_exists('createSlug')) {
    function createSlug($string)
    {
        return str_replace(' ', '-', strtolower($string));
    }
}
