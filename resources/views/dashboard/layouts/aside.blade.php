<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ isRoute(['admin.dashboard.index']) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard.index') }}"
                    aria-expanded="{{ isRoute(['admin.dashboard.index']) ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>{{ __('admin.dashboard') }}</span>
                    </div>
                </a>
            </li>

            @if (auth('admin')->user()->hasAnyPermission([
                        'admins.view',
                        //  'users.view'
                    ]))
                <li class="menu">
                    <a href="#userSettings"
                        data-active="{{ isRoute([
                            // 'admin.users.index',
                            // 'admin.users.search',
                            // 'admin.users.edit',
                            'admin.admins.index',
                            'admin.admins.search',
                            'admin.admins.create',
                            'admin.admins.edit',
                        ])
                            ? 'true'
                            : 'false' }}"
                        data-toggle="collapse"
                        aria-expanded="{{ isRoute([
                            // 'admin.users.index',
                            // 'admin.users.search',
                            // 'admin.users.edit',
                            'admin.admins.index',
                            'admin.admins.search',
                            'admin.admins.create',
                            'admin.admins.edit',
                        ])
                            ? 'true'
                            : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>{{ __('admin.users_settings') }}</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ isRoute([
                        // 'admin.users.index',
                        // 'admin.users.search',
                        // 'admin.users.edit',
                        'admin.admins.index',
                        'admin.admins.search',
                        'admin.admins.create',
                        'admin.admins.edit',
                    ])
                        ? 'show'
                        : '' }}"
                        id="userSettings" data-parent="#accordionExample">
                        @haspermission('admins.view', 'admin')
                            <li
                                class="{{ isRoute(['admin.admins.index', 'admin.admins.search', 'admin.admins.create', 'admin.admins.edit']) ? 'active' : '' }}">
                                <a href="{{ route('admin.admins.index') }}"> {{ __('admin.admins') }} </a>
                            </li>
                        @endhaspermission
                        {{-- @haspermission('users.view', 'admin')
                            <li
                                class="{{ isRoute(['admin.users.index', 'admin.users.search', 'admin.users.edit']) ? 'active' : '' }}">
                                <a href="{{ route('admin.users.index') }}"> {{ __('admin.users') }} </a>
                            </li>
                        @endhaspermission --}}
                    </ul>
                </li>
            @endif

            @haspermission('task.view', 'admin')
                <li
                    class="menu {{ isRoute(['admin.tasks.index', 'admin.tasks.search', 'admin.tasks.create', 'admin.tasks.edit']) ? 'active' : '' }}">
                    <a href="{{ route('admin.tasks.index') }}"
                        aria-expanded="{{ isRoute(['admin.tasks.index', 'admin.tasks.search', 'admin.tasks.create', 'admin.tasks.edit']) ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <span>{{ __('admin.tasks') }}</span>
                        </div>
                    </a>
                </li>
            @endhaspermission

            @haspermission('settings.update', 'admin')
                <li class="menu {{ isRoute(['admin.settings.index']) ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}"
                        aria-expanded="{{ isRoute(['admin.settings.index']) ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                            <span>{{ __('admin.settings') }}</span>
                        </div>
                    </a>
                </li>
            @endhaspermission

            @haspermission('role.view', 'admin')
                <li
                    class="menu {{ isRoute(['admin.roles.index', 'admin.roles.search', 'admin.roles.create', 'admin.roles.edit']) ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}"
                        aria-expanded="{{ isRoute(['admin.roles.index', 'admin.roles.search', 'admin.roles.create', 'admin.roles.edit']) ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-shield">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span>{{ __('admin.roles') }}</span>
                        </div>
                    </a>
                </li>
            @endhaspermission

            @haspermission('activity_log.view', 'admin')
                <li class="menu {{ isRoute(['admin.activity-logs.index']) ? 'active' : '' }}">
                    <a href="{{ route('admin.activity-logs.index') }}"
                        aria-expanded="{{ isRoute(['admin.activity-logs.index']) ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-git-pull-request">
                                <circle cx="18" cy="18" r="3"></circle>
                                <circle cx="6" cy="6" r="3"></circle>
                                <path d="M13 6h3a2 2 0 0 1 2 2v7"></path>
                                <line x1="6" y1="9" x2="6" y2="21"></line>
                            </svg>
                            <span>{{ __('admin.activity_logs') }}</span>
                        </div>
                    </a>
                </li>
            @endhaspermission

            <li class="menu {{ isRoute(['admin.notifications.showAll']) ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.showAll') }}"
                    aria-expanded="{{ isRoute(['admin.notifications.showAll']) ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span>{{ __('admin.notifications') }}</span>
                    </div>
                </a>
            </li>
        </ul>
        <!-- <div class="shadow-bottom"></div> -->

    </nav>

</div>
