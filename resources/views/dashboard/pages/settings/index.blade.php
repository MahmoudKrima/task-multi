@extends('dashboard.layouts.app')
@section('title', __('admin.settings'))
@push('css')
    <link href="{{ asset('assets_' . getAssetLang()) }}/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_' . getAssetLang()) }}/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet"
        type="text/css" />
@endpush
@push('breadcrumb')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{ __('admin.settings') }}</span></li>
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
                                <h4>{{ __('admin.settings') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-lg-12 col-12 mx-auto">
                                <form action="{{ route('admin.settings.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        @php
                                            $text = [
                                                'app_name_ar',
                                                'app_name_en',
                                                'app_store_url',
                                                'google_play_url',
                                                'phone',
                                                'whatsapp',
                                                'facebook',
                                                'twitter',
                                                'instagram',
                                                'youtube',
                                                'snapchat',
                                                'tiktok',
                                                'email',
                                            ];
                                            $imgs = ['logo', 'fav_icon'];
                                        @endphp

                                        <div class="row">
                                            @foreach ($settings as $setting)
                                                @if (in_array($setting->key, $text))
                                                    @if ($text == 'email')
                                                        <div class="col-md-6 mb-3">
                                                            <label for="{{ $setting->key }}Input"
                                                                class="text-dark">{{ __('admin.' . $setting->key) }}</label>
                                                            <input id="{{ $setting->key }}Input" type="email"
                                                                name="{{ $setting->key }}"
                                                                placeholder="{{ __('admin.' . $setting->key) }}"
                                                                class="form-control"
                                                                value="{{ old($setting->key, $setting->value) }}">
                                                        </div>
                                                    @else
                                                        <div class="col-md-6 mb-3">
                                                            <label for="{{ $setting->key }}Input"
                                                                class="text-dark">{{ __('admin.' . $setting->key) }}</label>
                                                            <input id="{{ $setting->key }}Input" type="text"
                                                                name="{{ $setting->key }}"
                                                                placeholder="{{ __('admin.' . $setting->key) }}"
                                                                class="form-control"
                                                                value="{{ old($setting->key, $setting->value) }}">
                                                        </div>
                                                    @endif
                                                @elseif(in_array($setting->key, $imgs))
                                                    <div class="col-12 mb-3 custom-file-container"
                                                        data-upload-id="{{ $setting->key }}">
                                                        <label>{{ __('admin.' . $setting->key) }}
                                                            <a href="javascript:void(0)"
                                                                class="custom-file-container__image-clear"
                                                                title="{{ __('admin.clear_image') }}">
                                                                <span
                                                                    style="background-color:#ababab;padding:5px;border-radius:50%;margin:0 10px;">X</span>
                                                            </a>
                                                        </label>
                                                        <label class="custom-file-container__custom-file">
                                                            <input type="file"
                                                                class="custom-file-container__custom-file__custom-file-input"
                                                                name="{{ $setting->key }}">
                                                            <span
                                                                class="custom-file-container__custom-file__custom-file-control"></span>
                                                        </label>
                                                        <div class="custom-file-container__image-preview">
                                                            @if ($setting->key === 'logo' || $setting->key === 'fav_icon' || $setting->key === 'download_app_image')
                                                                <img width="200px" height="200px"
                                                                    src="{{ displayImage($setting->value) }}"
                                                                    alt="{{ __('admin.' . $setting->key) }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
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
            var logoUpload = new FileUploadWithPreview('logo', {
                showDeleteButtonOnImages: true,
                maxFileCount: 1,
                imagePreviewClass: 'custom-file-container__image-preview',
                imagePreview: document.querySelector(
                    '.custom-file-container[data-upload-id="logo"] .custom-file-container__image-preview img'
                )
            });

            var favIconUpload = new FileUploadWithPreview('fav_icon', {
                showDeleteButtonOnImages: true,
                maxFileCount: 1,
                imagePreviewClass: 'custom-file-container__image-preview',
                imagePreview: document.querySelector(
                    '.custom-file-container[data-upload-id="fav_icon"] .custom-file-container__image-preview img'
                )
            });

            @foreach ($settings as $setting)
                @if (in_array($setting->key, ['logo', 'fav_icon']))
                    document.querySelector(
                        '.custom-file-container[data-upload-id="{{ $setting->key }}"] .custom-file-container__image-preview img'
                    ).src = "{{ displayImage($setting->value) }}";
                @endif
            @endforeach
        });
    </script>
@endpush
