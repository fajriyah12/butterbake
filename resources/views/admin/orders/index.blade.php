@extends('layouts.app')

@section('content')

<div class="admin-main">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="inventory-header">
            <div>
                <h1>Orders</h1>
                <p class="inventory-subtitle">Manage customer cake order</p>
            </div>
        </div>
    </div>


    <!-- TABLE -->
    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($orders as $order)

                <tr>

                    <td>
                        {{ $order->order_number }}
                        <br>
                        <small style="color:#999;">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </small>
                    </td>

                    <td>
                        <strong>{{ $order->user->name }}</strong>
                        <br>
                        <small style="color:#999;">
                            {{ $order->user->email }}
                        </small>
                    </td>

                    <td>
                        Rp {{ number_format($order->total,0,',','.') }}
                    </td>

                    <td>

                        <span class="
                            @if($order->status == 'pending')
                                badge-pending
                            @elseif($order->status == 'processing')
                                badge-processing
                            @elseif($order->status == 'ready')
                                badge-ready
                            @elseif($order->status == 'completed')
                                badge-completed
                            @elseif($order->status == 'cancelled')
                                badge-cancelled
                            @endif
                        ">
                            {{ $order->status_label }}
                        </span>

                    </td>

                    <td>
                        {{ ucfirst($order->payment_status) }}
                    </td>

                    <td style="display:flex; gap:8px;">

                        <!-- VIEW DETAIL -->
                        <a href="{{ route('admin.orders.show',$order) }}"
                            class="page-btn">
                            <i class="bi bi-eye"></i>
                        </a>

                        <!-- UPDATE STATUS -->
                        @if($order->status !== 'completed')

                        <form method="POST"
                            action="{{ route('admin.orders.update',$order) }}">

                            @csrf
                            @method('PATCH')

                    
                        </form>

                        @else
                            <span style="color:green;font-weight:600;">
                                Done
                            </span>
                        @endif

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" style="text-align:center;padding:30px;">
                        No orders found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div style="margin-top:20px;">
        {{ $orders->links() }}
    </div>

</div>

@endsection