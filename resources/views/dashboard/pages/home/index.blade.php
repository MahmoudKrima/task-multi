@extends('dashboard.layouts.app')
@section('title', __('admin.dashboard'))
@push('css')
    <link href="{{ tenant_asset('assets_' . getAssetLang()) }}/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/css/dashboard/dash_1.css" rel="stylesheet"
        type="text/css" />
    <style>
        .action-btn-size {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
        }
    </style>
@endpush
@push('breadcrumb')
    <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li> --}}
        <li class="breadcrumb-item active" aria-current="page"><span>{{ __('admin.dashboard') }}</span></li>
    </ol>
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">{{ __('admin.total_tasks') }}</h5>
                    </div>

                    <div class="widget-content">
                        <div class="tabs tab-content">
                            <div id="content_1" class="tabcontent">

                                @php
                                    $xx = implode(',', $data['total_tasks']);
                                    $yy = explode(',', $xx);
                                    $chartTransactions = (new \Akaunting\Apexcharts\Chart())
                                        ->setType('area')
                                        ->setWidth('100%')
                                        ->setHeight(300)
                                        ->setLabels(array_keys($data['total_tasks']))
                                        ->setDataset('', 'area', $yy);
                                @endphp

                                {!! $chartTransactions->container() !!}

                                {!! $chartTransactions->script() !!}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-two" style="height:395px">
                    <div class="widget-heading">
                        <h5 class="">{{ __('admin.task_piriority') }}</h5>
                    </div>
                    <div class="widget-content">
                        @php
                            $chart2 = (new \Akaunting\Apexcharts\Chart())
                                ->setType('pie')
                                ->setWidth('100%')
                                ->setHeight(320)
                                ->setLabels($data['chart2']['statusLabels'])
                                ->setDataset(
                                    __('admin.order_status_distribution'),
                                    'donut',
                                    $data['chart2']['statusCounts'],
                                )
                                ->setColors(['#c1982b', '#f67f32', '#1aaa6f']);
                        @endphp
                        {!! $chart2->container() !!}
                        {!! $chart2->script() !!}
                    </div>
                </div>
            </div>

            @if(!auth('admin')->user()->hasRole('employee'))
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two">

                    <div class="widget-heading">
                        <h5 class="">{{ __('admin.user_tasks') }}</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="th-content">{{ __('admin.name') }}</div>
                                        </th>
                                        <th>
                                            <div class="th-content">{{ __('admin.tasks') }}</div>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['adminsWithTaskCount'] as $admin)
                                        <tr>
                                            <td>
                                                <div class="td-content customer-name"><img
                                                        src="{{ displayImage($admin->image) }}"
                                                        alt="avatar">{{ $admin->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="td-content product-brand">{{ $admin->tasks_count }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three">

                    <div class="widget-heading">
                        <h5 class="">{{__('admin.latest_tasks')}}</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="th-content">{{__('admin.title')}}</div>
                                        </th>
                                        <th>
                                            <div class="th-content th-heading">{{__('admin.priority')}}</div>
                                        </th>
                                        <th>
                                            <div class="th-content th-heading">{{__('admin.status')}}</div>
                                        </th>
                                        <th>
                                            <div class="th-content">{{__('admin.due_date')}}</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['tasksDueDate'] as $task)
                                    <tr>
                                        <td>
                                            <div class="td-content"><span class="pricing">{{$task->title}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="td-content"><span class="discount-pricing">{{$task->priority->value}}</span></div>
                                        </td>
                                        <td>
                                            <div class="td-content">{{$task->status->value}}</div>
                                        </td>
                                        <td>
                                            <div class="td-content"><span class="discount-pricing">{{$task->due_date}}</span></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/plugins/apex/apexcharts.min.js"></script>
    <script src="{{ tenant_asset('assets_' . getAssetLang()) }}/assets/js/dashboard/dash_1.js"></script>
@endpush
@apexchartsScripts
