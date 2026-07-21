<?php
    session_start();
    $name=$_SESSION['name'];
    $userID=$_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <img class="logo" src="../images/fintracklogo.png" alt="">
        <div onclick="window.location.href='home.php'" class="shortcut" id="dashboard"><i class="fa-solid fa-house"></i>&nbsp&nbsp&nbspDashboard</div>
        <div onclick="window.location.href='videos.php'" class="shortcut"  id="income"><i class="fa-brands fa-youtube"></i>&nbsp&nbsp&nbspVideos</div>
        <div onclick="window.location.href='quizzes.php'" class="shortcut"  id="expenses"><i class="fa-solid fa-book-open"></i>&nbsp&nbsp&nbspQuizzes</div>
        <div onclick="window.location.href='settings.php'" class="shortcut"  id="settings"><i class="fa-solid fa-gear"></i>&nbsp&nbsp&nbspSettings</div>
    </div>
</body>
<script src="script.js"></script>
</html>