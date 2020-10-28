@extends('admin::layouts.content')

@section('page_title')
    {{ __('app.points.title', ['customer_name' => $customer->first_name . ' ' . $customer->last_name]) }}
@stop

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>
                <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                {{ __('admin::app.customers.customers.title') }}
            </h1>
        </div>
    </div>
    <div class="tabs">
        <ul>
            @foreach ($menu_items as $item)
                <li class="{{ $item['active'] }}">
                    <a href="{{ $item['url'] }}">
                        {{ trans($item['name']) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('app.points.title_with_total_points', ['customer_name' => $customer->first_name . ' ' . $customer->last_name, 'customer_points' => $customer->reputation]) }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.points.deduct', ['id' => $customer->id]) }}" class="btn btn-lg btn-secondary">
                    {{ __('Deduct Points') }}
                </a>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.points.add', ['id' => $customer->id]) }}" class="btn btn-lg btn-primary">
                    {{ __('Add Points') }}
                </a>
            </div>
        </div>

        {!! view_render_event('bagisto.admin.customer.points.list.before') !!}

        <div class="page-content">
            @if($pointsType == 'timesheets')
                {!! app('Webkul\Admin\DataGrids\PointsDataGrid')->render() !!}
            @else
                {!! app('Webkul\Admin\DataGrids\PointModificationsDataGrid')->render() !!}
            @endif
        </div>

        {!! view_render_event('bagisto.admin.customer.points.list.after') !!}
    </div>
@stop
