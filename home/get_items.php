<?php
// Include config file
require_once "../config.php";

// Check if ID parameter is set
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Get ID from URL
    $id = trim($_GET["id"]);

    // Prepare a DELETE statement
    $sql = "DELETE FROM to_do_list WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the to-do list page
            header("location: todo.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
} else {
    // URL doesn't contain an ID parameter, redirect to error page
    header("location: error.php");
    exit();
}
?>