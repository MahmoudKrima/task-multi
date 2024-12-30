@extends('dashboard.layouts.app')
@section('title', __('admin.show_category_stores'))
@push('breadcrumb')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('admin.categories') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{ $category->name }}</span></li>
        </ol>
    </nav>
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row mt-2">
                            <div class="col-12" style="margin: 15px 15px 0 15px;">
                                @haspermission('store.create', 'admin')
                                    <a href="{{ route('admin.stores.create') }}"
                                        class="btn btn-primary">{{ __('admin.create') }}</a>
                                @endhaspermission
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            {{ trans('admin.Filter Options') }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive mb-2">
                                            <div class="col-12 mx-auto border">
                                                <form action="{{ route('admin.categories.searchStores', $category->id) }}"
                                                    method="GET" class="p-3">
                                                    <div class="row mt-2">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="name">{{ __('admin.name') }}</label>
                                                            <input type="text" value="{{ request()->get('name') }}"
                                                                name="name" id="name" class="form-control"
                                                                placeholder="{{ __('admin.name') }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="status">{{ __('admin.status') }}</label>
                                                            <select name="status" class="form-control" id="status">
                                                                <option value="">{{ __('admin.choose_status') }}
                                                                </option>
                                                                @foreach ($status as $stat)
                                                                    <option @selected($stat->value == request()->get('status'))
                                                                        value="{{ $stat->value }}">
                                                                        {{ $stat->lang() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="featured">{{ __('admin.featured') }}</label>
                                                            <select name="featured" class="form-control" id="featured">
                                                                <option value="">{{ __('admin.choose') }}
                                                                </option>
                                                                @foreach ($bools as $bool)
                                                                    <option @selected($bool->value == request()->get('featured'))
                                                                        value="{{ $bool->value }}">
                                                                        {{ $bool->lang() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="sponsored">{{ __('admin.sponsored') }}</label>
                                                            <select name="sponsored" class="form-control" id="sponsored">
                                                                <option value="">{{ __('admin.choose') }}
                                                                </option>
                                                                @foreach ($bools as $bool)
                                                                    <option @selected($bool->value == request()->get('sponsored'))
                                                                        value="{{ $bool->value }}">
                                                                        {{ $bool->lang() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-3 mb-3">
                                                            <button type="submit"
                                                                class="bg-success form-control btn-block">{{ __('admin.search') }}</button>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <a role="button" class="btn btn-danger form-control btn-block"
                                                                href="{{ route('admin.categories.show', $category->id) }}">{{ __('admin.cancel') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 style="padding: 30px 0px 15px 0px;">{{ $category->name }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin.image') }}</th>
                                        <th scope="col">{{ __('admin.name') }}</th>
                                        <th scope="col">{{ __('admin.description') }}</th>
                                        <th scope="col">{{ __('admin.map_url') }}</th>
                                        <th scope="col">{{ __('admin.social_medias') }}</th>
                                        <th scope="col">{{ __('admin.sponsored') }}</th>
                                        <th scope="col">{{ __('admin.featured') }}</th>
                                        <th scope="col">{{ __('admin.featured_order') }}</th>
                                        <th scope="col">{{ __('admin.status') }}</th>
                                        @if (auth('admin')->user()->hasAnyPermission(['store.update', 'store.delete']))
                                            <th class="text-center" scope="col">{{ trans('admin.actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stores as $store)
                                        <tr>
                                            <td>
                                                <a href="{{ displayImage($store->image) }}" target="_blank">
                                                    <img width="40px" height="40px" class="rounded-circle"
                                                        src="{{ displayImage($store->image) }}" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                {{ $store->name }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#descModal{{$store->id}}" >
                                                    {{ __('admin.description') }}
                                                </button>
                                            </td>
                                            <td>
                                                <a class="btn btn-secondary btn-sm" href="{{ $store->map_url }}"
                                                    target="_blank">
                                                    {{ __('admin.map_url') }}
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                                                    data-target="#socialModal" data-socials="{{ $store->socials }}">
                                                    {{ __('admin.social_medias') }}
                                                </button>
                                            </td>
                                            <td>
                                                @if (auth('admin')->user()->hasAnyPermission(['store.update']))
                                                    <form method="POST"
                                                        action="{{ route('admin.stores.updateSponsored', $store->id) }}">
                                                        @csrf
                                                        <button
                                                            class="{{ $store->sponsored->badge() }} btn-sm btn-alert">{{ $store->sponsored->lang() }}</button>
                                                    </form>
                                                @else
                                                    <span
                                                        class="{{ $store->sponsored->badge() }}">{{ $store->sponsored->lang() }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (auth('admin')->user()->hasAnyPermission(['store.update']))
                                                    <button type="button" class="{{ $store->featured->badge() }} btn-sm"
                                                        data-toggle="modal" data-target="#editFeaturedModal"
                                                        data-id="{{ $store->id }}"
                                                        data-featured="{{ $store->featured->value }}"
                                                        data-featured-order="{{ $store->featured_order }}">
                                                        {{ $store->featured->lang() }}
                                                    </button>
                                                @else
                                                    <span
                                                        class="{{ $store->featured->badge() }}">{{ $store->featured->lang() }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $store->featured_order ?? __('admin.n/a') }}
                                            </td>
                                            <td>
                                                @if (auth('admin')->user()->hasAnyPermission(['store.update']))
                                                    <form method="POST"
                                                        action="{{ route('admin.stores.updateStatus', $store->id) }}">
                                                        @csrf
                                                        <button
                                                            class="{{ $store->status->badge() }} btn-sm btn-alert">{{ $store->status->lang() }}</button>
                                                    </form>
                                                @else
                                                    <span
                                                        class="{{ $store->status->badge() }}">{{ $store->status->lang() }}</span>
                                                @endif
                                            </td>
                                            @if (auth('admin')->user()->hasAnyPermission(['store.update', 'store.delete']))
                                                <td class="text-center">
                                                    <div class="action-btns d-flex justify-content-center">
                                                        @haspermission('store.update', 'admin')
                                                            <a href="{{ route('admin.stores.edit', $store->id) }}"
                                                                class="action-btn btn-edit bs-tooltip me-2 badge rounded-pill bg-warning"
                                                                title="{{ __('admin.edit') }}" style="padding:7px;"
                                                                data-toggle="tooltip" data-placement="top" aria-label="Edit"
                                                                data-bs-original-title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                                    height="17" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit-2">
                                                                    <path
                                                                        d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                            <a href="{{ route('admin.stores.storeImages', $store->id) }}"
                                                                class="action-btn btn-edit ml-1 bs-tooltip me-2 badge rounded-pill bg-success"
                                                                title="{{ __('admin.sub_images') }}" style="padding:7px;"
                                                                data-toggle="tooltip" data-placement="top" aria-label="Edit"
                                                                data-bs-original-title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                                    height="17" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-image">
                                                                    <rect x="3" y="3" width="18" height="18"
                                                                        rx="2" ry="2"></rect>
                                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                                </svg>
                                                            </a>
                                                        @endhaspermission
                                                        @haspermission('store.delete', 'admin')
                                                            <form action="{{ route('admin.stores.delete', $store->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button title="{{ __('admin.delete') }}"
                                                                    style="border: none; background:transparent;padding:7px;margin:0 5px;"
                                                                    type="submit"
                                                                    class="action-btn btn-alert bs-tooltip badge rounded-pill bg-danger"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    aria-label="Delete" data-bs-original-title="Delete">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                                        height="17" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-trash-2">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                        </path>
                                                                        <line x1="10" y1="11" x2="10"
                                                                            y2="17"></line>
                                                                        <line x1="14" y1="11" x2="14"
                                                                            y2="17"></line>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endhaspermission
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                        <div class="modal fade" id="descModal{{$store->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ __('admin.description') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ strip_tags(html_entity_decode($store->description)) }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('admin.close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $stores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editFeaturedModal" tabindex="-1" role="dialog"
        aria-labelledby="editFeaturedModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFeaturedModalLabel">{{ __('admin.update') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="store_id" id="store-id">
                        <div class="form-group">
                            <label for="admin-featured">{{ __('admin.featured') }}</label>
                            <select name="featured" id="admin-featured" class="form-control">
                                <option selected disabled>{{ __('admin.choose') }}</option>
                                @foreach ($bools as $boo)
                                    <option value="{{ $boo->value }}">{{ $boo->lang() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="dynamic-fields"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('admin.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="socialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.social_medias') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('admin.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#descModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var description = button.data('description');
            var modal = $(this);
            modal.find('.modal-body').html(description);
        });
        const translations = {
            instagram: '{{ __('admin.instagram') }}',
            facebook: '{{ __('admin.facebook') }}',
            phone: '{{ __('admin.phone') }}',
            whatsapp: '{{ __('admin.whatsapp') }}',
            snapchat: '{{ __('admin.snapchat') }}',
            tiktok: '{{ __('admin.tiktok') }}',
            twitter: '{{ __('admin.twitter') }}',
        };

        $('#socialModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var socials = button.data('socials');
            var modal = $(this);
            modal.find('.modal-body').empty();
            if (Array.isArray(socials) && socials.length) {
                var html = '';
                socials.forEach(function(social) {
                    var translatedSocialMedia = translations[social.social_media] || social.social_media;

                    if (social.social_media === 'phone' || social.social_media === 'whatsapp') {
                        html += '<p><strong>' + htmlspecialchars(translatedSocialMedia) + ':</strong> ';
                        html += htmlspecialchars(social.link);
                        html += '</p>';
                    } else {
                        html += '<p><strong>' + htmlspecialchars(translatedSocialMedia) + ':</strong> ';
                        html += '<a href="' + htmlspecialchars(social.link) + '" target="_blank">' +
                            '{{ __('admin.link') }}' + '</a></p>';
                    }
                });
                modal.find('.modal-body').html(html);
            } else {
                modal.find('.modal-body').html('<p>' + '{{ __('admin.no_social_media_links') }}' + '</p>');
            }
        });

        function htmlspecialchars(string) {
            var div = document.createElement('div');
            div.appendChild(document.createTextNode(string));
            return div.innerHTML;
        }

        $(document).ready(function() {
            $('#editFeaturedModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var featured = button.data('featured');
                var featuredOrder = button.data('featured-order');

                var modal = $(this);
                modal.find('.modal-body #store-id').val(id);
                modal.find('form').attr('action', '{{ route('admin.stores.updateFeatured', '') }}');
                modal.find('.modal-body #admin-featured').val(featured);

                $('#dynamic-fields').empty();
                if (featured === 'yes') {
                    createFeaturedOrderInput(featuredOrder);
                }
            });

            $('#admin-featured').change(function() {
                var selectedFeatured = $(this).val();
                if (selectedFeatured === 'yes') {
                    createFeaturedOrderInput();
                } else if (selectedFeatured === 'no') {
                    $('#dynamic-fields').empty();
                }
            });

            function createFeaturedOrderInput(featuredOrder = null) {
                $('#dynamic-fields').html(
                    '<div class="form-group">' +
                    '<label for="featured_order">{{ __('admin.featured_order') }}</label>' +
                    '<input type="number" name="featured_order" id="featured_order" class="form-control" value="' +
                    featuredOrder + '" min="1" placeholder="{{ __('admin.featured_order') }}">' +
                    '</div>'
                );
            }
        });
    </script>
@endpush
