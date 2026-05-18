@extends('layouts.app')

@section('content')

<div class="profile-page">

    <div class="profile-section-title">
        <h2>My Orders</h2>
    </div>

    @if(session('success'))
        <div class="success-popup" style="margin-bottom:20px;">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count() > 0)

        <div class="myorders-wrapper">

            @foreach($orders as $order)

            <div class="myorder-card">

                <div class="myorder-top">

                    <div>
                        <span class="myorders-label">ORDER NUMBER</span>

                        <h3>
                            #{{ $order->order_number }}
                        </h3>
                    </div>

                    <div class="myorder-status 
                        @if($order->status == 'pending') pending
                        @elseif($order->status == 'paid') paid
                        @elseif($order->status == 'completed') completed
                        @else cancelled
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </div>

                </div>

                <div class="myorder-body">

                    <div class="myorder-info">
                        <span>Total Payment</span>
                        <h4>
                            Rp {{ number_format($order->total,0,',','.') }}
                        </h4>
                    </div>

                    <div class="myorder-info">
                        <span>Payment Method</span>
                        <h4>
                            {{ strtoupper($order->payment_method) }}
                        </h4>
                    </div>

                    <div class="myorder-info">
                        <span>Order Date</span>
                        <h4>
                            {{ $order->created_at->format('d M Y') }}
                        </h4>
                    </div>

                </div>

                <div class="myorder-footer">

                    <a href="{{ route('order.show', $order->id) }}"
                       class="myorder-btn">
                        View Details
                    </a>

                </div>

            </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <i class="fa-solid fa-bag-shopping"
               style="font-size:70px;color:#c9a98f;"></i>

            <h2 class="empty-state-title">
                No Orders Yet
            </h2>

            <p class="empty-state-desc">
                Looks like you haven't placed any order yet.
            </p>

            <a href="{{ route('products.index') }}"
               class="empty-cart-btn">
                Shop Now
            </a>

        </div>

    @endif

</div>

@endsection