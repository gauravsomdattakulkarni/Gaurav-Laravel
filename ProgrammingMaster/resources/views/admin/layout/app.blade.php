<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="WRAPCODERS" />
    <title>Programming Master|| @yield("title")</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/vendors.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/daterangepicker.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/theme.min.css')}}" />


    <!--[if lt IE 9]>
			<script src="https:oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https:oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>
    <nav class="nxl-navigation">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="index.html" class="b-brand">
                    <img src="assets/images/logo-full.png" alt="" class="logo logo-lg" />
                    <img src="assets/images/logo-abbr.png" alt="" class="logo logo-sm" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="nxl-navbar">
                    <li class="nxl-item nxl-caption">
                        <label>Navigation</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{url('dashboard')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Dashboard</span><span class="nxl-arrow"></span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-book"></i></span>
                            <span class="nxl-mtext">Quiz</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{url('quiz-categories')}}">Manage Quiz Category</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{url('manage_quiz')}}">All Quiz</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{url('add_quiz')}}">Add Quiz</a></li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </nav>

    <header class="nxl-header">
        <div class="header-wrapper">
            <div class="header-left d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>

                <div class="nxl-navigation-toggle">
                    <a href="javascript:void(0);" id="menu-mini-button">
                        <i class="feather-align-left"></i>
                    </a>
                    <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                        <i class="feather-arrow-right"></i>
                    </a>
                </div>

            </div>
            <!--! [End] Header Left !-->
            <!--! [Start] Header Right !-->
            <div class="header-right ms-auto">
                <div class="d-flex align-items-center">


                    <div class="nxl-h-item d-none d-sm-flex">
                        <div class="full-screen-switcher">
                            <a href="javascript:void(0);" class="nxl-head-link me-0" onclick="$('body').fullScreenHelper('toggle');">
                                <i class="feather-maximize maximize"></i>
                                <i class="feather-minimize minimize"></i>
                            </a>
                        </div>
                    </div>
                    <div class="nxl-h-item dark-light-theme">
                        <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button">
                            <i class="feather-moon"></i>
                        </a>
                        <a href="javascript:void(0);" class="nxl-head-link me-0 light-button" style="display: none">
                            <i class="feather-sun"></i>
                        </a>
                    </div>

                    <div class="dropdown nxl-h-item">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                            <img src="assets/images/avatar/1.png" alt="user-image" class="img-fluid user-avtar me-0" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/avatar/1.png" alt="user-image" class="img-fluid user-avtar" />
                                    <div>
                                        <h6 class="text-dark mb-0">Alexandra Della <span class="badge bg-soft-success text-success ms-1">PRO</span></h6>
                                        <span class="fs-12 fw-medium text-muted"><a href="https://bestwpware.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="71101d14095f15141d1d10311e04051d1e1e1a5f121e1c">[email&#160;protected]</a></span>
                                    </div>
                                </div>
                            </div>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="feather-user"></i>
                                <span>Profile Details</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="feather-settings"></i>
                                <span>Account Settings</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="auth-login-minimal.html" class="dropdown-item">
                                <i class="feather-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/dashboard")}}">Dashboard</a></li>
                        <li class="breadcrumb-item">@yield('page_header')</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>

                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>

                @yield("body")

            </div>

        </main>

    <footer class="footer">
        <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
            <span>Copyright ©</span>
            <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
                document.write(new Date().getFullYear());
            </script>
        </p>
        <div class="d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
        </div>
    </footer>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel"></h5>
                <button type="button" class="close-btn btn btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="successmessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="close-btn btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errortitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="errortitle"></h5>
                <button type="button" class="close-btn btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <b><span aria-hidden="true">&times;</span></b>
                </button>
            </div>
            <div class="modal-body">
                <p id="errormessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="close-btn btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_quiz_confirmation_model" tabindex="-1" role="dialog" aria-labelledby="errortitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="errortitle">Warning!</h5>
                <button type="button" class="close-btn close btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="errormessage">Do you really want to delete Quiz : <b><span id="quiz_title"></span> </b>?</p>
                <p class="text-danger"><b>You will not be able to recover it again!</b></p>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="close-btn btn btn-secondary" data-dismiss="modal">Close</button>
                <form name="quiz_delete_form" id="quiz_delete_form" method="POST" action="{{ url('delete_quiz_success') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="quiz_id_delete" id="quiz_id_delete">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_question_confirmation_model" tabindex="-1" role="dialog" aria-labelledby="errortitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="errortitle">Warning!</h5>
                <button type="button" class="close-btn close btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="errormessage">Do you really want to delete Question : <b><span id="question_title"></span> </b>?</p>
                <p class="text-danger"><b>You will not be able to recover it again!</b></p>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="close-btn btn btn-secondary" data-dismiss="modal">Close</button>
                <form name="question_delete_form" id="question_delete_form" method="POST" action="{{ url('delete_quetion_success') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="question_id_delete" id="question_id_delete">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

 <!-- Add Category Modal -->
 <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
 aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <form action="{{ url('add_quiz_category') }}" method="POST">
             @csrf
             <div class="modal-header">
                 <h5 class="modal-title" id="addCategoryModalLabel">Add Quiz Category</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="mb-3">
                     <label for="categoryName" class="form-label">Category Name</label>
                     <input type="text" class="form-control" id="categoryName" name="category_name" required>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary">Add Category</button>
             </div>
         </form>
     </div>
 </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
 aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <form id="editCategoryForm" method="POST">
             @csrf
             @method('PUT')
             <div class="modal-header">
                 <h5 class="modal-title" id="editCategoryModalLabel">Edit Quiz Category</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="mb-3">
                     <label for="editCategoryName" class="form-label">Category Name</label>
                     <input type="text" class="form-control" id="editCategoryName" name="category_name" required>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary">Update Category</button>
             </div>
         </form>
     </div>
 </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
 aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <form id="deleteCategoryForm" method="POST">
             @csrf
             @method('DELETE')
             <div class="modal-header">
                 <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Quiz Category</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <p>Are you sure you want to delete the category <strong id="deleteCategoryName"></strong>?</p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                 <button type="submit" class="btn btn-danger">Delete</button>
             </div>
         </form>
     </div>
 </div>
</div>


    <script>
        $(".close-btn").click(function(){
            $('#errorModal').modal('hide');
            $('#successModal').modal('hide');
            $("#delete_book_confirmation_model").modal("hide");
        });

        window.onload = function () {
        var errortitle = "{{ session('errortitle') }}";
        var errormessage = "{{ session('errormessage') }}";

        if (errortitle && errormessage) {
            $('#errortitle').text(errortitle);
            $('#errormessage').text(errormessage);
            $('#errorModal').modal('show');
        }

        // Check for success message in session
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
    <script src="{{asset('assets/vendors/js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/circle-progress.min.js')}}"></script>
    <script src="{{asset('assets/js/common-init.min.js')}}"></script>
    <script src="{{asset('assets/js/dashboard-init.min.js')}}"></script>
    <script src="{{asset('assets/js/theme-customizer-init.min.js')}}"></script>
    <script src="{{asset('assets/js/widgets-tables-init.min.js')}}"></script>
</body>
</html>
