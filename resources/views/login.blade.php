<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OTP Authentication</title>
</head>

<body>
    <h3>OTP Authentication</h3>
    <div id="phone_input">
        <div id="recaptcha-container"></div>
        <input id="phone_number" type="text" placeholder="Phone number">
        <button type="button" onclick="sendOTP();" disabled id="send_otp">Send OTP</button>
    </div>

    <div id="verification_input" style="display: none;">
        <input id="verification_code" type="text" placeholder="Enter OTP">
        <button type="button" onclick="verifyOTP();">Verify OTP</button>
        <button type="button" onclick="tryAgain();">Retry</button>
    </div>

    <div id="signout_button" style="display: none;">
        <button type="button" onclick="signOut();">Sign Out</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/firebase.js') }}" type="module"></script>
</body>

</html>
