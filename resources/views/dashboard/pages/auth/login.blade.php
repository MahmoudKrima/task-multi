<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ app('settings')['app_name_' . app()->getLocale()] }} | {{ __('admin.login') }} </title>
    <link rel="icon" type="image/x-icon" href="{{ displayImage(app('settings')['fav_icon']) }}" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ tenant_asset('assets_' . getAssetLang()) }}/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/css/authentication/form-2.css" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css"
        href="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/css/forms/switches.css">
    <link rel="stylesheet" href="{{ tenant_asset('vendor/toastr/build/toastr.min.css') }}">

</head>

<body class="form">


    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">{{ __('admin.login') }}</h1>
                        <form class="text-left" method="POST" action="{{ route('auth.login') }}">
                            @csrf
                            <div class="form">
                                <div id="email" class="field-wrapper input">
                                    <label for="email">{{ __('admin.email') }}</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="email" name="email" value="{{ old('email') }}" type="text"
                                        class="form-control" placeholder="a@a.com">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">{{ __('admin.password') }}</label>
                                        <a href="{{ route('auth.forgetPasswordForm') }}"
                                            class="forgot-pass-link">{{ __('admin.forget_password') }}</a>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2">
                                        </rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="{{ __('admin.password') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" id="toggle-password"
                                        class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-danger"
                                            value="">{{ __('admin.login') }}</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/js/authentication/form-2.js"></script>
    <script src="{{ tenant_asset('vendor/toastr/build/toastr.min.js') }}"></script>

    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if (session()->has('Success'))
            toastr.success('{{ session()->get('Success') }}');
        @endif
        @if (session()->has('Error'))
            toastr.error('{{ session()->get('Error') }}');
        @endif

        @if (session()->has('Warn'))
            toastr.warning('{{ session()->get('Warn') }}');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    </script>
</body>

</html>
