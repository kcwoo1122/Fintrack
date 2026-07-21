<?php
    include("config.php");
    $errmsg='';


    if(isset($_POST['submit'])){
        $email=$_POST['email'];
        $password=$_POST['password'];

        if(empty($email)||empty($password)){
            $errmsg="All fields are required";
        }
        else{
            $checkuser=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
            $numrows=mysqli_num_rows($checkuser);
            if($numrows>0){
                $checkpassword=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");
                $numrowsuser=mysqli_num_rows($checkpassword);
                if($numrowsuser==1){
                    $userInfo=mysqli_fetch_assoc($checkpassword);
                    if($userInfo['role']=='user'){
                        session_start();
                        $_SESSION['userID']=$userInfo['userID'];
                        $_SESSION['name']=$userInfo['name'];
                        $_SESSION['role']=$userInfo['role'];
                        header("Location:user/home.php");
                        exit();
                    }
                    if($userInfo['role']=='moderator'){
                        session_start();
                        $_SESSION['userID']=$userInfo['userID'];
                        $_SESSION['name']=$userInfo['name'];
                        $_SESSION['role']=$userInfo['role'];
                        header("Location:contentMod/home.php");
                        exit();
                    }
                    if($userInfo['role']=='admin'){
                        session_start();
                        $_SESSION['userID']=$userInfo['userID'];
                        $_SESSION['name']=$userInfo['name'];
                        $_SESSION['role']=$userInfo['role'];
                        header("Location:admin/home.php");
                        exit();
                    }

                }
                else{
                    $errmsg="Incorrect password";
                }
            }
            else{
                $errmsg="User not registered";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <div class="signupBox">
        <img class="logo" src="images/fintracklogo.png" alt="">
        <h2 class="title">Login</h2>
        <form class="fields" method="post">
            <input class="email" placeholder="Email" name="email" type="text"><br>
            <input class="password" placeholder="Password" name="password" type="password"><br>
            <input name="submit" class="submit" type="submit" value="Login">
        </form>
        <div class="errmsg">
            <?php echo $errmsg;?>
        </div>
        <p onclick="window.location.href='user/signup.php'" class="hyperlinks">Create Account</p>
    </div>
</body>
</html>