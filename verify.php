<?php
require("connection.php");

if(isset($_GET['email']) && isset($_GET['vcode']))
{
    $query="SELECT * FROM `registered_user` WHERE `email`='$_GET[email]' AND `verification_code`='$_GET[vcode]'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['verified']==0)
            {
                $update="UPDATE `registered_user` SET `verified`='1' WHERE `email`='$result_fetch[email]'";
                if(mysqli_query($con,$update))
                {
                    echo"
                <script>
                alert('email verification successful');
                window.location.href='index.php';
                </script>
                "; 
                
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
            else
            {
                echo"
                <script>
                alert('user is already verified');
                window.location.href='index.php';
                </script>
                "; 
            }
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
