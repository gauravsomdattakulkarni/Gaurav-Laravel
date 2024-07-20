@extends("user.layout.app")

@section("title")
    Manage Investment
@endsection

@section("body")

@php
  $encryptionModel = new \App\Models\EncryptionModel();
  $investment_premimum_models = new \App\Models\InvestmentPremimums();
@endphp

<div class="jumbotron" style="margin-top:10px">
  <h1 class="display-4">Investment Management</h1>
  <br>
  <button class="btn btn-primary">Total Investments : {{ $total_investments }}</button>
</div>


<div class="row" >
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="investment_management" style="margin-bottom:30px">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">AMC</th>
                    <th scope="col">A/C No.</th>
                    <th scope="col">Frequency</th>
                    <th scope="col">Type</th> 
                    <th scope="col">Advisior</th>
                    <th scope="col">Start</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Invested Amount</th>
                    <th scope="col">Action</th>    
                  </tr>
                </thead>
                <tbody>
                @php
                    $i =1;
                @endphp
                @foreach($investment_details as $inv_details)
                <tr>
                  <th scope="row">{{ $i }}</th>
                  <td>{{ $inv_details->investment_id }}</td>
                  
                  <!-- Decrypting the Investment Name -->
                  <td>
                      @php
                          $encryptionModel = new \App\Models\EncryptionModel();
                          $decrypted_details = $encryptionModel->decrypt($inv_details->investment_name);
                      @endphp
                      {{ $decrypted_details }}
                  </td>
              
                  <!-- Decrypting the AMC Name -->
                  <td>
                      @php
                          $decrypted_details = $encryptionModel->decrypt($inv_details->amc_name);
                      @endphp
                      {{ $decrypted_details }}
                  </td>
              
                  <!-- Decrypting the Account Number -->
                  <td>
                      @php
                          $decrypted_details = $encryptionModel->decrypt($inv_details->account_number);
                      @endphp
                      {{ $decrypted_details }}
                  </td>
              
                  <!-- Decrypting the Premium Frequency -->
                  <td>
                      @php
                          $decrypted_details = $encryptionModel->decrypt($inv_details->premimum_frequency);
                      @endphp
                      {{ $decrypted_details }}
                  </td>
              
                  <!-- Decrypting the Scheme Type -->
                  <td>
                      @php
                          $decrypted_details = $encryptionModel->decrypt($inv_details->scheme_type);
                      @endphp
                      {{ $decrypted_details }}
                  </td>
              
                  <!-- Decrypting the Advisior -->
                  <td>
                      @php
                          $decrypted_details = $encryptionModel->decrypt($inv_details->advisior);
                      @endphp
                      {{ $decrypted_details }}
                  </td>
              
                  <!-- Decrypting the Start Date -->
                  <td>
                      @php
                          $decrypted_details = $encryptionModel->decrypt($inv_details->start_date);
                      @endphp
                      {{ $decrypted_details }}
                  </td>
              
                  <!-- Decrypting the Premium Amount -->
                  <td>
                      @php
                          $decrypted_details = $encryptionModel->decrypt($inv_details->premimum_amount);
                      @endphp
                      {{ $decrypted_details }}
                  </td>

                  <td>
                        @php
                            $investment_id = $inv_details->investment_id;

                            $paid_premimums = $investment_premimum_models::where('investment_id','=',$investment_id)->get();
                            $paid_premimum_amount = 0;
                            foreach($paid_premimums  as $premimums)
                            {
                                $paid_premimum_amount += $encryptionModel->decrypt($premimums->amount);
                            }
                        @endphp
                        {{ $paid_premimum_amount }}
                    </td>
              
                  <td>
                        <a href="#" onclick="DeleteConfirmation('Delete Investment','Do You Really Want To Delete The Investment','delete_investment_success', '<?php echo $inv_details->id?>')">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>

                        <a href='{{ url("edit_investment/$inv_details->investment_id") }}'>
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href='{{ url("get_investment_more_details/$inv_details->investment_id") }}'>
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </a>
                  </td>
              </tr>
              
              
                @php
                    $i = $i + 1;
                @endphp
                @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="12">
                            {{ $investment_details->links() }}
                        </td>
                    </tr>
                    
                  </tfoot>
              </table>
        </div>
    </div>
</div>


@endsection
