@if (isRoute(['admin.dashboard.index']))
    <li class="nav-item dropdown notification-dropdown" style="margin-top:13px;">
    @else
    <li class="nav-item dropdown notification-dropdown">
@endif

<a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown"
    aria-haspopup="true" aria-expanded="false">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" style="color:white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="feather feather-bell">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
    </svg>
    <span class="badge badge-primary d-flex justify-content-center align-items-center"
        style="width: 12px; height: 12px; border-radius: 50%; font-size: 8px;color:black">
        {{ $totalNotifications >= 10 ? '+9' : $totalNotifications }}
    </span>
</a>
<div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
    <div class="notification-scroll">
        @foreach ($notifications as $notification)
            @php
                $data = json_decode($notification->data, true);
            @endphp
            <div class="dropdown-item">
                <div class="media">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-bell" style="color:white">
                    </svg>
                    <div class="media-body">
                        <div class="notification-para">
                            <span class="user-name">{{ $data['title'] ?? 'User' }}</span>
                            <br>
                            {{ $data['message'] ?? 'Notification message' }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('admin.notifications.showAll') }}"
        class="dropdown-item text-center">{{ __('admin.View All Notifications') }}</a>
</div>
</li>
