@extends('shop::layouts.master')

@section('page_title')
 {{ __('Expired Password') }}
@endsection

@section('content-wrapper')

<div class="auth-content">

    {!! view_render_event('bagisto.shop.customers.password.expired.before') !!}

    <form method="post" action="{{ route('customer.password-expired.store') }}" >

        {{ csrf_field() }}

        <div class="login-form">

            <div class="login-text">{{ __('Reset Password') }}</div>

            <div class="alert alert-info">
                Your password has expired, please change it.
            </div>

            {!! view_render_event('bagisto.shop.customers.password_expired_form_controls.before') !!}

            <div class="control-group" :class="[errors.has('current_password') ? 'has-error' : '']">
                <label for="current_password">{{ __('Current Password') }}</label>
                <input type="password" class="control" name="current_password" v-validate="'required|min:6'" ref="password">
                <span class="control-error" v-if="errors.has('current_password')">@{{ errors.first('current_password') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                <label for="password">{{ __('shop::app.customer.reset-password.password') }}</label>
                <input type="password" class="control" name="password" v-validate="'required|min:6'" ref="password">
                <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('confirm_password') ? 'has-error' : '']">
                <label for="confirm_password">{{ __('shop::app.customer.reset-password.confirm-password') }}</label>
                <input type="password" class="control" name="password_confirmation"  v-validate="'required|min:6|confirmed:password'">
                <span class="control-error" v-if="errors.has('confirm_password')">@{{ errors.first('confirm_password') }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.password_expired_form_controls.before') !!}

            <input class="btn btn-primary btn-lg" type="submit" value="{{ __('shop::app.customer.reset-password.submit-btn-title') }}">

        </div>
    </form>

    {!! view_render_event('bagisto.shop.customers.reset_password.before') !!}
</div>
@endsection