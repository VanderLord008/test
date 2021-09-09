<?php

   
    $con=new mysqli("localhost","root","","pnw");
    if(mysqli_connect_error()){
        echo"<script>alert('cannot connect to the database');</script>";
        exit();
      }
  
?>