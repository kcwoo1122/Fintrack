<?php
    include("../config.php");
    $errmsg='';
    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $reason=$_POST['reason'];

        if(empty($name)||empty($email)||empty($password)||empty($reason)){
            $errmsg="All fields must be entered";
        }
        else{
            $checkUser=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
            $numrows=mysqli_num_rows($checkUser);
            if($numrows>0){
                $errmsg="Email is already registered";
            }
            else{
                mysqli_query($conn,"INSERT INTO request(name,email,password,reason) VALUES('$name','$email','$password','$reason')");
                header("Location:../index.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/accountRequest.css">
    <title>Document</title>
</head>
<body>
    <div class="signupBox">
        <img class="logo" src="../images/fintracklogo.png" alt="">
        <h2 class="title">Account Request</h2>
        <form class="fields" method="post">
            <input class="username" placeholder="Name" name="name" type="text"><br>
            <input class="email" placeholder="Email" name="email" type="text"><br>
            <input class="password" placeholder="Password" name="password" type="password"><br>
            <textarea class="reason" name="reason" id="">Enter Reason</textarea>
            <input name="submit" class="submit" type="submit" value="submit">
        </form>
        <div class="errmsg">
            <?php echo $errmsg;?>
        </div>
        <p onclick="window.location.href='../index.php'" class="hyperlinks">Already a user? log in</p>
    </div>
</body>
</html>