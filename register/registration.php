<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to validate email address
            function isValidEmail(email) {
                var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return pattern.test(email);
            }

            // Function to validate alphanumeric password
            function isAlphanumericPassword(password) {
                var pattern = /^[a-zA-Z0-9]+$/;
                return pattern.test(password);
            }

            // Function to validate individual fields
            function validateField(field) {
                var value = field.val().trim();
                var errorSpan = field.next('.error');

                // Reset previous error messages
                errorSpan.remove();

                // Validate field value
                if (!value) {
                    field.after('<span class="error">This field is required</span>');
                    return false;
                }

                // Validate username length
                if (field.attr('id') === 'username') {
                    if (value.length < 4 || value.length > 20) {
                        field.after('<span class="error">Username must be between 4 and 20 characters</span>');
                        return false;
                    }
                }

                // Validate password length and alphanumeric
                if (field.attr('id') === 'password') {
                    if (value.length < 6 || value.length > 20) {
                        field.after('<span class="error">Password must be between 6 and 20 characters</span>');
                        return false;
                    }
                    if (!isAlphanumericPassword(value)) {
                        field.after('<span class="error">Password must be alphanumeric</span>');
                        return false;
                    }
                }

                // Validate email
                if (field.attr('id') === 'email' && !isValidEmail(value)) {
                    field.after('<span class="error">Please enter a valid email</span>');
                    return false;
                }

                return true;
            }

            // Validate fields on blur event
            $('#username, #email, #password').blur(function () {
                validateField($(this));
            });

            // Validate form on submission
            $('#registrationForm').submit(function (event) {
                // Reset previous error messages
                $('.error').remove();

                var isValid = true;

                // Validate individual fields
                $('#username, #email, #password').each(function () {
                    if (!validateField($(this))) {
                        isValid = false;
                    }
                });

                // Prevent form submission if validation fails
                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="registration-container">
        <h2>Registration Form</h2>
        <form id="registrationForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="male">male</option>
                <option value="female">Female</option>
                <option value="others">Other</option>
            </select><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" name="submit" value="Submit">
        </form>
        <p>Already have an account? <a href="/forms/login/index.php">Login</a></p>

        <?php
        require_once '../config.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $gender = $_POST['gender'];

            if (!empty($username) && !empty($email) && !empty($password)) {
                $username = mysqli_real_escape_string($conn, $username);
                $email = mysqli_real_escape_string($conn, $email);
                $password = mysqli_real_escape_string($conn, $password);
                $gender = mysqli_real_escape_string($conn, $gender);

                $sql = "INSERT INTO users (username, gender, email, password) VALUES ('$username', '$gender', '$email', '$password')";
                if ($conn->query($sql) === true) {
                    echo 'Registration successful!';
                } else {
                    echo 'Error: ' . $sql . '<br>' . $conn->error;
                }
            } else {
                echo 'All fields are required!';
            }
        }
        ?>
    </div>
</body>

</html>