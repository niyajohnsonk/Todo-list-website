<?php
require("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["task_id"]) && isset($_SESSION["id"])) {
        $task_id = $_POST["task_id"];
        $user_id = $_SESSION["id"];

        // Use prepared statement to prevent SQL injection
        $query = "DELETE FROM `user todo list` WHERE task_id = ? AND id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $task_id, $user_id);

        if ($stmt->execute()) {
            echo "Task deleted successfully";
        } else {
            echo "Error deleting task: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid request: task ID or session missing.";
    }
} else {
    echo "Invalid request method.";
}
?>
