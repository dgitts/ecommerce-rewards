@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.account.profile.index.title') }}
@endsection

@section('content-wrapper')

<div class="account-content">

    @include('shop::customers.account.partials.sidemenu')

    <div class="account-layout">

        <div class="account-head">

            <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>

            <span class="account-heading">{{ __('shop::app.customer.account.profile.index.title') }}</span>

            <div class="horizontal-rule"></div>
        </div>

         {!! view_render_event('bagisto.shop.customers.account.profile.view.before', ['customer' => $customer]) !!}

        <div class="account-table-content" style="width: 50%;">
            <table style="color: #5E5E5E;">
                <tbody>
                    {!! view_render_event(
                    'bagisto.shop.customers.account.profile.view.table.before', ['customer' => $customer])
                    !!}
                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.fname') }}</td>
                        <td>{{ $customer->first_name }}</td>
                    </tr>

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.first_name.after', ['customer' => $customer]) !!}

                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.lname') }}</td>
                        <td>{{ $customer->last_name }}</td>
                    </tr>

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.last_name.after', ['customer' => $customer]) !!}

                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.points') }}</td>
                        <td>{{ __($customer->reputation) }}</td>
                    </tr>

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.points.after', ['customer' => $customer]) !!}

                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.email') }}</td>
                        <td>{{ $customer->email }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.phone') }}</td>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                    {!! view_render_event(
                    'bagisto.shop.customers.account.profile.view.table.after', ['customer' => $customer])
                    !!}

                    {{-- @if ($customer->subscribed_to_news_letter == 1)
                        <tr>
                            <td> {{ __('shop::app.footer.subscribe-newsletter') }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('shop.unsubscribe', $customer->email) }}">{{ __('shop::app.subscription.unsubscribe') }} </a>
                            </td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.view.after', ['customer' => $customer]) !!}
    </div>
</div>
@endsection
