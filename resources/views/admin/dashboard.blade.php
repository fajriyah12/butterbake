@extends('layouts.app')

@section('content')

<div class="admin-main">

    <div class="topbar">
        <h2>Welcome back, Admin</h2>
        <p>Here's what's baking in your shop today.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h4>Total Sales</h4>
            <h3>Rp 12.450.000</h3>
        </div>
        <div class="stat-card">
            <h4>Total Orders</h4>
            <h3>142</h3>
        </div>
        <div class="stat-card">
            <h4>Customers</h4>
            <h3>86</h3>
        </div>
        <div class="stat-card">
            <h4>Avg Order</h4>
            <h3>Rp 87.500</h3>
        </div>
    </div>

</div>

@endsection