<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Arial', sans-serif;
        }
        .verification-container {
            max-width: 600px;
            margin: auto;
        }
        .card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .card-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 1.5rem;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }
        .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .card-body {
            padding: 2rem;
        }
        .card-body .alert {
            margin-bottom: 1.5rem;
        }
        .badge-status {
            font-size: 0.9rem;
            margin-top: 1rem;
        }
        .btn-home {
            border-radius: 30px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
        }
        .card-footer {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-top: 1px solid #dee2e6;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="verification-container">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Account Verification</h4>
                </div>
                <div class="card-body text-center">
                    @if ($status === 'success')
                        <div class="alert alert-success" role="alert">
                            <h5 class="alert-heading">Success</h5>
                            <p>{{ $message }}</p>
                        </div>
                        <div class="badge bg-success badge-status">Account Status: Verified</div>
                    @elseif ($status === 'error')
                        <div class="alert alert-danger" role="alert">
                            <h5 class="alert-heading">Error</h5>
                            <p>{{ $message }}</p>
                        </div>
                    @elseif ($status === 'already_verified')
                        <div class="alert alert-info" role="alert">
                            <h5 class="alert-heading">Information</h5>
                            <p>{{ $message }}</p>
                        </div>
                        <div class="badge bg-info badge-status">Account Status: Already Verified</div>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-home">
                        <i class="bi bi-house-door"></i> Go to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
