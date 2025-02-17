<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f6f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            color: #6A38C2;
        }
        .content {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .content p {
            margin-bottom: 10px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6A38C2;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Job Application Received</h2>
        </div>
        <div class="content">
            <p>Dear {{ $mailData['user']->name }},</p>
            <p>Thank you for applying for the position of {{ $mailData['job']->title  }} at {{ $mailData['job']->company_name  }}. We have received your application, and our team will review your qualifications. If your skills and experience match our requirements, we will contact you for an interview.</p>
            <p>We appreciate your interest in joining our team and will keep you updated on the progress of your application.</p>
            <p>If you have any questions, feel free to reach out to us at <a href="mailto:{{ $mailData['user']->email  }}">hr@jobhunt.com</a>.</p>
            
            <p>Best regards,</p>
            <p><strong>{{ $mailData['job']->company_name  }}</strong><br>
            Human Resources Team</p>
            
            <a href="{{ $mailData['job']->company_website  }}" class="button">Visit Our Website</a>
        </div>
        <div class="footer">
            <p>&copy; 2024 JobHunt. All rights reserved.</p>
        </div>
    </div>
</body>
</html>