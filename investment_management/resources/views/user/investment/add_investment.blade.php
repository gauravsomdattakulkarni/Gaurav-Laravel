@extends("user.layout.app")

@section("title")
    Manage Investment
@endsection

@section("body")
<div class="row" >
    <div class="col-md-12">
        <div class="card bg-primary page-top-header">
            <div class="card-body">
              <h5 style="color:white" class="page-top_header-title">Add New Investment</h5>
            </div>
          </div>
    </div>

    <div class="col-md-12">
        <div class="card mx-auto" style="width:90%;">
            <div class="card-body">
                <form name="add_investment_form" id="add_investment_form" action="{{ url("add_investment_success") }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Investment Plan Name</label>
                            <input type="text" class="form-control" id="investment_plan_name" name="investment_plan_name"  value="{{ old('investment_plan_name') }}" placeholder="Enter Investment Plan Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">AMC Name</label>
                            <input type="text" class="form-control" id="amc_name" name="amc_name" placeholder="Enter AMC Name" value="{{ old('amc_name') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Account Number</label>
                            <input type="number" min="0" class="form-control" id="account_number" name="account_number" placeholder="Enter Account Number" value="{{ old('account_number') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Premimum Frequency</label>
                            <select class="form-control" id="premimum_frequency" name="premimum_frequency">
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="half_yearly">Half Yearly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Scheme Type</label>
                            <input type="text" class="form-control" id="scheme_type" name="scheme_type" value="{{ old('scheme_type') }}" placeholder="Enter Scheme Type">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Advisior</label>
                            <input type="text" class="form-control" id="advisior" name="advisior" value="{{ old('advisior') }}" placeholder="Enter Advisior Name">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Premimum Amount</label>
                            <input type="number" min="100" class="form-control" id="premimum_amount" name="premimum_amount" value="{{ old('premimum_amount') }}" placeholder="Enter Premimum Amount">
                        </div>

                        <div class="form-group col-md-12">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        
                    <div> 
                       
                </form>
                
            </div>

            
        </div>
        
    </div>
</div>


@endsection
