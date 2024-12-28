@extends('dashboard.layouts.app')
@section('title', __('admin.edit'))
@push('breadcrumb')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{ __('admin.roles') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{ __('admin.edit') }}</span></li>
        </ol>
    </nav>
@endpush
@push('css')
    <link rel="stylesheet" type="text/css"
        href="{{ tenant_asset('admin/assets_' . getAssetLang()) }}/plugins/dropify/dropify.min.css">
    <link href="{{ tenant_asset('admin/assets_' . getAssetLang()) }}/assets/css/users/account-setting.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ tenant_asset('admin/css/styleRoles.css') }}">
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="basic" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>{{ __('admin.edit') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-lg-12 col-12 mx-auto">
                                <form id="general-info" method="post"
                                    action="{{ route('admin.roles.update', $role->id) }}">
                                    @csrf
                                    <div class="info">
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-12 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="nameArInput"
                                                                        class="text-dark">{{ __('admin.role') }}</label>
                                                                    <input id="nameArInput" type="text" name="name"
                                                                        placeholder="{{ __('admin.role') }}"
                                                                        class="form-control"
                                                                        value="{{ old('name', $role->name) }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table class="permissions-table table table-responsive">
                                                                        <tbody>
                                                                            @php
                                                                                $currentGroup = '';
                                                                            @endphp
                                                                            <tr>
                                                                                <th>
                                                                                    <input type="checkbox"
                                                                                        id="select-all-checkbox">
                                                                                    <label
                                                                                        for="select-all-checkbox">{{ __('admin.select_all') }}</label>
                                                                                </th>
                                                                            </tr>
                                                                            @foreach ($permissions as $key => $p)
                                                                                @php
                                                                                    $array = explode(
                                                                                        '.',
                                                                                        $permissions[$key]['name'],
                                                                                    );
                                                                                    $groupName = __(
                                                                                        'admin.' . $array[0],
                                                                                    );
                                                                                @endphp
                                                                                @if ($groupName !== $currentGroup)
                                                                                    @if ($currentGroup != '')
                                                                                        </tr>
                                                                                    @endif
                                                                                    <tr>
                                                                                        <td class="font-weight-bold">
                                                                                            {{ $groupName }}
                                                                                        </td>
                                                                                        @php
                                                                                            $currentGroup = $groupName;
                                                                                        @endphp
                                                                                @endif
                                                                                <td class="py-2">
                                                                                    <input type="checkbox"
                                                                                        value="{{ $permissions[$key]['id'] }}"
                                                                                        name="permission_id[]"
                                                                                        {{ in_array($permissions[$key]['id'], $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                                                    {{ __('admin.' . $array[1]) }}
                                                                                </td>
                                                                            @endforeach
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <input type="submit" value="{{ __('admin.update') }}"
                                                                        class="mt-4 btn btn-primary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ tenant_asset('admin/assets_' . getAssetLang()) }}/plugins/dropify/dropify.min.js"></script>
    <script src="{{ tenant_asset('admin/assets_' . getAssetLang()) }}/plugins/blockui/jquery.blockUI.min.js"></script>
    <script src="{{ tenant_asset('admin/assets_' . getAssetLang()) }}/assets/js/users/account-settings.js"></script>
    <script src="{{ tenant_asset('admin/js/selectAll.js') }}"></script>
@endpush
