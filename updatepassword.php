<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>password update</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: poppins;
            }
            form
            {   position: absolute;
                top:50%;
                left:50%;
                transform: translate(-50%,-50%);
                background-color: #f0f0f0;
                width: 350px;
                border-radius: 5px;
                padding: 20px 25px;
            }
            form h3
            {
                margin-bottom: 15px;
                color:#30475e;
            }
            form input
            {
                width: 100%;
                margin-bottom: 20px;
                background-color: transparent;
                border: none;
                border-bottom: 2px solid #30475e;
                border-radius: 0;
                padding: 5px 0;
                font-weight: 500px;
                outline: none;
                font-size: 15px;
            }
            form button
            {
                font-weight: 500px;
                font-style: 15px;
                color: white;
                background-color: #30475e;
                padding: 5px 10px;
                border: none;
                outline: none;
                cursor: pointer;
            }
    </style>
</head>
<body>
    
<?php

require("connection.php");

if(isset($_GET['email']) && isset($_GET['reset_token']))
{
    date_default_timezone_set('Asia/kolkata');
    $date=date("Y-m-d");
    $query="SELECT * FROM `registered_user` WHERE `email`='$_GET[email]' AND `resettoken`='$_GET[reset_token]' AND `resettokenexpired`='$date'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            echo"
                <form method='POST'>
                    <h3>create new password</h3>
                    <input type='password' placeholder='new password' name='password'>
                    <button type='submit' name='updatepassword'>update password</button>
                    <input type='hidden' name='email' value='$_GET[email]'>
                </form>
            ";
        }
        else
        {
            echo"
            <script>
            alert('invalid or expired link');
            window.location.href='index.php';
            </script>
            ";
        }
    }
    else
    {
        echo"
        <script>
        alert('server down');
        window.location.href='index.php';
        </script>
        ";
    }


}

?>

<?php

    if(isset($_POST['updatepassword']))
    {
        $pass=password_hash($_POST['password'],PASSWORD_BCRYPT);
        $update="UPDATE `registered_user` SET `password`='$pass',`resettoken`=NULL,`resettokenexpired`=NULL WHERE `email`='$_POST[email]'";
        if(mysqli_query($con,$update))
        {
            echo"
            <script>
            alert('password updated successfully');
            window.location.href='index.php';
            </script>
            ";
        }
        else
        {
            echo"
            <script>
            alert('serdfsdfsdown');
            window.location.href='index.php';
            </script>
            ";
        }
    
    }


?>
</body>
</html>