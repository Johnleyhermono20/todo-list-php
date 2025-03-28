<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = trim($_POST["task"]);
    $user_id = $_SESSION["user_id"];
    
    // Validate task
    if (empty($task)) {
        $_SESSION["error"] = "You're Task is Empty";
        header("Location: index.php");
        exit;
    }
    
    // Insert task into database
    $sql = "INSERT INTO tasks (user_id, task) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $task);
    
    if ($stmt->execute()) {
        $_SESSION["success"] = "Task added successfully";
    } else {
        $_SESSION["error"] = "Error adding task: " . $conn->error;
    }
    
    $stmt->close();
    header("Location: index.php");
    exit;
}
?>