<?php
    include("../config.php");
    include("sidebar.php");
    $getQuizzes=mysqli_query($conn,"SELECT quiz.quizID, quiz.title, quiz.category FROM quiz LEFT JOIN quizlog ON quiz.quizID=quizlog.quizID LIMIT 3");
    $getVideos=mysqli_query($conn,"SELECT * FROM video LIMIT 3");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/literacy.css">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <h1>Quizzes</h1>
        <p onclick="window.location.href='literacyQuizzes.php'">View More ></p>
    </div>
    
    <div class="quiz">
        <?php if(mysqli_num_rows($getQuizzes)==0):?>
                <div class="noVideos">No Quizzes Added</div>
        <?php else:?>
            <?php while($rowQuizzes=mysqli_fetch_assoc($getQuizzes)):?>
                <div onclick="window.location.href='quizInfo.php?quizID=<?php echo $rowQuizzes['quizID'];?>'" class="quizContent">
                    <div class="quizThumbnail"><img height="150" src="../images/<?php echo $rowQuizzes['category'].".svg";?>"></div>
                    <div class="title"><?php echo $rowQuizzes['title'];?></div>
                    <div class="buttons">
                        <div class="category"><?php echo $rowQuizzes['category'];?></div>     
                        <button onclick="window.location.href='completeQuiz.php?quizID=<?php echo $rowQuizzes['quizID'];?>'" class="completeQuiz" name="completeQuiz">Complete Quiz</button>
                    </div>             
                </div>
            <?php endwhile;?>
        <?php endif;?>
    </div>

    <div class="header">
        <h1>Videos</h1>
        <p onclick="window.location.href='literacyVideos.php'">View More ></p>
    </div>

    <div class="videos">
        <?php if(mysqli_num_rows($getVideos)==0):?>
                <div class="noVideos">No videos Uploaded</div>
        <?php else:?>
            <?php while($rowVideos=mysqli_fetch_assoc($getVideos)):?>
                <div class="video">
                    <iframe src="https://www.youtube.com/embed/<?php echo $rowVideos['videoUrl'];?>" allowfullscreen class="thumbnail"></iframe>
                    <div class="title"><?php echo $rowVideos['title'];?></div>
                    <div class="videoButtons">
                        <div class="category"><?php echo $rowVideos['category'];?></div>

                    </div>
                    
                </div>
            <?php endwhile;?>
        <?php endif;?>
    </div>
</body>

</html>