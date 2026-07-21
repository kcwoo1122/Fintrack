<?php
    include("../config.php");
    include("sidebar.php");
    $quizID=$_GET['quizID'];
    $getQuizzes=mysqli_query($conn,"SELECT * FROM quiz WHERE quizID=$quizID");
    $totalQuestions=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(questionID) AS total FROM questions WHERE quizID=$quizID"));


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/quizInfo.css">
    <title>Document</title>
</head>
<body>
    <div class="quizInfo">
        <?php while($rowQuizzes=mysqli_fetch_assoc($getQuizzes)):?>
            <div class="quizThumbnail"><img height="200" src="../images/<?php echo $rowQuizzes['category'].".svg";?>"></div>
            <div class="top">
                <div class="title"><?php echo $rowQuizzes['title'];?></div>
                <div class="category"><?php echo $rowQuizzes['category'];?></div>
            </div>
            <div class="description">
                <?php echo $rowQuizzes['description'];?>
            </div>
            <div class="bottom">
                <div onclick="window.location.href='completeQuiz.php?quizID=<?php echo $rowQuizzes['quizID'];?>'" class="completeQuiz">
                    Complete Quiz
                </div>
                <div class="totalQuestions"><?php echo $totalQuestions['total'];?> questions</div>
            </div>

        <?php endwhile;?>
                        
    </div>
</body>

</html>