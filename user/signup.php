<?php
    include("../config.php");
    $errmsg='';
    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $confirmPassword=$_POST['confirmPassword'];

        if(empty($name)||empty($email)||empty($password)||empty($confirmPassword)){
            $errmsg="All fields must be entered";
        }
        else{
            if($password==$confirmPassword){
                $checkUser=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
                $numrows=mysqli_num_rows($checkUser);

                if($numrows>0){
                    $errmsg="Email is already registered";
                }
                else{
                    mysqli_query($conn,"INSERT INTO users(name,email,password,role) VALUES('$name','$email','$password','user')");
                    header("Location:../index.php");
                    exit();
                }
            }
            else{
                $errmsg="Passwords dont match";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signup.css">
    <title>Document</title>
</head>
<body>
    <div class="signupBox">
        <img class="logo" src="../images/fintracklogo.png" alt="">
        <h2 class="title">Signup</h2>
        <form class="fields" method="post">
            <input class="username" placeholder="Name" name="name" type="text"><br>
            <input class="email" placeholder="Email" name="email" type="text"><br>
            <input class="password" placeholder="Password" name="password" type="password"><br>
            <input class="password" placeholder="Confirm Password" name="confirmPassword" type="password"><br>
            <input name="submit" class="submit" type="submit" value="Signup">
        </form>
        <div class="errmsg">
            <?php echo $errmsg;?>
        </div>
        <p onclick="window.location.href='../index.php'" class="hyperlinks">Already a user? log in</p>
        <p onclick="window.location.href='../contentMod/signup.php'">Or signup as a moderator</p>
    </div>
</body>
</html>