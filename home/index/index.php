<?php
// index.php
session_start();

// Include config file
require_once '../../config.php';
// require_once '../../'

// Process form submission to add a new post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_item'])) {
    require_once '../create/add_item.php';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Posts</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <a class="logout_btn" href="../../logout/logout.php">Log Out</a>
        <h1>Add Post</h1>
        <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="post-form">
            <label for="Title"><strong>Title</strong></label><br><br>
            <input type="text" name="title" placeholder="Title" required><br><br>
            <label for="Description"><strong>Description</strong></label><br><br>
            <textarea name="description" placeholder="Description" required></textarea><br><br>
            <input type="submit" name="add_item" value="Add Item" class="btn btn-success">
        </form>
        <script>
            function logout() {
                window.location.href = '../../login/index.php';
            }
        </script>

        <?php
        // Retrieve existing posts
        $sql = 'SELECT * FROM to_do_list';
        $result = $conn->query($sql);

        // Check if any posts exist
        if ($result->num_rows > 0) {
            // Output posts
            echo '<h1>List of Posts</h1>';
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h2 class='post-title'>" . $row['title'] . '</h2>';
                echo "<p class='post-description'>" . $row['description'] . '</p>';
                echo "<form action='../update/update_item.php' method='post' class='action-form'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<input type='submit' name='update_item' value='Update' class='btn btn-primary'>";
                echo '</form>';
                echo "<form action='../delete/delete_item.php' method='post' class='action-form'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<input type='submit' name='delete_item' value='Delete' class='btn btn-danger'>";
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo 'No posts found.';
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>

</html>