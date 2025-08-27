<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Afya Dynamics</title>

    <style>
        @font-face {
            font-family: "Nunito Sans";
            src: url('/google-fonts/Nunito_Sans/NunitoSans-VariableFont_YTLC,opsz,wdth,wght.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'Nunito Sans', sans-serif !important;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        p {
            font-family: 'Nunito Sans', sans-serif !important;
        }
        h1,h2,h3,h4,h5,h6{
            font-family: 'Nunito Sans', sans-serif !important;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }


        .logo {
            max-width: 200px;
            display: block;
            margin: auto;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message">
            <h1>Email Notification</h1>
            <p>The introduction to the notification.</p>
            <p>Your confirmation code is: {{ $code }}</p>
            <p>Thank you for using our application!</p>
        </div>
        <div class="footer">
            <img src="{{url('/').'/img/no-bg-logo.png'}}" class="logo">
            <p style="font-size: 10px;">The content of this email is confidential and intended for the recipient specified in message only. It is strictly forbidden to share any part of this message with any third party, without a written consent of the sender. If you received this message by mistake, please reply to this message and follow with its deletion, so that we can ensure such a mistake does not occur in the future.</p>
        </div>
    </div>
</body>
</html>