<?php
session_start();

// If no OTP/email in session, redirect back to index.php
if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['verify'])) {
    $enteredOtp = trim($_POST['otp']); // remove extra spaces

    if ($enteredOtp == $_SESSION['otp']) {
        echo "<h2 style='color:green;'>OTP Verified Successfully!</h2>";
        header('location:upload_file.php');
        // Allow user to access secure page or save details in DB
        unset($_SESSION['otp']); // clear OTP
    } else {
        echo "<h2 style='color:red;'>Invalid OTP. Please try again.</h2>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    
    <form method="post" class="login_system">
        <h2 style="color:yellow">Enter the OTP sent to <b><?php echo htmlspecialchars($_SESSION['email']); ?></b></h2>
        <label>OTP:</label>
        <input type="text" name="otp" required><br><br>
        <button type="submit" name="verify" >Verify OTP</button>
    </form>
</body>
</html>
