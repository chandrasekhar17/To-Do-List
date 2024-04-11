<?php
require_once "../../config.php";

$title = $description = '';
$title_err = $description_err = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter a description.";
    } else {
        $description = trim($_POST["description"]);
    }

    // If no errors, insert into database
    if (empty($title_err) && empty($description_err)) {
        // Prepare SQL statement
        $sql = "INSERT INTO to_do_list (title, description) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("ss", $param_title, $param_description);

            // Set parameters
            $param_title = $title;
            $param_description = $description;

            // Attempt to execute the statement
            if ($stmt->execute()) {
                // Redirect to the to-do list page
                $redirectUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/forms/home/index/index.php';
                // echo $redirectUrl;
                // DIE;
                header("location: " . $redirectUrl);
                // exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add To-Do Item</title>
    <style>
        .error {
            color: red;
        }
    </style>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>Add To-Do Item</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo $title; ?>">
            <span class="error"><?php echo $title_err; ?></span>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"><?php echo $description; ?></textarea>
            <span class="error"><?php echo $description_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </div>
    </form>
</body>

</html>