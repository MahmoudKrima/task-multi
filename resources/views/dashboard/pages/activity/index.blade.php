@extends('dashboard.layouts.app')
@section('title', __('admin.activity_logs'))

@push('breadcrumb')
<nav class="breadcrumb-one" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{  __('admin.activity_logs') }}</li>
    </ol>
</nav>
@endpush

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row mt-2">
                        <div class="col-12">
                            <h4>{{ __('admin.activity_logs') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.date') }}</th>
                                    <th>{{ __('admin.description') }}</th>
                                    <th>{{ __('admin.causer') }}</th>
                                    <th>{{ __('admin.subject') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ $activity->causer ? $activity->causer->name : __('admin.n/a') }}</td>
                                        <td>
                                            @if ($activity->subject)
                                                {{ class_basename($activity->subject) }}: {{ $activity->subject->id }}
                                            @else
                                                {{ __('admin.n/a') }}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No activity logs found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
