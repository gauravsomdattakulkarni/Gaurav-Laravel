
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="WRAPCODERS">
    <title>Programming Master || Admin Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/theme.min.css')}}">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f673114734.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/investment_manager_logo.png') }}" />

    <!--! END: Custom CSS-->
    <!--! HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries !-->
    <!--! WARNING: Respond.js doesn"t work if you view the page via file: !-->
    <!--[if lt IE 9]>
			<script src="https:oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https:oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>
    <main class="auth-creative-wrapper">
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    <div class="row flex-1 g-0">
                        <div class="col-lg-6 h-100 my-auto order-1 order-lg-0">

                            <div class="creative-card-body card-body p-sm-5">
                                <h2 class="fs-20 fw-bolder mb-4">Welcome back admin</h2>
                                <h4 class="fs-13 fw-bold mb-2">Let's login to your account</h4>
                                <form name="admin_login_form" id="admin_login_form" action="{{url('login_admin_success')}}" method="POST" class="w-100 mt-4 pt-2">
                                @csrf
                                    <div class="mb-4">
                                        <input type="email" name="email"  id="email" class="form-control" placeholder="Enter Email" value="">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password"name="password" id="password" class="form-control" placeholder="Enter Password">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <a href="auth-reset-creative.html" class="fs-11 text-primary">Forget password?</a>
                                        </div>
                                    </div>
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

                                    <div class="mt-5">
                                        <button type="submit" id="login_admin_btn" name="login_admin_btn" class="btn btn-lg btn-primary w-100">Login</button>
                                    </div>
                                </form>

                                <div class="mt-5 text-muted">
                                    <span> Don't have an account?</span>
                                    <a href="auth-register-creative.html" class="fw-bold">Create an Account</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 bg-primary order-0 order-lg-1">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="assets/images/auth/auth-user.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="successmessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errortitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="errortitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="errormessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {

        var errortitle = "{{ session('errortitle') }}";
        var errormessage = "{{ session('errormessage') }}";

        if (errortitle && errormessage) {
            $('#errortitle').text(errortitle);
            $('#errormessage').text(errormessage);
            $('#errorModal').modal('show');
        }

        var successtitle = "{{ session('successtitle') }}";
        var successmessage = "{{ session('successmessage') }}";

        if (successtitle && successmessage) {
            $('#successModalLabel').text(successtitle);
            $('#successmessage').text(successmessage);
            $('#successModal').modal('show');
        }
    };

    </script>

    <script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('assets/js/common-init.min.js')}}"></script>
    <script src="{{asset('assets/js/theme-customizer-init.min.js')}}"></script>

</body>

</html>
