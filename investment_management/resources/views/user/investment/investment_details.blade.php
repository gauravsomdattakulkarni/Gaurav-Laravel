@extends('user.layout.app')

@section('title')
    Investment Details
@endsection

@section('body')
@php
  $encryptionModel = new \App\Models\EncryptionModel();
  $investment_premimum_models = new \App\Models\InvestmentPremimums();
@endphp

<div class="jumbotron" style="margin-top:10px">
  <h1 class="display-4">{{ $encryptionModel->decrypt($investment_details[0]->investment_name); }}</h1>
  <p class="lead text-primary"> <b>AMC : {{ $encryptionModel->decrypt($investment_details[0]->amc_name); }} &nbsp;&nbsp;&nbsp; Account Number : {{ $encryptionModel->decrypt($investment_details[0]->account_number); }}</b></p>
  <button type="button" class="btn btn-primary">
    Total Installmants <span class="badge badge-light">{{ $total_premimum }}</span>
  </button>

  <button type="button" class="btn btn-primary">
    Total Amount Invested <span class="badge badge-light">{{ $total_amount_invested }}</span>
  </button>

</div>

<ul class="nav nav-tabs" role="tablist">

  <li class="nav-item">
    <a href="#premimum_management" role="tab" data-toggle="tab"
       class="nav-link active"> Premimum Management </a>
  </li>

  <li class="nav-item">
    <a href="#document_management" role="tab" data-toggle="tab"
       class="nav-link"> Document Management </a>
  </li>


  <li class="nav-item">
    <a href="#basic_information" role="tab" data-toggle="tab"
       class="nav-link "> More Information </a>
  </li>
  
 
</ul>
<div class="tab-content my-3">
  <div class="tab-pane" role="tabpanel" id="basic_information">
    <div class="table-responsive">
      <table class="table" >
        <thead class="thead-dark">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">AMC</th>
            <th scope="col">A/C No.</th>
            <th scope="col">Frequency</th>
            <th scope="col">Scheme Type</th>
            <th scope="col">Advisior</th>
            <th scope="col">Start Date</th>
            <th scope="col">Amount</th>
            <th scope="col">Installments</th>
            <th scope="col">Total Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->investment_name); }}</td>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->amc_name); }}</td>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->account_number); }}</td>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->premimum_frequency); }}</td>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->scheme_type); }}</td>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->advisior); }}</td>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->start_date); }}</td>
            <td>{{ $encryptionModel->decrypt($investment_details[0]->premimum_amount); }}</td>
            <td>{{ $total_premimum }}</td>
            <td>{{ $total_amount_invested }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="tab-pane active" role="tabpanel" id="premimum_management">
    <form class="my-3" name="premimum_management_form" id="premimum_management_form" action="{{ url('add_investment_premimum') }}" method="post">
      @csrf
      <div class="row">
        <div class="form-group col-md-6">
          <label for="exampleInputEmail1">Premimum Date</label>
          <input type="hidden" class="form-control" id="investment_id" name="investment_id" value={{ $investment_id }} >
          <input type="date" class="form-control" id="premimum_date" name="premimum_date" >
        </div>

        <div class="form-group col-md-6">
          <label for="exampleInputEmail1">Premimum Amount</label>
          <input type="number" min="1" class="form-control" id="premimum_amount" name="premimum_amount">
        </div>

        <div class="form-group col-md-6">
          <label for="exampleInputEmail1">Premimum Mode</label>
          <select class="form-control" name="premimum_mode" id="premimum_mode">
            <option value="Auto payment">Auto payment</option>
            <option value=Online">Online</option>
            <option value=Cash">Cash</option>
          </select> 
        </div>

        <div class="form-group col-md-6">
          <label for="exampleInputEmail1">Description</label>
          <input type="text" min="1" class="form-control" id="description" name="description">
        </div>

        @if($errors->any())
        
        <div class="form-group col-md-12"> 
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
        </div>
        @endif

        <div class="form-group col-md-6"> 
          <button class="btn btn-primary">Add Premimum Details</button>
        </div>
      </div>  
    
    </form>

    <div class="table-responsive">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Premimum Date</th>
            <th scope="col">Amount</th>
            <th scope="col">Payment Mode</th>
            <th scope="col">Description</th>
          </tr>
        </thead>
        <tbody>
          @php
            $total_amount_invested = 0;
          @endphp
          
          @foreach($investment_premimum_details as $premimum_deatils)
            @php
              $total_amount_invested = $total_amount_invested +  $encryptionModel->decrypt($premimum_deatils->amount);
            @endphp
            <tr>
              <td>{{  $premimum_deatils->premimum_date}}</td>
              <td>{{ $encryptionModel->decrypt($premimum_deatils->amount); }}</td>
              <td>{{ $encryptionModel->decrypt($premimum_deatils->payment_mode); }}</td>
              <td>{{ $encryptionModel->decrypt($premimum_deatils->description); }}</td>
            </tr>

           
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <td colspan="4">
              {{ $investment_premimum_details->links() }}
            </td>
          </tr>
        </tfoot>
        
      </table>
    </div>
  </div>

  <div class="tab-pane" role="tabpanel" id="document_management">
    <form class="my-3" name="investment_document_form" id="investment_document_form" enctype='multipart/form-data' action="{{ url('add_investment_document') }}" method="post">
      @csrf
      <div class="row">
        <div class="form-group col-md-6">
          <label for="exampleInputEmail1">Document Name</label>
          <input type="hidden" class="form-control" id="investment_id" name="investment_id" value={{ $investment_id }} >
          <input type="text" class="form-control" id="document_name" name="document_name" >
        </div>

        <div class="form-group col-md-6">
          <label for="exampleInputEmail1">Document</label>
          <input type="file"  class="form-control" id="investment_document" name="investment_document">
        </div>


        @if($errors->any())
        
        <div class="form-group col-md-12"> 
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
        </div>
        @endif

        <div class="form-group col-md-6"> 
          <button class="btn btn-primary">Add Investment Document</button>
        </div>
      </div>  
    
    </form>

    <div class="table-responsive">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Document Name</th>
            <th scope="col">Document</th>
          </tr>
        </thead>
        <tbody>
          @foreach($investment_documents as $docs)
            <tr>
              <td>{{ $docs->document_name }}</td>
              <td>
                @if($docs->document_type=="jpg" || $docs->document_type=="png" || $docs->document_type=="jpeg")
                  <img src="{{ $docs->document }}" style="height:50px;width:50px;"> &nbsp;&nbsp;<a href="{{ $docs->document }}" download><i class="fa fa-download" aria-hidden="true"></i></a>
                @else 
                <i class="fa fa-file-pdf-o" style="height:50px;width:50px;font-size:40px" aria-hidden="true"></i> &nbsp;&nbsp;<a href="{{ $docs->document }}" download><i class="fa fa-download" aria-hidden="true"></i></a>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
        
      </table>
      
    </div>
  </div>
  
</div>
@endsection
