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
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@stack('js')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
