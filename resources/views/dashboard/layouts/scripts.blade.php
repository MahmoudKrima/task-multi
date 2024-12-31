<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="{{ tenant_asset('assets_' . getAssetLang()) }}/bootstrap/js/popper.min.js"></script>
<script src="{{ tenant_asset('assets_' . getAssetLang()) }}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ tenant_asset('assets_' . getAssetLang()) }}/plugins/perfect-scrollbar/perfect-scrollbar.min.js">
</script>
<script src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/js/custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>

<script src="{{ tenant_asset('vendor/toastr/build/toastr.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        App.init();

        function updateNotifications() {
            $.ajax({
                url: '{{ route('admin.notifications.get') }}',
                type: 'GET',
                success: function(response) {

                    const totalNotifications = response.total;
                    const badge = $('.notification-dropdown .badge');
                    badge.text(totalNotifications > 9 ? '+9' : totalNotifications);
                    const notificationScroll = $('.notification-scroll');
                    notificationScroll.empty();
                    $('.notifciation-table').load(" .notifciation-table > * ")
                    response.notifications.forEach(function(notification) {
                        const data = notification.data;
                        const notificationItem = `
                            <div class="dropdown-item">
                                <div class="media">
                                    <!-- Customize icon based on notification type if needed -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-bell">
                                    </svg>
                                    <div class="media-body">
                                        <div class="notification-para">
                                            <span class="user-name">${data['title'] ?? 'User'}</span><br>
                                            ${data['message'] ?? 'Notification message'}
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        notificationScroll.append(notificationItem);
                    });
                },
                error: function(error) {
                    console.error('Error fetching notifications:', error);
                }
            });
        }
        setInterval(updateNotifications, 5000);
    });
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": @if (app()->getLocale() == 'ar')
            "toast-top-left"
        @else
            "toast-top-right"
        @endif ,
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

    $('.btn-alert').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');

        var url = form.attr('action');
        var method = form.attr('method');
        swal.fire({
            title: '{{ __('admin.are_you_sure') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#72b40c",
            confirmButtonText: "{{ __('admin.yes') }}",
            cancelButtonText: "{{ __('admin.no') }}",
            reverseButtons: false
        }).then(function(value) {
            if (value.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true,
    });

    var channel = pusher.subscribe('private-tasks.{{ auth('admin')->id() }}');
    channel.bind('App\\Events\\TaskReminderEvent', function(data) {
        toastr.info(
            `<strong>Title:</strong> ${data.title}<br><strong>Due Date:</strong> ${data.due_date}<br><strong>Message:</strong> ${data.message}`,
            'Task Reminder'
        );
    });
</script>


<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@stack('js')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
