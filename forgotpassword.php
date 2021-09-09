<?php

require("connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception; 

function sendmail($email,$reset_token)
{
    require ("PHPMailer\PHPMailer.php");
    require ("PHPMailer\SMTP.php");
    require ("PHPMailer\Exception.php");
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'pnwteamfortest@gmail.com';                     //SMTP username
        $mail->Password   = 'vaibhab2';                                 //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('pnwteamfortest@gmail.com', 'pnw team');
        $mail->addAddress($email);     //Add a recipient
        
    
        
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'password reset link';
        $mail->Body    = "click the link to reset your password <br>
        <a href='http://localhost:8012/pnw/updatepassword.php?email=$email&reset_token=$reset_token'>reset password</a>
        ";
    
        $mail->send();
        return true;
        } catch (Exception $e) {
        return false;
        }

}

if(isset($_POST['send-reset']))
{
    $query="SELECT * FROM `registered_user` WHERE `email`='$_POST[email]'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $reset_token=bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/kolkata');
            $date=date("Y-m-d");
            $query="UPDATE `registered_user` SET `resettoken`='$reset_token',`resettokenexpired`='$date' WHERE `email`='$_POST[email]'";
            if(mysqli_query($con,$query) && sendmail($_POST['email'],$reset_token))
            {
                echo"
                <script>
                alert('reset link sent');
                window.location.href='index.php';
                </script>
                ";
            }
            else
            {
                echo"
            <script>
            alert('sever down');
            window.location.href='index.php';
            </script>
            ";  
            }
        }
        else
        {
            echo"
            <script>
            alert('invalid email entered');
            window.location.href='index.php';
            </script>
            ";
        }
    }
    else
    {
        echo"
        <script>
        alert('cannot run query');
        window.location.href='index.php';
        </script>
        ";
    }
}



?>