@extends('admin::layouts.content')

@section('page_title')
    {{ __('app.points.create-title', ['add_deduct' => $add_deduct]) }}
@stop


@section('content-wrapper')

    <div class="content full-page">
        {!! view_render_event('admin.customer.points.create.before') !!}

        <form method="POST" action="{{ route('admin.points.store', ['id' => $customer->id]) }}" @submit.prevent="onSubmit">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('app.points.create-title', ['add_deduct' => $add_deduct]) }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <input type="hidden" name="add_deduct" value="{{ $add_deduct }}">

                    <div slot="body">

                        <div class="control-group" :class="[errors.has('points') ? 'has-error' : '']">
                            <label for="points">{{ __('Points') }}</label>
                            <input type="number" class="control" name="points" value="{{ old('points') }}" data-vv-as="&quot;{{ __('Points') }}&quot;">
                            <span class="control-error" v-if="errors.has('points')">@{{ errors.first('points') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('notes') ? 'has-error' : '']">
                            <label for="notes">{{ __('Enter Reason for Point Modification') }}</label>

                            <textarea class="control" name="notes"></textarea>

                            <span class="control-error" v-if="errors.has('notes')">@{{ errors.first('notes') }}</span>
                        </div>

                    </div>

                </div>
            </div>
        </form>

        {!! view_render_event('admin.customer.points.create.after') !!}
    </div>
@stop