@extends("user.layout.app")

@section("title")
    Edit Investment
@endsection

@section("body")
<div class="row">
    <div class="col-md-12">
        <div class="card bg-primary page-top-header">
            <div class="card-body">
              <h5 style="color:white" class="page-top_header-title">Edit Investment</h5>
            </div>
          </div>
    </div>
    @php
        $encryptionModel = new \App\Models\EncryptionModel();
    @endphp

    <div class="col-md-12">
        <div class="card mx-auto" style="width:90%;">
            <div class="card-body">
                <form name="edit_investment_form" id="edit_investment_form" action="{{ url("update_investment_details_success") }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="investment_plan_name">Investment Plan Name</label>
                            <input type="hidden" name="investment_id" id="investment_id" value="{{ $investment_id }}">
                            <input type="text" class="form-control" id="investment_plan_name" name="investment_plan_name" value="{{ old('investment_plan_name', $encryptionModel->decrypt($investment_details[0]->investment_name)) }}" placeholder="Enter Investment Plan Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amc_name">AMC Name</label>
                            <input type="text" class="form-control" id="amc_name" name="amc_name" value="{{ old('amc_name', $encryptionModel->decrypt($investment_details[0]->amc_name)) }}" placeholder="Enter AMC Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="account_number">Account Number</label>
                            <input type="number" min="0" class="form-control" id="account_number" name="account_number" value="{{ old('account_number', $encryptionModel->decrypt($investment_details[0]->account_number)) }}" placeholder="Enter Account Number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="premimum_frequency">Premimum Frequency</label>
                            <select class="form-control" id="premimum_frequency" name="premimum_frequency">
                                <option value="monthly" {{ old('premimum_frequency', $investment_details[0]->premimum_frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <!-- Add similar options for other frequencies -->
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="scheme_type">Scheme Type</label>
                            <input type="text" class="form-control" id="scheme_type" name="scheme_type" value="{{ old('scheme_type', $encryptionModel->decrypt($investment_details[0]->scheme_type)) }}" placeholder="Enter Scheme Type">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="advisior">Advisior</label>
                            <input type="text" class="form-control" id="advisior" name="advisior" value="{{ old('advisior', $encryptionModel->decrypt($investment_details[0]->advisior)) }}" placeholder="Enter Advisior Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($encryptionModel->decrypt($investment_details[0]->start_date))->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="premimum_amount">Premimum Amount</label>
                            <input type="text" min="100" class="form-control" id="premimum_amount" name="premimum_amount" value="{{ old('premimum_amount', $encryptionModel->decrypt($investment_details[0]->premimum_amount)) }}" placeholder="Enter Premimum Amount">
                        </div>
                        
                        <div class="form-group col-md-6">
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                       
                    </div>
                    <button type="submit" class="btn btn-primary">Edit Investment Details</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
