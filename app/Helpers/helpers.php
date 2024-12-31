<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


if (!function_exists('api_model_set_paginate')) {

    function api_model_set_paginate($model)
    {
        return [
            'total'         => $model->total(),
            'lastPage'      => $model->lastPage(),
            'perPage'       => $model->perPage(),
            'currentPage'   => $model->currentPage(),
        ];
    }
}

if (!function_exists('displayImage')) {
    function displayImage($object)
    {
        if (Storage::exists('public/tenancy/assets' . $object)) {
            return url(asset('storage/' . $object));
        }
        return url(tenant_asset($object));
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
        $string = trim($string);
        return str_replace(' ', '-', strtolower($string));
    }
}

if (!function_exists('getS3ImageUrl')) {

    function getS3ImageUrl($path, $isPrivate = false)
    {
        if ($isPrivate) {
            return Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));
        }

        return Storage::disk('s3')->url($path);
    }
}
