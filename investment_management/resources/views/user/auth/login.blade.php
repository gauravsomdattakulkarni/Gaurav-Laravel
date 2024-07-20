<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User Login</title>
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/investment_manager_logo.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{ asset('assets/images/investment_manager_logo.png') }}" alt="logo">
              </div>
              <h4>Welcome Back User</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" name="user_login_form" id="user_login_form" action="{{ url('user_login_success') }}" method="POST">
              @csrf
                <div class="form-group">
                  <input type="text" name="username" id="username" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" name="password" id="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                </div>
                @if(session()->has('errormessage'))
                    <div class="alert alert-danger">
                        {{ session()->get('errormessage') }}
                    </div>
                    <?php session()->forget('errormessage'); ?>
                @endif

                @if(session()->has('successmessage'))
                    <div class="alert alert-success">
                        {{ session()->get('successmessage') }}
                    </div>
                    <?php session()->forget('successmessage'); ?>
                @endif


                @if($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
                <div class="mt-3">
                  <button type="submit" name="submit_btn_login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >SIGN IN</button>
                </div>
               
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <script src="{{ asset('assets/js/settings.js') }}"></script>
  <script src="{{ asset('assets/js/todolist.js') }}"></script>
</body>

</html>
