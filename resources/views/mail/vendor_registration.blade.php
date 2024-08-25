<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Registration Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007BFF;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            padding: 20px;
            text-align: left;
        }
        .button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Registering!</h1>
        </div>
        <div class="content">
            <p>Dear {{$mailData['vendor_name']}},</p>
            <p>Thank you for registering as a vendor with us. We are excited to have you on board!</p>
            <p>Please varify your account by using the code below: </p>
            <h5 style="text-align: center; font-size: 18px; background: #e7e7e7; padding: 5px 0px; border-radius: 4px;">{{$mailData['verification_code']}}</h5>
            {{-- <p>You can access the vendor login panel using the link below:</p>
            <a href="{{env('VENDOR_URL')}}" class="button" style="color: white">Vendor Login Panel</a>
            <p>Please wait until an admin approves your account. Once approved, you will be able to log in and start using our services.</p>
            <p>If you have any questions or need assistance, feel free to contact our support team.</p> --}}
            <p>Best regards,<br>{{env('APP_NAME')}}</p>
        </div>
        <div class="footer">
            <p>&copy; {{date("Y")}} {{env('APP_NAME')}}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
