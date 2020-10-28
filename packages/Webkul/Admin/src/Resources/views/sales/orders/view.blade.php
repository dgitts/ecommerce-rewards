@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.sales.orders.view-title', ['order_id' => $order->increment_id]) }}
@stop

@section('content-wrapper')

    <div class="content full-page">

        <div class="page-header">

            <div class="page-title">
                <h1>
                    {!! view_render_event('sales.order.title.before', ['order' => $order]) !!}

                    {{ __('admin::app.sales.orders.view-title', ['order_id' => $order->increment_id]) }}

                    {!! view_render_event('sales.order.title.after', ['order' => $order]) !!}
                </h1>
            </div>

            <div class="page-action">
                {!! view_render_event('sales.order.page_action.before', ['order' => $order]) !!}

                @if ($order->canCancel())
                    <a href="{{ route('admin.sales.orders.cancel', $order->id) }}" class="btn btn-lg btn-primary" v-alert:message="'{{ __('admin::app.sales.orders.cancel-confirm-msg') }}'">
                        {{ __('Cancel Order') }}
                    </a>
                @endif

                @if ($order->canShip())
                    <a href="{{ route('admin.sales.shipments.create', $order->id) }}" class="btn btn-lg btn-primary">
                        {{ __('admin::app.sales.orders.shipment-btn-title') }}
                    </a>
                @endif

                <a href="{{ route('admin.sales.orders.index') }}" class="btn btn-lg btn-primary">
                    {{ __('Back to Orders') }}
                </a>

                {!! view_render_event('sales.order.page_action.after', ['order' => $order]) !!}
            </div>
        </div>

        <div class="page-content">

            <tabs>
                {!! view_render_event('sales.order.tabs.before', ['order' => $order]) !!}

                <tab name="{{ __('admin::app.sales.orders.info') }}" :selected="true">
                    <div class="sale-container">

                        <accordian :title="'{{ __('admin::app.sales.orders.order-and-account') }}'" :active="true">
                            <div slot="body">

                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>{{ __('admin::app.sales.orders.order-info') }}</span>
                                    </div>

                                    <div class="section-content">
                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.order-date') }}
                                            </span>

                                            <span class="value">
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('m/d/y h:i a') }}
                                            </span>
                                        </div>

                                        {!! view_render_event('sales.order.created_at.after', ['order' => $order]) !!}

                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.order-status') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->status_label }}
                                            </span>
                                        </div>

                                        {!! view_render_event('sales.order.status_label.after', ['order' => $order]) !!}

                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.channel') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->channel_name }}
                                            </span>
                                        </div>

                                        {!! view_render_event('sales.order.channel_name.after', ['order' => $order]) !!}
                                    </div>
                                </div>

                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>{{ __('admin::app.sales.orders.account-info') }}</span>
                                    </div>

                                    <div class="section-content">
                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.customer-name') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->customer_full_name }}
                                            </span>
                                        </div>

                                        {!! view_render_event('sales.order.customer_full_name.after', ['order' => $order]) !!}

                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.email') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->customer_email }}
                                            </span>
                                        </div>

                                        {!! view_render_event('sales.order.customer_email.after', ['order' => $order]) !!}
                                    </div>
                                </div>

                            </div>
                        </accordian>

                        <accordian :title="'{{ __('admin::app.sales.orders.address') }}'" :active="true">
                            <div slot="body">

                                {{--<div class="sale-section">--}}
                                    {{--<div class="secton-title">--}}
                                        {{--<span>{{ __('admin::app.sales.orders.billing-address') }}</span>--}}
                                    {{--</div>--}}

                                    {{--<div class="section-content">--}}
                                        {{--@include ('admin::sales.address', ['address' => $order->billing_address])--}}

                                        {{--{!! view_render_event('sales.order.billing_address.after', ['order' => $order]) !!}--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                @if ($order->shipping_address)
                                    <div class="sale-section">
                                        <div class="secton-title">
                                            <span>{{ __('admin::app.sales.orders.shipping-address') }}</span>
                                        </div>

                                        <div class="section-content">
                                            @include ('admin::sales.address', ['address' => $order->shipping_address])

                                            {!! view_render_event('sales.order.shipping_address.after', ['order' => $order]) !!}
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </accordian>

                        <accordian :title="'{{ __('admin::app.sales.orders.products-ordered') }}'" :active="true">
                            <div slot="body">

                                <div class="table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>{{ __('admin::app.sales.orders.SKU') }}</th>
                                                <th>{{ __('admin::app.sales.orders.product-name') }}</th>
                                                <th>{{ __('admin::app.sales.orders.price') }}</th>
                                                <th>{{ __('admin::app.sales.orders.item-status') }}</th>
                                                <th>{{ __('admin::app.sales.orders.subtotal') }}</th>
                                                {{--<th>{{ __('admin::app.sales.orders.tax-percent') }}</th>--}}
                                                {{--<th>{{ __('admin::app.sales.orders.tax-amount') }}</th>--}}
                                                @if ($order->base_discount_amount > 0)
                                                    <th>{{ __('admin::app.sales.orders.discount-amount') }}</th>
                                                @endif
                                                <th>{{ __('admin::app.sales.orders.grand-total') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                                                    </td>

                                                    <td>
                                                        {{ $item->name }}

                                                        @if (isset($item->additional['attributes']))
                                                            <div class="item-options">

                                                                @foreach ($item->additional['attributes'] as $attribute)
                                                                    <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                                @endforeach

                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td>{{ core()->formatBasePrice($item->base_price) }}</td>

                                                    <td>
                                                        <span class="qty-row">
                                                            {{ $item->qty_ordered ? __('admin::app.sales.orders.item-ordered', ['qty_ordered' => $item->qty_ordered]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_invoiced ? __('admin::app.sales.orders.item-invoice', ['qty_invoiced' => $item->qty_invoiced]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_shipped ? __('admin::app.sales.orders.item-shipped', ['qty_shipped' => $item->qty_shipped]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_refunded ? __('admin::app.sales.orders.item-refunded', ['qty_refunded' => $item->qty_refunded]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_canceled ? __('admin::app.sales.orders.item-canceled', ['qty_canceled' => $item->qty_canceled]) : '' }}
                                                        </span>
                                                    </td>

                                                    <td>{{ core()->formatBasePrice($item->base_total) }}</td>

                                                    {{--<td>{{ $item->tax_percent }}%</td>--}}

                                                    {{--<td>{{ core()->formatBasePrice($item->base_tax_amount) }}</td>--}}

                                                    @if ($order->base_discount_amount > 0)
                                                        <td>{{ core()->formatBasePrice($item->base_discount_amount) }}</td>
                                                    @endif

                                                    <td>{{ core()->formatBasePrice($item->base_total + $item->base_tax_amount - $item->base_discount_amount) }}</td>
                                                </tr>
                                            @endforeach
                                    </table>
                                </div>

                                <table class="sale-summary">
                                    <tr>
                                        <td>{{ __('admin::app.sales.orders.subtotal') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->base_sub_total) }}</td>
                                    </tr>

                                    @if ($order->base_discount_amount > 0)
                                        <tr>
                                            <td>
                                                {{ __('admin::app.sales.orders.discount') }}

                                                @if ($order->coupon_code)
                                                    ({{ $order->coupon_code }})
                                                @endif
                                            </td>
                                            <td>-</td>
                                            <td>{{ core()->formatBasePrice($order->base_discount_amount) }}</td>
                                        </tr>
                                    @endif

                                    <tr class="bold">
                                        <td>{{ __('admin::app.sales.orders.grand-total') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->base_grand_total) }}</td>
                                    </tr>

                                    <tr class="bold">
                                        <td>{{ __('admin::app.sales.orders.total-paid') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->base_grand_total) }}</td>
                                    </tr>

                                    <tr class="bold">
                                        <td>{{ __('admin::app.sales.orders.total-refunded') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->base_grand_total_refunded) }}</td>
                                    </tr>
                                </table>

                            </div>
                        </accordian>

                    </div>
                </tab>

                @if ($order->shipping_address)
                    <tab name="{{ __('admin::app.sales.orders.shipments') }}">

                        <div class="table" style="padding: 20px 0">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('admin::app.sales.shipments.id') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.date') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.carrier-title') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.tracking-number') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.total-qty') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.action') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($order->shipments as $shipment)
                                        <tr>
                                            <td>#{{ $shipment->id }}</td>
                                            <td>{{ $shipment->created_at }}</td>
                                            <td>{{ $shipment->carrier_title }}</td>
                                            <td>{{ $shipment->track_number }}</td>
                                            <td>{{ $shipment->total_qty }}</td>
                                            <td class="action">
                                                <a href="{{ route('admin.sales.shipments.view', $shipment->id) }}">
                                                    <i class="icon eye-icon"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (! $order->shipments->count())
                                        <tr>
                                            <td class="empty" colspan="7">{{ __('admin::app.common.no-result-found') }}</td>
                                        <tr>
                                    @endif
                            </table>
                        </div>

                    </tab>
                @endif

                {!! view_render_event('sales.order.tabs.after', ['order' => $order]) !!}
            </tabs>
        </div>

    </div>
@stop
