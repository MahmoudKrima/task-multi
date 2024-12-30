@extends('dashboard.layouts.app')
@section('title', __('admin.edit'))
@push('css')
    <link href="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="{{ tenant_asset('assets_' . getAssetLang()) }}/plugins/file-upload/file-upload-with-preview.min.css"
        rel="stylesheet" type="text/css" />
@endpush
@push('breadcrumb')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">{{ __('admin.tasks') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{ __('admin.edit') }}</span></li>
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
                                <h4>{{ __('admin.edit') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-lg-12 col-12 mx-auto">
                                <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="title">{{ __('admin.title') }}</label>
                                                <input type="text" value="{{ old('title', $task->title ?? '') }}"
                                                    name="title" id="title" class="form-control"
                                                    placeholder="{{ __('admin.title') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="due_date">{{ __('admin.due_date') }}</label>
                                                <input type="date" value="{{ old('due_date', $task->due_date ?? '') }}"
                                                    name="due_date" id="due_date" class="form-control"
                                                    placeholder="{{ __('admin.due_date') }}">
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="priorites">{{ __('admin.priority') }}</label>
                                                <select name="priority" class="form-control" id="priorites">
                                                    <option value="">{{ __('admin.choose_priority') }}</option>
                                                    @foreach ($priorites as $priority)
                                                        <option @selected(old('priority', $task->priority->value ?? '') == $priority->value)
                                                            value="{{ $priority->value }}">
                                                            {{ $priority->lang() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="status">{{ __('admin.status') }}</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option disabled>{{ __('admin.choose_status') }}</option>
                                                    @foreach ($status as $stat)
                                                        <option @selected(old('status', $task->status->value ?? '') == $stat->value) value="{{ $stat->value }}">
                                                            {{ $stat->lang() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="description">{{ __('admin.description') }}</label>
                                                <textarea name="description" id="description" class="form-control editor" cols="5" rows="5">{{ old('description', $task->description ?? '') }}</textarea>
                                            </div>

                                            @if (auth('admin')->user()->hasAnyPermission(['task.assign']))
                                                <div class="col-md-6 mb-3">
                                                    <label for="users">{{ __('admin.assign_to') }}</label>
                                                    <select class="js-example-basic-multiple form-control" name="users[]"
                                                        multiple="multiple" id="users">
                                                        @foreach ($users as $user)
                                                            <option @selected(is_array(old('users', $task->users->pluck('id')->toArray() ?? [])) && in_array($user->id, old('users', $task->users->pluck('id')->toArray() ?? [])))
                                                                value="{{ $user->id }}">
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <input type="submit" value="{{ __('admin.edit') }}"
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
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/js/scrollspyNav.js"></script>
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/plugins/file-upload/file-upload-with-preview.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    @include('dashboard.partials.ckeditor')
@endpush
