@extends('dashboard.layouts.app')
@section('title', __('admin.update'))
@push('css')
    <link href="{{ asset('assets_' . getAssetLang()) }}/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_' . getAssetLang()) }}/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet"
        type="text/css" />
@endpush
@push('breadcrumb')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">{{ __('admin.admins') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{ __('admin.update') }}</span></li>
        </ol>
    </nav>
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="basic" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>{{ __('admin.update') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-lg-12 col-12 mx-auto">
                                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nameInput" class="text-dark">{{ __('admin.name') }}</label>
                                                <input id="nameInput" type="text" name="name"
                                                    placeholder="{{ __('admin.name') }}" class="form-control"
                                                    value="{{ old('name', $admin->name) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="phoneInput" class="text-dark">{{ __('admin.phone') }}</label>
                                                <input id="phoneInput" type="text" name="phone"
                                                    placeholder="{{ __('admin.phone') }}" class="form-control"
                                                    value="{{ old('phone', $admin->phone) }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="mailInput" class="text-dark">{{ __('admin.email') }}</label>
                                                <input id="mailInput" type="text" name="email"
                                                    placeholder="{{ __('admin.email') }}" class="form-control"
                                                    value="{{ old('email', $admin->email) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="passwordInput"
                                                    class="text-dark">{{ __('admin.password') }}</label>
                                                <input id="passwordInput" type="password" name="password"
                                                    placeholder="{{ __('admin.password') }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="roleInput" class="text-dark">{{ __('admin.role') }}</label>
                                                <select name="role" id="roleInput" class="form-control">
                                                    @foreach ($roles as $role)
                                                        <option @selected(old('role', $admin->roles[0]->id) == $role->id) value="{{ $role->id }}">
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3 custom-file-container" data-upload-id="image">
                                                <label>{{ __('admin.image') }}
                                                    <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                                        title="{{ __('admin.clear_image') }}">
                                                        <span
                                                            style="background-color:#ababab;padding:5px;border-radius:50%;margin:0 10px;">X</span>
                                                    </a>
                                                </label>
                                                <label class="custom-file-container__custom-file">
                                                    <input type="file"
                                                        class="custom-file-container__custom-file__custom-file-input"
                                                        name="image">
                                                    <span
                                                        class="custom-file-container__custom-file__custom-file-control"></span>
                                                </label>
                                                <div class="custom-file-container__image-preview">
                                                    <img width="200px" height="200px"
                                                        src="{{ displayImage($admin->image) }}" alt="{{ $admin->name }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="submit" value="{{ __('admin.update') }}"
                                                class="mt-4 btn btn-primary">
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
    <script src="{{ asset('assets_' . getAssetLang()) }}/assets/js/scrollspyNav.js"></script>
    <script src="{{ asset('assets_' . getAssetLang()) }}/plugins/file-upload/file-upload-with-preview.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var favIconUpload = new FileUploadWithPreview('image', {
                showDeleteButtonOnImages: true,
                maxFileCount: 1,
                imagePreviewClass: 'custom-file-container__image-preview',
                imagePreview: document.querySelector(
                    '.custom-file-container[data-upload-id="image"] .custom-file-container__image-preview img'
                )
            });

            document.querySelector(
                '.custom-file-container[data-upload-id="image"] .custom-file-container__image-preview img'
            ).src = "{{ displayImage($admin->image) }}";
        });
    </script>
@endpush
