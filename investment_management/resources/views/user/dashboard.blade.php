@extends('user.layout.app')

@section('title')
    User Dashboard
@endsection

@section('body')
<div class="row my-3">
    <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
    <div class="card-header card-header-warning card-header-icon">
    <div class="card-icon">
    <i class="material-icons">Current Investements</i>
    </div>
    <p class="card-category">(Total Investments)</p>
    <h3 class="card-title">{{ $total_investments }}
    <small></small>
    </h3>
    </div>
    <div class="card-footer">
    <div class="stats">
    <i class="material-icons text-danger">manage</i>
    <a href="{{ url('manage_investment') }}">Investments</a>
    </div>
    </div>
    </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
    <div class="card-header card-header-success card-header-icon">
    <div class="card-icon">
    <i class="material-icons">Investment</i>
    </div>
    <p class="card-category">Total Investments Paid</p>
    <h3 class="card-title">{{ $total_installents_paid }}</h3>
    </div>
    <div class="card-footer">
    <div class="stats">
    <i class="material-icons">Accross</i> All Schemes
    </div>
    </div>
    </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
    <div class="card-header card-header-danger card-header-icon">
    <div class="card-icon">
    <i class="material-icons">Investment</i>
    </div>
    <p class="card-category">Total Invested Amount</p>
    <h3 class="card-title">RS. {{ $total_installents_amount_paid }}</h3>
    </div>
    <div class="card-footer">
    <div class="stats">
    <i class="material-icons">Across </i> All Schemes
    </div>
    </div>
    </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
    <div class="card-header card-header-info card-header-icon">
    <div class="card-icon">
    <i class="fa fa-book"></i>
    </div>
    <p class="card-category">Documents Uploaded</p>
    <h3 class="card-title">{{ $total_uploaded_documents }}</h3>
    </div>
    <div class="card-footer">
    <div class="stats">
    <i class="material-icons">Across</i> All Investment Schemes
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection