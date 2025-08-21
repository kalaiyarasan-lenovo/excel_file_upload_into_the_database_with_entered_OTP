<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);

    // (Optional) Store OTP in session for later verification
    session_start();
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();                                            
        $mail->Host = 'smtp.gmail.com';                     
        $mail->SMTPAuth = true;                                   
        $mail->Username = 'kalai2003testing@gmail.com';                     
        $mail->Password = 'wmpuudckyedcgesf';     // Use App Password, not Gmail password                 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port = 587;                                    

        //Recipients
        $mail->setFrom('kalai2003testing@gmail.com', 'My App');
        $mail->addAddress($email, $username);     //Send OTP to user’s email

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "
            <h2>Hello, $username</h2>
            <p>Your One-Time Password (OTP) is:</p>
            <h3 style='color:blue;'>$otp</h3>
            <p>Please use this code to verify your email. It will expire in 5 minutes.</p>
        ";

        $mail->send();
        echo "OTP has been sent to $email";
        header('location:verify.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
