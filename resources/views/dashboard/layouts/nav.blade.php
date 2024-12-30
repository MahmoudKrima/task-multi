<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="{{ route('admin.dashboard.index') }}">
                    <img src="{{ displayImage(app('settings')['logo']) }}" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="{{ route('admin.dashboard.index') }}" class="nav-link">
                    {{ app('settings')['app_name_' . app()->getLocale()] }} </a>
            </li>
        </ul>

        {{-- <ul class="navbar-item flex-row ml-md-0 ml-auto">
            <li class="nav-item align-self-center search-animated">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-search toggle-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto"
                            placeholder="Search...">
                    </div>
                </form>
            </li>
        </ul> --}}

        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/img/{{ app()->getLocale() }}.png"
                        class="flag-width" alt="flag">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if ($localeCode == app()->getLocale())
                            @continue
                        @endif
                        <a class="dropdown-item d-flex"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"><img
                                src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/img/{{ $localeCode }}.png"
                                class="flag-width" alt="flag">

                            <span class="align-self-center">&nbsp; {{ $properties['native'] }}</span></a>
                    @endforeach
                </div>
            </li>

            <x-admin-notification />

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img src="{{ displayImage(auth('admin')->user()->image) }}" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="{{ route('admin.profile.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> {{ __('admin.profile') }}
                            </a>
                        </div>
                        <div class="dropdown-item bg-danger text-center">
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button style="background: transparent; border:none" class="ml-2 btn-alert"
                                    type="submit">
                                    <span>{{ __('admin.logout') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </header>
</div>
