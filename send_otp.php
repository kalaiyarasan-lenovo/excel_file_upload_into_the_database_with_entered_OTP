<?php session_start();  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sent OTP</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <form action="send_email.php" method="post"class='login_system'>
        <h1>send OTP
        </h1>
        <div>
            <label for="username">username:</label>
            <input type="text" name="username" required>
        </div>
        <br>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>
        <br>
        <div>
            <button type="submit" name="submit">submit</button>
        </div>
    </form>
</body>
</html>