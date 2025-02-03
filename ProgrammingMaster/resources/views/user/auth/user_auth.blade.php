<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="WRAPCODERS">
    <title>Programming Master || User Registration & Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/theme.min.css')}}">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f673114734.js" crossorigin="anonymous"></script>
</head>

<body>
    <main class="auth-creative-wrapper">
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    <div class="row flex-1 g-0">
                        <!-- Left Side Image -->
                        <div class="col-lg-6 bg-primary order-0 order-lg-1">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="assets/images/auth/auth-user.png" alt="" class="img-fluid">
                            </div>
                        </div>

                        <!-- Right Side Form -->
                        <div class="col-lg-6 h-100 my-auto order-1 order-lg-0">
                            <div class="creative-card-body card-body p-sm-5">
                                <h2 class="fs-20 fw-bolder mb-4">Welcome User</h2>
                                <h4 class="fs-13 fw-bold mb-2">Sign Up or Login to Your Account</h4>

                                <!-- Tabs for Registration/Login -->
                                <ul class="nav nav-tabs" id="authTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="false">Login</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="true">Register</button>
                                    </li>

                                </ul>
                                <div class="tab-content mt-4" id="authTabsContent">
                                    <!-- Registration Form -->
                                    <div class="tab-pane fade " id="register" role="tabpanel" aria-labelledby="register-tab">
                                        <form name="user_registration_form" id="user_registration_form" action="{{url('register')}}" method="POST" class="w-100">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="country" id="country" class="form-control" placeholder="country">
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" id="register_user_btn" name="register_user_btn" class="btn btn-lg btn-primary w-100">Register</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Login Form -->
                                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                        <form name="user_login_form" id="user_login_form" action="{{url('login')}}" method="POST" class="w-100">
                                            @csrf
                                            <div class="mb-4">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <a href="auth-reset-creative.html" class="fs-11 text-primary">Forgot password?</a>
                                                </div>
                                            </div>


                                            <div class="mt-5">
                                                <button type="submit" id="login_user_btn" name="login_user_btn" class="btn btn-lg btn-primary w-100">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-5 text-muted">
                                    @if(session()->has('errormessage'))
                                    <div class="my-3 alert alert-danger">
                                        {{ session()->get('errormessage') }}
                                    </div>
                                    <?php session()->forget('errormessage'); ?>
                                @endif

                                @if(session()->has('successmessage'))
                                    <div class="my-3 alert alert-success">
                                        {{ session()->get('successmessage') }}
                                    </div>
                                    <?php session()->forget('successmessage'); ?>
                                @endif

                                @if($errors->any())
                                    <div class="my-3 alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                    <span> Need help?</span>
                                    <a href="#" class="fw-bold">Contact Support</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('assets/js/common-init.min.js')}}"></script>
    <script src="{{asset('assets/js/theme-customizer-init.min.js')}}"></script>
</body>

</html>
