<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ app('settings')['app_name_' . app()->getLocale()] }} | @yield('title') </title>
    <link rel="icon" type="image/x-icon" href="{{ displayImage(app('settings')['fav_icon']) }}" />
    <link href="{{ asset('assets_' . getAssetLang()) }}/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets_' . getAssetLang()) }}/assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    @if (app()->getLocale() == 'ar')
        <!----- fonts------>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap"
            rel="stylesheet">
        <!-------End fonts ---->
    @endif

    <link href="{{ asset('assets_' . getAssetLang()) }}/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets_' . getAssetLang()) }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('vendor/toastr/build/toastr.min.css') }}">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @stack('css')

    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
