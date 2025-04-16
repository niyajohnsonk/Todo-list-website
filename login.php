<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | ToDo List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      background-color: #000B58;
      color: #FFF4B7;
    }

    .container {
      max-width: 600px;
      margin: auto;
      padding-top: 50px;
    }

    .jumbotron {
      background-color: #003161;
      color: #FFF4B7;
      padding: 2rem;
      text-align: center;
      border-radius: 10px;
    }

    .form {
      background-color: #003161;
      padding: 3rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-label {
      color: #FFF4B7;
    }

    .btn-primary {
      background-color: #006A67;
      border-color: #006A67;
    }

    .btn-primary:hover {
      background-color: #004F49;
      border-color: #004F49;
    }

    .btn-success {
      background-color: #006A67;
      border-color: #006A67;
    }

    .btn-success:hover {
      background-color: #004F49;
      border-color: #004F49;
    }

    .alert-warning {
      background-color: #FFF4B7;
      color: #000B58;
    }

    h1 {
      color: #FFF4B7;
    }

    h3 {
      color: #FFF4B7;
    }

    .logout-button {
      color: #FFF4B7;
    }

    .logout-button:hover {
      color: #003161;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="jumbotron">
      <h1>Login!</h1>
      <p>If you have an account <br> Enter your email and password to enter..</p>
    </div>
    <!-- Form -->
    <div class="form">
      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
        <br><br><br>
        <h3>Need an account?</h3><br>
        <a href="signup.php" class="btn btn-success w-100">Signup</a>
      </form>
    </div>

    <!-- Connection -->
    <?php
    require("connection.php");
    if (isset($_POST["submit"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $check = "SELECT * FROM user_info WHERE email = '$email' AND password = '$password'";
        $execute = mysqli_query($conn, $check);
        $user_info = mysqli_fetch_assoc($execute);
        $no_of_rows = mysqli_num_rows($execute);

        if ($no_of_rows == 0) {
            echo '<div class="container mt-5">
                    <div class="alert alert-warning" role="alert">
                      <strong>No Account Found!</strong> Signup to create an account or enter the correct credentials.
                    </div>
                  </div>';
        } else {
            session_start();
            $_SESSION["firstname"] = $user_info["firstname"];
            $_SESSION["id"] = $user_info["id"];
            $_SESSION["email"] = $user_info["email"];
            $_SESSION["image"] = $user_info["image"];
            // Redirect to the dashboard page
            header("Location: dashboard.php");
            exit();
        }
    }
    ?>
  </div>
</body>

</html>
