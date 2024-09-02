<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP Verification</title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      max-width: 400px;
      margin-top: 100px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="text-center mb-4">OTP Verification</h2>
    {{session('servicePrviderEmail')}}
    <form id="otpForm" method="post" action="{{route('varify-otp')}}">
        @csrf
      <div class="mb-3">
        <label for="otp" class="form-label">Enter OTP</label>
        <input type="text" class="form-control" id="otp" name="otp" maxlength="6" required>
        <input type="hidden" value="{{ session('servicePrviderEmail') }}" name="email">
    </div>

      <button type="submit" class="btn btn-primary mb-3" >Verify OTP</button>

      <p class="text-center">
        <small>Didn't receive OTP? <a href="#" onclick="resendOTP()">Resend OTP</a></small>
      </p>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-eU3nXfylqP5DGE8eDIkfGoaTxZ2d0IqMqb8QlmfHjy8RrO5qt1x4Flgir3h5C1S" crossorigin="anonymous"></script>

  <script>
    function verifyOTP() {
      // Implement your OTP verification logic here
      // For demonstration purposes, alert the entered OTP
      var enteredOTP = document.getElementById('otp').value;
      alert('Entered OTP: ' + enteredOTP);
    }

    function resendOTP() {
      // Implement your OTP resend logic here
      // For demonstration purposes, alert that OTP has been resent
      alert('OTP Resent');
    }
  </script>
</body>

</html>
