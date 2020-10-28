<div class="form-container">
    <div class="form-header mb-30">
        <span class="checkout-step-heading">{{ __('shop::app.checkout.onepage.summary') }}</span>
    </div>

    <div class="address-summary">
        @if ($cart->haveStockableItems() && $cart->shipping_address)
            <div class="shipping-address">
                <div class="card-title mb-20">
                    <b>{{ __('shop::app.checkout.onepage.shipping-address') }}</b>
                </div>

                <div class="card-content">
                    <ul>
                        <li class="mb-10">
                            {{ $cart->shipping_address->first_name }} {{ $cart->shipping_address->last_name }}
                        </li>
                        <li class="mb-10">
                            {{ $cart->shipping_address->address1 }},<br/> {{ $cart->shipping_address->city }}, {{ $cart->shipping_address->state }}<br/> {{ $cart->shipping_address->postcode }}
                        </li>

                        <span class="horizontal-rule mb-15 mt-15"></span>

                        <li class="mb-10">
                            {{ __('shop::app.checkout.onepage.contact') }} : {{ $cart->shipping_address->phone }}
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>

    @inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

    <div class="cart-item-list mt-20">
        @foreach ($cart->items as $item)
            @php
                $productBaseImage = $item->product->getTypeInstance()->getBaseImage($item);
            @endphp

            <div class="item mb-5" style="margin-bottom: 5px;">
                <div class="item-image">
                    <img src="{{ $productBaseImage['medium_image_url'] }}" />
                </div>

                <div class="item-details">

                    {!! view_render_event('bagisto.shop.checkout.name.before', ['item' => $item]) !!}

                    <div class="item-title">
                        {{ $item->product->name }}
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.name.after', ['item' => $item]) !!}
                    {!! view_render_event('bagisto.shop.checkout.price.before', ['item' => $item]) !!}

                    <div class="row">
                        <span class="title">
                            {{ __('shop::app.checkout.onepage.price') }}
                        </span>
                        <span class="value">
                            {{ core()->currency($item->base_price) }}
                        </span>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.price.after', ['item' => $item]) !!}
                    {!! view_render_event('bagisto.shop.checkout.quantity.before', ['item' => $item]) !!}

                    <div class="row">
                        <span class="title">
                            {{ __('shop::app.checkout.onepage.quantity') }}
                        </span>
                        <span class="value">
                            {{ $item->quantity }}
                        </span>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.quantity.after', ['item' => $item]) !!}

                    {!! view_render_event('bagisto.shop.checkout.options.before', ['item' => $item]) !!}

                    @if (isset($item->additional['attributes']))
                        <div class="item-options">

                            @foreach ($item->additional['attributes'] as $attribute)
                                <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                            @endforeach

                        </div>
                    @endif

                    {!! view_render_event('bagisto.shop.checkout.options.after', ['item' => $item]) !!}
                </div>
            </div>
        @endforeach
    </div>

    <div class="order-description mt-20">
        <div class="pull-left" style="width: 60%; float: left;">
            {{--@if ($cart->haveStockableItems())--}}
                {{--<div class="shipping">--}}
                    {{--<div class="decorator">--}}
                        {{--<i class="icon shipping-icon"></i>--}}
                    {{--</div>--}}

                    {{--<div class="text">--}}
                        {{--selected_shipping_rate--}}

                        {{--<div class="info">--}}
                            {{--selected_shipping_rate--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}

            {{--<div class="payment">--}}
                {{--<div class="decorator">--}}
                    {{--<i class="icon payment-icon"></i>--}}
                {{--</div>--}}

                {{--<div class="text">--}}
                    {{----}}
                {{--</div>--}}
            {{--</div>--}}

        </div>

        <div class="pull-right" style="width: 40%; float: left;">
            <slot name="summary-section"></slot>
        </div>
    </div>
</div>