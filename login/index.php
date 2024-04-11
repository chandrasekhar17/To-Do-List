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
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="/forms/login/index.php" method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
            </div>
            <div>
                <input type="submit" value="Login" />
            </div>
        </form>
        <p>Don't have an account? <a href="/forms/register/registration.php">Register here</a>.</p>
    </div>
</body>

</html>