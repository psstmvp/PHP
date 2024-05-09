<?php
session_start();
include("../Assets/Connection/Connection.php");
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
    <title>OTP</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../A.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f0f0f0;
			text-align: center;
		}

		.container {
			background-color: #fff;
			max-width: 400px;
			margin: 0 auto;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		h1 {
			font-size: 24px;
			margin: 0;
		}

		.otp-input {
			margin-top: 20px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		input[type="number"] {
			width: 40px;
			height: 40px;
			text-align: center;
			font-size: 18px;
			margin: 0 5px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}

		input[type="number"]::-webkit-inner-spin-button,
		input[type="number"]::-webkit-outer-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		input[type="number"]:focus {
			border: 1px solid #007bff;
			outline: none;
		}

		.error-message {
			color: red;
			margin-top: 10px;
		}
        .button-link {
  display: none;
  padding: 10px 20px;
  background-color: #2865AF; 
  color: #fff; 
  text-decoration: none; 
  border: none;
  border-radius: 4px; 
  cursor: pointer; 
  text-align: center;
  margin-top: 30px;
}
	</style>
</head>

<body>


    <form method="post">
        <div class="container" style="margin-top:150px;">
            <h1>Enter OTP</h1>
            <p>We've sent a 6-digit OTP to your email/phone. Please enter it below.</p>
            <form id="otp-form">
                <div class="otp-input" id="otp-input">
                    <input type="number" id="digit1" class="otp-digit" min="0" max="9" maxlength="1" data-index="1" />
                    <input type="number" id="digit2" class="otp-digit" min="0" max="9" maxlength="1" data-index="2" />
                    <input type="number" id="digit3" class="otp-digit" min="0" max="9" maxlength="1" data-index="3" />
                    <input type="number" id="digit4" class="otp-digit" min="0" max="9" maxlength="1" data-index="4" />
                    <input type="number" id="digit5" class="otp-digit" min="0" max="9" maxlength="1" data-index="5" />
                    <input type="number" id="digit6" class="otp-digit" min="0" max="9" maxlength="1" data-index="6" />
                </div>
            </form>
            <p id="error-message" class="error-message"></p>
        </div> 
        <center>
        <button id="resendButton" class="button-link" onClick="resend()">Resend</button>
</center>
        <p id="timer">resend in: 60 seconds</p>

    </form>
    <script src="../Assets/JQ/jQuery.js "></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const otpDigits = document.querySelectorAll('.otp-digit');
            const errorMessage = document.getElementById('error-message');

            otpDigits.forEach((digit, index) => {
                digit.addEventListener('input', function () {
                    if (this.value >= 0 && this.value <= 9) {
                        if (index < otpDigits.length - 1) {
                            otpDigits[index + 1].focus();
                        } else {
                            const enteredOTP = Array.from(otpDigits).map(d => d.value).join('');
                            if (isValidOTP(enteredOTP)) {

                                if(<?php echo $_SESSION["otp"]?>==enteredOTP)
                                window.location = "ChangePassword.php";
                            } else {
                                errorMessage.textContent = 'Invalid OTP. Please enter a 6-digit number.';
                            }
                        }
                    } else {
                        this.value = ''; // Clear the input if it's not a valid number
                    }
                });

                digit.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && index > 0 && this.value === '') {
                        otpDigits[index - 1].focus();
                    }
                });
            });

            otpDigits[0].focus();


            function isValidOTP(otp) {
                return /^\d{6}$/.test(otp);
            }
        });
        // Function to start the timer
        function startTimer(duration, display) {
            let timer = duration;
            let intervalId = setInterval(function () {
                const minutes = Math.floor(timer / 60);
                const seconds = timer % 60;

                display.textContent = `resend : ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                if (--timer < 0) {
                    clearInterval(intervalId);
                    display.textContent = "click resent to sent the OTP again!";
                    document.getElementById('resendButton').style.display = 'block';
                }
            }, 1000);
        }

        // Function to initialize the timer
        function initializeTimer() {
            const timerset = 60; // Set the timer duration in seconds
            const display = document.getElementById('timer');
            startTimer(timerset, display);
        }

        // Call the initializeTimer function when the page loads
        window.onload = initializeTimer;
    </script>


    <script>
        function resend() {
            window.location = "ForgotPassword.php?id=1";
        }
    </script>

</body>

</html>