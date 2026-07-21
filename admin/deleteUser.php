<?php
    include("../config.php");
    include("sidebar.php");

    $userID=$_GET['userID'];
    mysqli_query($conn,"DELETE FROM users WHERE userID=$userID");
    header("Location:manageUsers.php");
    exit();


?>