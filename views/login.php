<!-- login.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <div class="login-container">
        <!-- Login Form -->
        <form method="post" action="login.php">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required data-test-id="username">
            <input type="password" name="password" placeholder="Password" required data-test-id="password">
            <button type="submit" name="action" value="login" data-test-id="login">Login</button>
        </form>

        <!-- Registration Form -->
        <form method="post" action="login.php">
            <h2>Register</h2>
            <input type="text" name="new_username" placeholder="Username" required data-test-id="new_username">
            <input type="password" name="new_password" placeholder="Password" required data-test-id="new_password">
            <button type="submit" name="action" value="register" data-test-id="register">Register</button>
        </form>
    </div>
</body>

</html>