@extends('dashboard.layouts.app')
@section('title', __('admin.tasks'))
@push('breadcrumb')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{ __('admin.tasks') }}</span></li>
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
                                @haspermission('task.create', 'admin')
                                    <a href="{{ route('admin.tasks.create') }}"
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
                                                <form action="{{ route('admin.tasks.search') }}" method="GET"
                                                    class="p-3">
                                                    <div class="row mt-2">
                                                        <div class="col-md-3 mb-3">
                                                            <label for="title">{{ __('admin.title') }}</label>
                                                            <input type="text" value="{{ request()->get('title') }}"
                                                                name="title" id="title" class="form-control"
                                                                placeholder="{{ __('admin.title') }}">
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="due_date">{{ __('admin.due_date') }}</label>
                                                            <input type="date" value="{{ request()->get('due_date') }}"
                                                                name="due_date" id="due_date" class="form-control"
                                                                placeholder="{{ __('admin.due_date') }}">
                                                        </div>
                                                        <div class="col-md-3 mb-3">
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
                                                        <div class="col-md-3 mb-3">
                                                            <label for="priorites">{{ __('admin.priority') }}</label>
                                                            <select name="priority" class="form-control" id="priorites">
                                                                <option value="">{{ __('admin.choose_priority') }}
                                                                </option>
                                                                @foreach ($priorites as $priority)
                                                                    <option @selected($priority->value == request()->get('priority'))
                                                                        value="{{ $priority->value }}">
                                                                        {{ $priority->lang() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="created_by">{{ __('admin.created_by') }}</label>
                                                            <select name="created_by" class="form-control" id="created_by">
                                                                <option value="">{{ __('admin.choose_creator') }}
                                                                </option>
                                                                @foreach ($creators as $creator)
                                                                    <option @selected($creator->id == request()->get('created_by'))
                                                                        value="{{ $creator->id }}">
                                                                        {{ $creator->name }}</option>
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
                                                                href="{{ route('admin.tasks.index') }}">{{ __('admin.cancel') }}</a>
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
                                    <h4 style="padding: 30px 0px 15px 0px;">{{ trans('admin.tasks') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin.title') }}</th>
                                        <th scope="col">{{ __('admin.description') }}</th>
                                        <th scope="col">{{ __('admin.due_date') }}</th>
                                        <th scope="col">{{ __('admin.created_by') }}</th>
                                        <th scope="col">{{ __('admin.priority') }}</th>
                                        <th scope="col">{{ __('admin.status') }}</th>
                                        @if (auth('admin')->user()->hasAnyPermission(['task.update', 'task.delete']))
                                            <th class="text-center" scope="col">{{ trans('admin.actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>
                                                {{ $task->title ?? __('admin.n/a') }}
                                            </td>
                                            <td>
                                                {!! $task->description !!}
                                            </td>
                                            <td>
                                                {{ $task->due_date ?? __('admin.n/a') }}
                                            </td>
                                            <td>
                                                {{ $task->creator->name ?? __('admin.n/a') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="{{ $task->priority->badge() }}">{{ $task->priority->lang() }}</span>
                                            </td>
                                            <td>
                                                @if (auth('admin')->user()->hasAnyPermission(['task.update']) && auth('admin')->user()->hasRole('employee') && $task->status->value !== 'completed' && $task->due_date >=Carbon\Carbon::today()->format('Y-m-d'))
                                                    <form method="POST"
                                                        action="{{ route('admin.tasks.updateStatus', $task->id) }}">
                                                        @csrf
                                                        <button
                                                            class="{{ $task->status->badge() }} btn-sm btn-alert">{{ $task->status->lang() }}</button>
                                                    </form>
                                                @else
                                                    <span
                                                        class="{{ $task->status->badge() }}">{{ $task->status->lang() }}</span>
                                                @endif
                                            </td>
                                            @if (auth('admin')->user()->hasAnyPermission(['task_attachment.view', 'task.update', 'task.delete']) &&
                                                    (auth('admin')->user()->hasRole('admin') ||
                                                        auth('admin')->user()->hasRole('manager') ||
                                                        auth('admin')->user()->id == $task->created_by))
                                                <td class="text-center">
                                                    <div class="action-btns d-flex justify-content-center">
                                                        @if ($task->due_date >= Carbon\Carbon::today()->format('Y-m-d'))
                                                            @haspermission('task_attachment.view', 'admin')
                                                                <a href="{{ route('admin.tasks.show', $task->id) }}"
                                                                    class="action-btn btn-edit bs-tooltip me-2 badge rounded-pill bg-info"
                                                                    title="{{ __('admin.show_task') }}" style="padding:7px;"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    aria-label="Edit" data-bs-original-title="Edit">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                                        height="17" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-eye">
                                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                        </path>
                                                                        <circle cx="12" cy="12" r="3"></circle>
                                                                    </svg>
                                                                </a>
                                                            @endhaspermission
                                                            @haspermission('task.update', 'admin')
                                                                <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                                    class="action-btn btn-edit ml-1 bs-tooltip me-2 badge rounded-pill bg-warning"
                                                                    title="{{ __('admin.edit') }}" style="padding:7px;"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    aria-label="Edit" data-bs-original-title="Edit">
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
                                                            @endhaspermission
                                                        @endif
                                                        @haspermission('task.delete', 'admin')
                                                            <form action="{{ route('admin.tasks.delete', $task->id) }}"
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
