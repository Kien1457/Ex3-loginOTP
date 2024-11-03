import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.3/firebase-app.js";
import {
    getAuth, // xác thực
    RecaptchaVerifier, // tạo mã xác thực
    signInWithPhoneNumber,
} from "https://www.gstatic.com/firebasejs/9.8.3/firebase-auth.js";

// cấu hình firebase
const firebaseConfig = {
    apiKey: "AIzaSyBqkYKMP11MwF7RsQ8R9HMXjIGbkSSyk_k",
    authDomain: "otp-app-7104e.firebaseapp.com",
    projectId: "otp-app-7104e",
    storageBucket: "otp-app-7104e.firebasestorage.app",
    messagingSenderId: "529119554485",
    appId: "1:529119554485:web:425ac562dbdcee60bd87fc",
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
auth.languageCode = "en";

window.onload = function () {
    render();
};

function render() {
    window.recaptchaVerifier = new RecaptchaVerifier(
        "recaptcha-container",
        {
            size: "normal",

            callback: (response) => {
                alert("Recaptcha success! Enter your phone number please!");
                $("#send_otp").removeAttr("disabled");
            },
            "expired-callback": () => {
                alert("Recaptcha has been expired! Retry again please!");
            },
        },
        auth
    );
    recaptchaVerifier.render();
}

window.sendOTP = function () {
    const phoneNumber = $("#phone_number").val();
    const appVerifier = window.recaptchaVerifier;
    signInWithPhoneNumber(auth, phoneNumber, appVerifier)
        .then((confirmationResult) => {
            window.confirmationResult = confirmationResult;
            alert("OTP has been sent! Please check your phone");
            $("#verification_input").show();
            $("#phone_input").hide();
        })
        .catch((error) => {
            window.recaptchaVerifier.render().then((widgetId) => {
                grecaptcha.reset(widgetId);
            });
            alert(error.message);
        });
};

window.verifyOTP = function () {
    const code = $("#verification_code").val();

    confirmationResult
        .confirm(code)
        .then((result) => {
            alert("OTP has been verified successfully!");
            const user = result.user;

            $.ajax({
                url: "/otp-verified",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    window.location.href = "/index";
                },
                error: function (error) {
                    alert("Server error, please try again.");
                },
            });
        })
        .catch((error) => {
            alert(error.message);
        });
};

window.tryAgain = function () {
    $("#verification_input").hide();
    $("#phone_input").show();
    $("#verification_code").val("");
};
