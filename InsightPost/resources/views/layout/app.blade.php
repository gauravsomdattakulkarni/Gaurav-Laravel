<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Insight Post - @yield('title') </title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/f673114734.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <style>
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow-x: hidden; /* Optional: Hide horizontal scrollbar */
    }
    .body_container {
        /* Add some content here */
        height: calc(100vh - 60px); /* Adjust according to your footer's height */
        overflow-y: auto; /* Enable vertical scrollbar if content exceeds viewport height */
        padding-bottom: 60px; /* Adjust according to your footer's height */
    }
    
    </style>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home', ['page_no' =>  1]) }}">InsightPost</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/home', ['page_no' =>  1]) }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('create_post') }}">Post</a></li>
                        @if($login_status=="logged_in")
                            <li class="nav-item"><a class="nav-link" href="{{ url('my_post') }}">My post</a></li>    
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ url('author_logout') }}">Logout</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ url('author_login') }}">Login</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        
        
        <div class="container-fluid body_container">
           @yield('body')
        </div>
        
        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">{{ session('success_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                {{ session('success_message') }}
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">{{ session('error_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="text-danger">{{ session('error_message') }}</div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>

  
        <footer class="py-3 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; InsightPost <?php echo date("Y");?></p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script>
            window.onload = function() {
                @if(session('success_message') && session('success_title'))
                    // Show success modal
                    $('#successModal').modal('show');
                @elseif(session('error_message') && session('error_title'))
                    // Show error modal
                    $('#errorModal').modal('show');
                @endif
            };
        </script>
        
    </body>
</html>
