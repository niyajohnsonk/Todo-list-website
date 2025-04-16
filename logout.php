<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logged Out</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      background-color: #f8f9fa;
      color: #333;
    }
    .logout-box {
      margin-top: 100px;
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h1 {
      color: #007bff;
    }
  </style>
</head>
<body class="text-center">

  <?php
    session_start();
    session_unset();
    session_destroy();
  ?>

  <div class="container logout-box">
    <h1>You are logged out!</h1>
    <p class="mt-3">You have been successfully logged out of your account.</p>
    <hr>

    <h4>Already have an account?</h4>
    <a href="login.php" class="btn btn-success mt-2">Login</a>

    <h4 class="mt-4">Need a new account?</h4>
    <a href="signup.php" class="btn btn-primary mt-2">Sign Up</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xssHTMqFuxZjvKGbNlDA5Z6GqyslT7MfpiFJfuFU37FkN2EEu7b8dGf4D1eBD99D" crossorigin="anonymous"></script>
</body>
</html>

