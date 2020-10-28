@extends('admin::layouts.content')

@section('page_title')
    {{ __('app.timesheets.import-timesheet') }}
@stop

@section('content')
    <div class="content">

        <form method="POST" action="{{ route('admin.timesheet.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('app.timesheets.import-timesheet') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('app.timesheets.import-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-container">
                    @csrf()

                    <div class="control-group" :class="[errors.has('file') ? 'has-error' : '']">
                        <label for="file" class="required">{{ __('app.timesheets.import_file') }}</label>
                        <input type="file" name="file" class="form-control">
                        <span class="control-error" v-if="errors.has('file')">@{{ errors.first('file') }}</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop