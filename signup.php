<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signup | ToDo List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .container {
      max-width: 600px;
      margin: auto;
      text-align: center;
    }

    .jumbotron {
      background-color: #000B58;
      color: #ffffff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form {
      padding: 2rem;
      background-color: #FFF4B7;
      border-radius: 10px;
      margin-top: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-label {
      float: left;
      font-weight: 500;
      color: #003161;
    }

    .btn-primary {
      background-color: #006A67;
      border-color: #006A67;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #005450;
      border-color: #005450;
    }

    .btn-success {
      background-color: #003161;
      border-color: #003161;
      transition: all 0.3s ease;
    }

    .btn-success:hover {
      background-color: #002548;
      border-color: #002548;
    }

    hr {
      border-color: #003161;
      opacity: 0.3;
    }

    .form-control:focus {
      border-color: #006A67;
      box-shadow: 0 0 0 0.25rem rgba(0, 106, 103, 0.25);
    }

    .radio-group {
      display: flex;
      gap: 20px;
    }

    .radio-label {
      display: flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
    }

    h5 {
      color: #003161;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="jumbotron mt-4">
      <h1>Signup Now!</h1>
      <p>Create your account to get started.</p>
    </div>

    <!-- Signup Form -->
    <div class="form">
      <form action="signup.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="firstname" class="form-label">First Name</label>
          <input type="text" name="firstname" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="lastname" class="form-label">Last Name</label>
          <input type="text" name="lastname" class="form-control">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">Profile Picture</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3 text-start">
          <label class="form-label">Choose your designation</label>
          <div class="radio-group mt-2">
            <label class="radio-label">
              <input type="radio" name="designation" value="Student" required> Student
            </label>
            <label class="radio-label">
              <input type="radio" name="designation" value="Professional"> Professional
            </label>
          </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Signup</button>
        <hr>
        <h5>Already have an account?</h5>
        <a href="login.php" class="btn btn-success mt-2 w-100">Login</a>
      </form>
    </div>

    <!-- PHP logic -->
    <?php
    error_reporting(E_ERROR | E_PARSE);
    require("connection.php");

    if (isset($_POST["submit"])) {
      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $designation = $_POST["designation"];

      $file_in_db = "";
      if (isset($_FILES["image"]) && $_FILES["image"]["name"]) {
        $file_name = $_FILES["image"]["name"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_in_db = "uploads/" . $file_name;
        move_uploaded_file($file_tmp, $file_in_db);
      }

      $check = "SELECT * FROM user_info WHERE email = '$email'";
      $execute = mysqli_query($conn, $check);
      $no_of_rows = mysqli_num_rows($execute);

      if ($no_of_rows > 0) {
        echo '<div class="alert alert-warning mt-4" role="alert">
                <strong>Account already exists!</strong> Try logging in instead.
              </div>';
      } else {
        $query = "INSERT INTO user_info (firstname, lastname, email, password, designation, image) 
                  VALUES ('$firstname','$lastname','$email','$password','$designation','$file_in_db')";
        $execute = mysqli_query($conn, $query);

        if ($execute) {
          header("Location: login.php");
          exit();
        } else {
          echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
        }
      }
    }
    error_reporting(E_ALL);
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>