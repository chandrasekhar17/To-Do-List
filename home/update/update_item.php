<?php
// Include config file
require_once '../../config.php';

// Initialize variables
$id = $title = $description = '';
$title_err = $description_err = '';

// Check if ID parameter is set
if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    // Get ID from URL
    $id = trim($_POST['id']);

    // Prepare a SELECT statement
    $sql = 'SELECT title, description FROM to_do_list WHERE id = ?';
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param('i', $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Bind result variables
            $stmt->bind_result($title, $description);

            // Fetch the result row
            $stmt->fetch();
        } else {
            echo 'Oops! Something went wrong. Please try again later.';
        }

        // Close statement
        $stmt->close();
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if title and description are set in the form submission
    if (isset($_POST['title']) && isset($_POST['description'])) {
        // Validate title
        $title = trim($_POST['title']);
        if (empty($title)) {
            $title_err = 'Please enter a title.';
        }

        // Validate description
        $description = trim($_POST['description']);
        if (empty($description)) {
            $description_err = 'Please enter a description.';
        }

        // If no errors, update record in database
        if (empty($title_err) && empty($description_err)) {
            // Prepare an UPDATE statement
            $sql = 'UPDATE to_do_list SET title = ?, description = ? WHERE id = ?';

            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param('ssi', $param_title, $param_description, $param_id);

                // Set parameters
                $param_title = $title;
                $param_description = $description;
                $param_id = $id;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to the to-do list page
                    $redirectUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/forms/home/index/index.php';
                    header('location: ' . $redirectUrl);
                    exit;
                } else {
                    echo 'Oops! Something went wrong. Please try again later.';
                }

                // Close statement
                $stmt->close();
            }
        }
    } else {
        echo 'Form fields not set.';
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update To-Do Item</title>
    <link href="styles.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#title').on('input', function () {
                var title = $(this).val();
                if (title.length < 6) {
                    $('#title-error').text('Title should be at least 6 characters long').css('color', 'red');
                } else {
                    $('#title-error').text('').css('color', 'red');
                }
            });

            $('#description').on('input', function () {
                var description = $(this).val();
                if (description.length < 10) {
                    $('#desc-error').text('Description should be at least 10 characters long').css('color', 'red');
                } else {
                    $('#desc-error').text('').css('color', 'red');
                }
            });

            // Validate fields on form submission
            $('.update-form').submit(function (event) {
                var title = $('#title').val();
                var description = $('#description').val();
                var isValid = true;

                if (title.length < 6) {
                    $('#title-error').text('Title should be at least 6 characters long').css('color', 'red');
                    isValid = false;
                }

                if (description.length < 10) {
                    $('#desc-error').text('Description should be at least 10 characters long').css('color', 'red');
                    isValid = false;
                }
                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h2>Update To-Do Item</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="update-form">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div>
                <label>Title:</label>
                <input id="title" class="post-title" type="text" name="title"
                    value="<?php echo isset($title) ? $title : ''; ?>">
                <span id="title-error" class="error"></span><br><br>

                <!-- <span class="error"><?php echo $title_err; ?></span> -->
            </div>
            <div>
                <label>Description:</label>
                <textarea id="description" class="post-description"
                    name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
                <!-- <span class="error"><?php echo $description_err; ?></span> -->
                <span id="desc-error" class="error"></span><br><br>
            </div>
            <div>
                <input type="submit" value="Update" class="btn btn-success" />
                <a href="../index/index.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>