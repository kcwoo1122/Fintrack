<?php
    include("../config.php");
    include("sidebar.php");
    $errmsg="";
    $getUser=mysqli_query($conn,"SELECT * FROM users where userID=$userID");
    $rowUser=mysqli_fetch_assoc($getUser);

    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location:../index.php");
        exit();
    }

    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        if(empty($name)||empty($email)||empty($password)){
            $errmsg='All fields are required';
        }
        else{
            mysqli_query($conn,"UPDATE users SET name='$name',email='$email',password='$password' WHERE userID=$userID");
            session_unset();
            session_destroy();
            header("Location:../index.php");
            exit();
        }
    }

    if(isset($_POST['delete'])){
        $password=$_POST['deletePassword'];

        if(empty($password)){
            $errmsg='All fields are required';
        }
        else{
            $checkPassword=mysqli_query($conn, "SELECT password FROM users WHERE userID=$userID");
            $rowPassword=mysqli_fetch_assoc($checkPassword);

            if($rowPassword && $password==$rowPassword['password']){
                mysqli_query($conn,"DELETE FROM users WHERE userID=$userID");
                session_unset();
                session_destroy();
                header("Location:../index.php");
                exit();
            }
            else{
                $errmsg='Password is incorrect';
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/settings.css">

    <title>Document</title>
</head>
<body>
    <form method="post">
        <div class="top">
            <h1 class="title">Settings</h1>
            <button name="logout" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        </div>
    </form>

    <div class="settingsBox">
        <div class="left">
            <img width=140 class="settingsLogo" src="../images/fintracklogo.png" alt="">
            <div class="about">About</div>
            <div class="editAccount">Edit Account</div>
            <div class="deleteAccount">Delete Account</div>
        </div>
        <div class="right">
            <div class="aboutSection active">
                <div class="aboutFinTrack">
                    <div>
                        <h2>About FinTrack</h2>
                        <p>FinTrack is a personal finance tracker that helps users monitor their income and expenses in one place. It also provides financial education resources to improve budgeting, saving, and money management skills.</p>
                    </div>
                    
                </div>
                <div class="ourMission">
                    <div>
                        <h2>Our Mission</h2>
                        <p>FinTrack is a personal finance tracker that helps users monitor their income and expenses in one place. It also provides financial education resources to improve budgeting, saving, and money management skills.</p>
                    </div>
                </div>
            </div>
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
                    <button name="submit" class="submit" type="submit">submit</button>
                </div>
                <div class="deleteAccountSection">
                    <div class="editPassword">
                        <h2>Password</h2>
                        <input class="deletePassword" type="password" name="deletePassword">
                    </div>
                    <div class="deleteWarning">
                        <h3>Deletion Warning</h3>
                        <p>Deleting your account permanently removes all data and access, and cannot be undone.</p>
                    </div>
                    <p class="errmsg"><?php echo $errmsg;?></p>
                    <button name="delete" class="delete" type="submit">delete</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    const sections = {
        about:  document.querySelector('.aboutSection'),
        edit:   document.querySelector('.editSection'),
        delete: document.querySelector('.deleteAccountSection')
    };

    function showSection(tab) {
        // Hide all sections
        Object.values(sections).forEach(s => s.classList.remove('active'));
        // Show the selected one
        sections[tab].classList.add('active');
    }

    document.querySelector('.about').addEventListener('click', () => showSection('about'));
    document.querySelector('.editAccount').addEventListener('click', () => showSection('edit'));
    document.querySelector('.deleteAccount').addEventListener('click', () => showSection('delete'));
</script>
</html>