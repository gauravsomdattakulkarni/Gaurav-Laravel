<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .content p {
            margin: 15px 0;
        }
        .otp-box {
            text-align: center;
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            border: 2px dashed #007bff;
            display: inline-block;
            border-radius: 8px;
            background-color: #f0f8ff;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>OTP Verification || EduQuizHub</h1>
        </div>
        <div class="content">
            <p>Hello {{ $firstName }} {{ $lastName }},</p>
            <p>Click on button to verify you email ID</p>
            <a href="{{ url('account_verification/' . $userId) }}" class="btn-primary">Verify Account</a>
            <p>If you did not request this OTP, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>EduQuizHub</p>
        </div>
    </div>
</body>
</html>
