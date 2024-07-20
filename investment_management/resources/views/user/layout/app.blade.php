<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script src="https://kit.fontawesome.com/f673114734.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/investment_manager_logo.png') }}" />

    {{-- Datatable Assets --}}

    <style>
        /* Add this custom CSS to your existing styles or in a separate style tag/file */
.dataTables_wrapper .top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dataTables_wrapper .top .dataTables_filter {
    order: 2;
    margin-left: 10px;
    margin-bottom: 10px;
}

.dataTables_wrapper .top .dataTables_length {
    order: 1;
    margin-right: 10px;
    margin-bottom: 10px;
}

.dt-buttons
{
    margin-left:840px;
}
.paginate_button
{
    background-color: #007bff;
    color:white;
    margin-left:5px;
    margin-right:5px;
    padding:8px;
}
.dataTables_paginate
{
    margin-top:20px;
}

a:not([href])
{
    background-color: #007bff;
    color:white;
    margin:5px;
}

</style>
    <title>@yield('title')</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('user_dashboard') }}">
            <img src="{{ asset('assets/images/investment_manager_logo.png') }}" style="height:40px;width:40px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active" style="color:white">
                    <a class="nav-link" href="{{ url('user_dashboard') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white">
                        Investment Management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('manage_investment') }}">Manage Investment</a>
                        <a class="dropdown-item" href="{{ url('add_investment') }}">Add Investment</a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
    
                <!-- Profile Option with ml-auto for right alignment -->
                
            </ul>

            <div class="dropdown" style="margin-right:1%">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Account Settings
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('account_settings') }}">Settings</a>
                    <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
                </div>
              </div>
        </div>
    </nav>
    

  <div class="container-fluid">

    <div class="row">
        <div class="col-md-12"> 
            @yield('body')
        </div>
    </div>
   
    

  </div>
  
  <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warningModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="warningMessage"></p>
            </div>
            <div class="modal-footer">
              <form name="delete_modal_form" id="delete_modal_form" method="POST">
                @csrf
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="hidden" name="element_id" id="element_id" value="">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>

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

<!-- Error Modal -->
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<!-- DataTables JavaScript -->
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JavaScript -->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function () {
            $('#example23').DataTable({
                dom: 'Bfrtip',
                dom: '<"top"iBf>rt<"bottom"lp><"clear">', 
                buttons: [
                    { extend: 'copy', className: 'btn-primary' },
                    { extend: 'csv', className: 'btn-primary' },
                    { extend: 'excel', className: 'btn-primary' },
                    { extend: 'pdf', className: 'btn-primary' },
                    { extend: 'print', className: 'btn-primary' }
                ],
                initComplete: function () {
                    // Add custom styles for the export buttons
                    $('.btn-primary').css('color', '#ffffff'); // Adjust the color as needed
                    $('.btn-primary').css('background-color', '#007bff'); // Adjust the background color as needed
                },
                
            });
        });

  function DeleteConfirmation(title,message,action,element_id)
  {
    $("#warningModalLabel").text(title);
    $("#warningMessage").text(message);
    $("#delete_modal_form").attr("action",action);
    $("#element_id").val(element_id);
    $("#warningModal").modal("show");
  }

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


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous">
    </script>
    <script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
    crossorigin="anonymous">
    </script>
    
    
</body>

</html>
