<?php
// Include config file
require_once "../../config.php";

// Process form submission to delete a to-do item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_item"])) {
    // Get ID from form submission
    $id = trim($_POST["id"]);

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
            $redirectUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/forms/home/index/index.php';
            header("location: " . $redirectUrl);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>