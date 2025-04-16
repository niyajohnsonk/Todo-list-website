<?php
require("connection.php");
session_start();

// Ensure it's a POST request and the session is valid
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["task_id"]) && isset($_SESSION["id"])) {
    $task_id = $_POST["task_id"];
    $user_id = $_SESSION["id"];

    // Use prepared statement to delete only the user's task
    $query = "DELETE FROM `user todo list` WHERE task_id = ? AND id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $task_id, $user_id);

    if ($stmt->execute()) {
        echo "Task deleted successfully";
    } else {
        http_response_code(500); // Tell jQuery the request failed
        echo "Error deleting task";
    }

    $stmt->close();
} else {
    http_response_code(400); // Bad request
    echo "Invalid request.";
}
?>
