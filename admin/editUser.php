<?php
    include("../config.php");
    include("sidebar.php");
    $errmsg='';
    $userID=$_GET['userID'];

    $rowUser=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE userID=$userID"));

    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        if(empty($name)||empty($email)||empty($password)){
            $errmsg='All fields are required';
        }
        else{
            mysqli_query($conn,"UPDATE users SET name='$name',email='$email',password='$password' WHERE userID=$userID");
            header("Location:manageUsers.php");
            exit();
        }
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/manageUser.css">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <div class="editSection">
            <div class="editName">
                <h2>Name</h2>
                <input value="<?php echo $rowUser['name'];?>" name="name" class="name" type="text">
            </div>
            <div class="editEmail">
                <h2>Username</h2>
                <input value="<?php echo $rowUser['email'];?>" name="email" class="email" type="text">
            </div>
            <div class="editPassword">
                <h2>Password</h2>
                <input value="<?php echo $rowUser['password'];?>" class="password" type="password" name="password" id="">
            </div>
            <p class="errmsg"><?php echo $errmsg;?></p>
            <button name="submit" class="submitForm" type="submit">submit</button>
        </div>
    </form>
</body>

</html>