<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Bootstrap & jQuery -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      background-color: #000B58;
      color: #FFF4B7;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
      max-width: 800px;
      margin: 4rem auto;
      padding: 2rem;
      background-color: #003161;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      animation: fadeIn 1s ease;
    }

    .logout-button {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #FF6B6B;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      font-weight: bold;
    }

    .logout-button:hover {
      background-color: #e74c3c;
    }

    h1 {
      color: #FFF4B7;
      font-size: 2.5rem;
    }

    label {
      color: #FFF4B7;
      font-weight: bold;
    }

    .btn-primary {
      background-color: #006A67;
      border: none;
    }

    .btn-primary:hover {
      background-color: #004e4b;
    }

    .btn-danger {
      background-color: #FF6B6B;
      border: none;
    }

    .btn-danger:hover {
      background-color: #e74c3c;
    }

    .list-group-item {
      background-color: #002244;
      border: 1px solid #003161;
      color: #FFF4B7;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .update, .delete {
      font-size: 0.9rem;
      padding: 6px 14px;
      margin-left: 10px;
    }

    .img-thumbnail {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      margin: 1rem 0;
      border: 3px solid #FFF4B7;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="container text-center">
    <?php
      session_start();
      if (isset($_SESSION["email"])) {
          $firstname = $_SESSION["firstname"];
          $image = $_SESSION["image"];
          echo "<h1>Welcome, $firstname</h1>";
          echo "<img src='$image' alt='Your Profile Photo' class='img-thumbnail'>";
    ?>
      <a href="logout.php" class="logout-button" id="logoutLink">Logout</a>

      <div class="mt-4">
        <h1>Add a New Task</h1>
        <form action="dashboard.php" method="POST" class="text-start">
          <div class="mb-3">
            <label for="task" class="form-label">Task Title</label>
            <input type="text" name="task_title" class="form-control" id="task" required>
          </div>
          <div class="mb-3">
            <label for="task" class="form-label">Task Description</label>
            <textarea name="task_description" class="form-control" id="task" required></textarea>
          </div>
          <button type="submit" onclick="refresh()" name="submit" class="btn btn-primary">Add Task</button>
        </form>
      </div>

      <?php
require("connection.php");
session_start();

if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];

    // FIRST: Handle form submission before HTML output
    if (isset($_POST["submit"])) {
        $task_title = $_POST["task_title"];
        $task_description = $_POST["task_description"];

        $query = "INSERT INTO `user todo list` (id, task_title, task_description) VALUES ('$id', '$task_title', '$task_description')";
        mysqli_query($conn, $query);

        // Redirect to avoid resubmission
        header("Location: dashboard.php");
        exit();
    }

    // NOW show the tasks
    echo '<div class="mt-5 text-start">
            <h1>Your Tasks</h1>
            <ul class="list-group">';

    $query = "SELECT * FROM `user todo list` WHERE id = '$id'";
    $execute = mysqli_query($conn, $query);

    while ($rows = mysqli_fetch_assoc($execute)) {
        $task_title = $rows["task_title"];
        $task_description = $rows["task_description"];
        $task_id = $rows["task_id"];

        echo '<li class="list-group-item">
                <strong>' . htmlspecialchars($task_title) . '</strong><br>' . htmlspecialchars($task_description) . '
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" onclick="updateTask(' . $task_id . ', \'' . addslashes($task_title) . '\', \'' . addslashes($task_description) . '\')" class="btn btn-sm btn-primary me-2">Edit</button>
                    <button type="button" onclick="deleteTask(' . $task_id . ')" class="btn btn-sm btn-danger">Delete</button>
                </div>
              </li>';
    }

    echo '</ul></div>';
} else {
    echo '<p>Please login to continue</p>';
    echo '<a href="login.php" class="btn btn-success logout-button">Login</a>';
}
?>

  </div>

  <script>
    function refresh() {
      setTimeout(() => location.reload(), 300);
    }

    function deleteTask(taskId) {
      $.post("delete.php", { task_id: taskId }, function () {
        location.reload();
      }).fail(function () {
        alert("Error deleting task.");
      });
    }

    function updateTask(taskId, tasktitle, taskdescription) {
      var newTitle = prompt("Edit title:", tasktitle);
      var newDescription = prompt("Edit description:", taskdescription);

      if (newTitle === null && newDescription === null) return;

      $.ajax({
        url: "update.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          task_id: taskId,
          title: newTitle || tasktitle,
          description: newDescription || taskdescription
        }),
        success: function () {
          location.reload();
        },
        error: function () {
          alert("Failed to update task.");
        }
      });
    }
  </script>
</body>
</html>

