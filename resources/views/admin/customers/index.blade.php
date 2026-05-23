@extends('layouts.app')

@section('content')
<div class="admin-main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="inventory-header">
            <div>
                <h1>Customers</h1>
                <p class="inventory-subtitle">
                    Manage your bakery members and their order history
                </p>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Join Date</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td style="font-weight:600;">
                            {{ $customer->name }}
                        </td>

                        <td style="color:#9a8880;">
                            {{ $customer->email }}
                        </td>

                        <td style="color:#9a8880;">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>

                         <td style="font-weight:600;">
                            {{ $customer->orders_count }}
                        </td>

                        <td style="font-weight:700;color:#b46f28;">
                            Rp {{ number_format($customer->orders_sum_total ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            @if($customer->orders_count > 0)
                                <span class="status status-completed">Active</span>
                            @else
                                <span class="status"
                                      style="background:#f0ece8;color:#9a8880;">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.customers.show', $customer->id) }}"style="color:#8B5E3C; text-decoration:none;">
                                View Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7"
                            style="text-align:center;color:#b5a89f;padding:40px;">
                            No customers found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="pagination-bar">

        <span class="pagination-info">
            Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }}
            of {{ $customers->total() }} customers
        </span>

        <div class="pagination-links">

            {{-- Prev --}}
            @if($customers->onFirstPage())
                <span class="page-btn disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $customers->previousPageUrl() }}"
                   class="page-btn">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Pages --}}
            @foreach(range(1, $customers->lastPage()) as $page)
                <a href="{{ $customers->url($page) }}"
                   class="page-btn {{ $customers->currentPage() == $page ? 'active' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            {{-- Next --}}
            @if($customers->hasMorePages())
                <a href="{{ $customers->nextPageUrl() }}"
                   class="page-btn">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="page-btn disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif

        </div>
    </div>

</div>
@endsection