<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ app('settings')['app_name_' . app()->getLocale()] }} | {{ __('admin.forget_password') }} </title>
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

<body class="form no-image-content">


    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">{{ __('admin.forget_password') }}</h1>
                        <p class="signup-link recovery">
                            {{ __('admin.Enter_your_email_and_instructions_will_sent_to_you') }}</p>
                        <form class="text-left" method="POST" action="{{ route('auth.forgetPassword') }}">
                            @csrf
                            <div class="form">

                                <div id="email-field" class="field-wrapper input">
                                    <div class="d-flex justify-content-between">
                                        <label for="email">{{ __('admin.email') }}</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign">
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                    </svg>
                                    <input id="email" name="email" value="{{ old('email') }}" type="text"
                                        class="form-control" placeholder="a@a.com">
                                </div>

                                <div class="d-sm-flex justify-content-between">

                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-danger"
                                            value="">{{ __('admin.reset') }}</button>
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
