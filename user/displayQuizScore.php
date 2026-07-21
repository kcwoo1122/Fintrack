<?php
    include("../config.php");
    include("sidebar.php");
    $quizID=$_GET['quizID'];
    $score=$_GET['score'];
    $total=$_GET['total'];
    $percentage=($score/$total)*100;

    $getQuestions=mysqli_query($conn,"SELECT * FROM questions WHERE quizID=$quizID");
    mysqli_query($conn,"INSERT INTO quizlog(userID,quizID,score) VALUES($userID,$quizID,$percentage)")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/completeQuiz.css">

    <title>Document</title>
</head>
<body>
    <div class="scoreBox">
        <p>Your score is:</p>
        <div class="percentage"><?php echo $percentage;?>%</div>
        <div class="score">You scored <?php echo $score?> out of <?php echo $total?> right</div>
    </div>
    <h1 class="correctAnswers">Correct Answers</h1>
    <div class="reviewQuestions">
        <?php while($rowQuestions=mysqli_fetch_assoc($getQuestions)):?>
            <div class="questionBox">
                <div class="quizQuestion">Question: <?php echo $rowQuestions['question'];?></div>
                <div class="quizAnswer">Answer: <?php echo $rowQuestions['answer'];?></div>
            </div>
        <?php endwhile;?>
    </div>
</body>

</html>