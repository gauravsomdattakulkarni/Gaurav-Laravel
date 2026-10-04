@extends('user.layout.app')

@section('title')
    Account Settings
@endsection

@section('body')
@php
  $encryptionModel = new \App\Models\EncryptionModel();
@endphp

<div class="jumbotron" style="margin-top:10px">
  <h1 class="display-4">Account Settings</h1>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Change Password</h5>
          <h6 class="card-subtitle mb-2 text-muted"><code>Change Password Every 3 Months</code></h6>
          <form name="change_password_form" id="change_password_form" method="post" action="{{ url('change_password_success') }}">
            @csrf
            <div class="form-group">
              <label for="exampleInputEmail1">Current Password</label>
              <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Current Password" name="current_password" id="current_password">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">New Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter New Password" name="new_password" id="new_password">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Confirm New Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm New Password" name="confirm_password" id="confirm_password">
            </div>
            @if($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <button type="submit" class="btn btn-primary" id="change_password_btn" name="change_password_btn">Change Password</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Two Step Verification Management</h5>
          <h6 class="card-subtitle mb-2 text-muted"><code>Google Authenticator</code></h6>
          
            <div class="form-group">
              <label for="exampleInputEmail1">Current Status (Two Setp Verification) : </label>
                @if($user_details[0]->two_fa_status=="inactive")
                  <span class="text-danger"><b>Inactive</b></span>
                @else
                <span class="text-success"><b>Active</b></span>
                @endif
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Scan This QR Code Using Google Authenticator</label>
              <div class="mb-3" style="width: 160px; height: 160px;position:relative;">{!! DNS2D::getBarcodeHTML("$qrCodeUrl", 'QRCODE' , 3,3) !!}</div>


            </div>
            <div style="display: flex; justify-content: space-between;">
              <form name="change_two_factor_auth_status" id="change_two_factor_auth_status" method="post" action="{{ url('change_two_factor_status') }}">
                  @csrf
                  <button type="submit" class="btn btn-primary" id="change_two_step_verification_btn" name="change_two_step_verification_btn">Change Auth Status</button>
              </form>
          
              <form name="regenerate_qr_code_form" id="regenerate_qr_code_form" method="post" action="{{ url('regenerate_qr_code') }}">
                  @csrf
                  <button type="button" class="btn btn-danger" id="regenerate_qr_code_btn" name="regenerate_qr_code_btn"  onclick="openconfirmationModal()">Regenerate QR Code</button>
              </form>
          </div>
          

        </div>
      </div>
    </div>

    
  </div>
</div>

<div class="modal" id="two_Step_auth_confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Warning</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
              <p>It Will Generate New QR Code , Old Key In Google Authenticator Wont Work , Want To COntinue ?</p>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger" id="confirmRegenerate" onclick="confirmRegenerate()">Confirm</button>
          </div>
      </div>
  </div>
</div>



<script>
  function openconfirmationModal()
  {
    $("#two_Step_auth_confirmationModal").modal("show");
  }

  function confirmRegenerate()
  {
    $("#regenerate_qr_code_form").submit();
  }

  $(document).ready(function () {
      $('#confirmRegenerate').on('click', function () {
          $('#regenerate_qr_code_form').submit();
      });
  });
</script>
@endsection
