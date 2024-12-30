@extends('dashboard.layouts.app')
@section('title', __('admin.notifications'))
@push('breadcrumb')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{ __('admin.notifications') }}</span></li>
        </ol>
    </nav>
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    @if ($notifications->count() > 0)
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-12" style="margin: 15px 15px 0 15px;">
                                    <form method="POST" action="{{ route('admin.notifications.deleteAll') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            {{ __('admin.delete_all') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="widget-content widget-content-area">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 style="padding: 30px 0px 15px 0px;">{{ trans('admin.notifications') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter notifciation-table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin.notification') }}</th>
                                        <th class="text-center" scope="col">{{ trans('admin.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>
                                                <p class="mb-0">{{$notification->data['title']}}
                                                </p>
                                                <p class="mb-0">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-btns d-flex justify-content-center">
                                                    <form
                                                        action="{{ route('admin.notifications.delete', $notification->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            style="border: none; background:transparent;padding:7px;margin:0 5px;"
                                                            type="submit" title="{{ __('admin.delete') }}"
                                                            class="action-btn btn-alert bs-tooltip badge rounded-pill bg-danger"
                                                            data-toggle="tooltip" data-placement="top" aria-label="Delete"
                                                            data-bs-original-title="Delete">
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
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
