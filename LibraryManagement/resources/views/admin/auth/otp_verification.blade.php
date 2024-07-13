<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="WRAPCODERS">
    <title>Vidya Vihar || Library Management || Two Step Verification</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
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
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <main class="auth-creative-wrapper">
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    <div class="row flex-1 g-0">
                        <div class="col-lg-6 h-100 my-auto">
                            <div
                                class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-50 start-50">
                                <img src="assets/images/logo-abbr.png" alt="" class="img-fluid">
                            </div>
                            <div class="creative-card-body card-body p-sm-5">
                                <h4 class="fs-13 fw-bold mb-2">Please enter the OTP to login into your account.</h4>
                                <p class="fs-12 fw-medium text-muted"><span>A code has been sent to</span> <strong>your
                                        mail id</strong></p>
                                <form action="{{ url('verify_otp_success') }}" method="POST"
                                    name="otp_verification_form" id="otp_verification_form" class="w-100 mt-4 pt-2">
                                    @csrf
                                    <input type="number" name="admin_otp" id="admin_otp" class="form-control"
                                        placeholder="Enter OTP"
                                        oninput="if (this.value.length > 6) this.value = this.value.slice(0, 6);"
                                        onkeypress="if (this.value.length >= 6 && event.keyCode !== 8) event.preventDefault();">

                                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                        <input type="hidden" name="email" id="email" value={{ $email }}>
                                        <input type="hidden" name="ip_address" value="{{ \Request::ip() }}" />
                                    </div>

                                    @if (session()->has('errormessage'))
                                        <div class="my-3 alert alert-danger">
                                            {{ session()->get('errormessage') }}
                                        </div>
                                        <?php session()->forget('errormessage'); ?>
                                    @endif

                                    @if (session()->has('successmessage'))
                                        <div class="my-3 alert alert-success">
                                            {{ session()->get('successmessage') }}
                                        </div>
                                        <?php session()->forget('successmessage'); ?>
                                    @endif


                                    @if ($errors->any())
                                        <div class="my-3 alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-lg btn-primary w-100">Validate</button>
                                    </div>
                                    <div class="mt-5 text-muted">
                                        <span>Didn't get the code</span>
                                        <a href="javascript:void(0);">Resend OTP</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 bg-primary">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/auth/auth-user.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            function OTPInput() {
                const inputs = document.querySelectorAll("#otp > *[id]");
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener("keydown", function(event) {
                        if (event.key === "Backspace") {
                            inputs[i].value = "";
                            if (i !== 0) inputs[i - 1].focus();
                        } else {
                            if (i === inputs.length - 1 && inputs[i].value !== "") {
                                return true;
                            } else if (event.keyCode > 47 && event.keyCode < 58) {
                                inputs[i].value = event.key;
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            } else if (event.keyCode > 64 && event.keyCode < 91) {
                                inputs[i].value = String.fromCharCode(event.keyCode);
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            }
                        }
                    });
                }
            }
            OTPInput();
        });
    </script>
</body>


<!-- Mirrored from bestwpware.com/html/tf/duralux-demo/auth-verify-creative.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jul 2024 02:05:15 GMT -->

</html>
