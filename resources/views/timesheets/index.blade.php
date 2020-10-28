@extends('admin::layouts.content')

@section('page_title')
    {{ __('Timesheets') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('Timesheets') }}</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.timesheets.create') }}" class="btn btn-lg btn-primary">
                    {{ __('Import Timesheets') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('timesheetGrid','Webkul\Admin\DataGrids\TimesheetDataGrid')

            {!! $timesheetGrid->render() !!}
        </div>
    </div>

@stop
