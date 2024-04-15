<?php

session_start();

if (isset($_SESSION['user'])) {
    header('Location: /forms/home/index/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $servername = 'localhost';
    $username = 'root';
    $password_db = '';
    $dbname = 'php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stored_password = $row['password'];
            if ($password === $stored_password) {
                $_SESSION['user'] = $email;
                header('Location: /forms/home/index/index.php');
                exit;
            } else {
                // header('Location: login.html?error=invalid_password');
                echo 'Incorrect Email or Password';
                exit;
            }
        } else {
            header('Location: login.html?error=user_not_found');
            exit;
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    $conn = null;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .error {
            color: red;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#email').on('input', function () {
                var email = $(this).val();
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(email)) {
                    $('#email-error').text('Please enter a valid email address.');
                } else {
                    $('#email-error').text('');
                }
            });

            $('#password').on('input', function () {
                var password = $(this).val();

                if (password.length < 6) {
                    $('#password-error').text('Invalid Password');
                } else {
                    $('#password-error').text('');
                }
            });

            $('#login-form').submit(function (event) {
                var email = $('#email').val();
                var password = $('#password').val();
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(email)) {
                    $('#email-error').text('Please enter a valid email address.');
                    event.preventDefault();
                } else {
                    $('#email-error').text('');
                }

                if (password.length < 6) {
                    $('#password-error').text('Password must be at least 6 characters long.');
                    event.preventDefault();
                } else {
                    $('#password-error').text('');
                }
            });
        });
    </script>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="login-form" action="/forms/login/index.php" method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
                <span id="email-error" class="error"></span>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
                <span id="password-error" class="error"></span>
            </div>
            <div>
                <input type="submit" value="Login" />
            </div>
        </form>
        <p>Don't have an account? <a href="/forms/register/registration.php">Register here</a>.</p>
        <p>
            <!-- <a href="/forms/api/api.php">Get Demo Users</a> -->
            <a href="/forms/api/cURL.php">cURL</a> or <a href="/forms/api/api.php">Ajax</a>

        </p>
        <!-- <p><a href="/forms/api/chat.php">Chat with us ?</a></p> -->
    </div>
</body>

</html>