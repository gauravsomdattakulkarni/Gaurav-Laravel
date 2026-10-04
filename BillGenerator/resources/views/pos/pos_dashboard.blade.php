@extends('pos.layouts.app')

@section('title', 'POS Dashboard')

@section('page_title', 'Dashboard')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-1">Welcome, {{ session('pos_name') }}</h3>
    <p class="text-muted mb-0">Here is your POS dashboard overview.</p>
</div>

<div class="row g-4">

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2">Today's Sales</p>
                        <h3 class="fw-bold mb-0">₹0.00</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-currency-rupee fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2">Today's Orders</p>
                        <h3 class="fw-bold mb-0">0</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2">Products</p>
                        <h3 class="fw-bold mb-0">0</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2">POS Username</p>
                        <h5 class="fw-bold mb-0">{{ session('pos_username') }}</h5>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded p-3">
                        <i class="bi bi-person-badge fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4 mt-1">

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Recent Sales</h5>
            </div>

            <div class="card-body">
                <div class="text-center py-5">
                    <i class="bi bi-receipt fs-1 text-muted"></i>
                    <h5 class="mt-3">No sales found</h5>
                    <p class="text-muted mb-0">Your recent sales will appear here.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">POS Information</h5>
            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">POS ID</span>
                    <strong>{{ session('pos_id') }}</strong>
                </div>

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">Name</span>
                    <strong>{{ session('pos_name') }}</strong>
                </div>

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">Username</span>
                    <strong>{{ session('pos_username') }}</strong>
                </div>

                <div class="d-flex justify-content-between py-3">
                    <span class="text-muted">Last Login</span>
                    <strong>
                        {{ session('pos_last_login_date_time') ? \Carbon\Carbon::parse(session('pos_last_login_date_time'))->format('d M Y, h:i A') : '-' }}
                    </strong>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection