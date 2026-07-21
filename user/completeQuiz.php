<?php
    include("../config.php");
    include("sidebar.php");

    $quizID=$_GET['quizID'];
    $getQuiz=mysqli_query($conn,"SELECT quiz.title,questions.question,questions.answer,questions.questionID FROM quiz INNER JOIN questions ON quiz.quizID=questions.quizID WHERE quiz.quizID=$quizID");
    $counter=0;
    $score=0;
    $questions = [];
    while($rowQuiz = mysqli_fetch_assoc($getQuiz)) {
        $questions[] = $rowQuiz;
    }

    if (isset($_POST['submit'])) {

        $answers = json_decode($_POST['answers'], true);

        for ($i = 0; $i < count($questions); $i++) {

            $correct = strtolower(trim($questions[$i]['answer']));
            $user = strtolower(trim($answers[$i] ?? ''));

            if ($user === $correct) {
                $score++;
            }
        }
        header("Location:displayQuizScore.php?quizID=$quizID&score=$score&total=".count($questions));
    }

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
    <h1 class="quizTitle" id="title"></h1>
    <form method="post" id="quizForm">
        <div class="outerBox">
            <div class="previous" onclick="prevQuestion()"><</div>

            <div class="quizBox">
                <div class="question" id="question"></div>
                <input type="text" class="answer" id="answerBox">
            </div>

            <div class="next" onclick="nextQuestion()">></div>
        </div>
        <input type="hidden" name="answers" id="answers">
        <input type="submit" class="submit" name="submit" value="submit">
    </form>

</body>
<script>
    let userAnswers = [];
    let questions = <?php echo json_encode($questions); ?>;
    let currentIndex = 0;

    function saveAnswer() {
        userAnswers[currentIndex] =
            document.getElementById("answerBox").value;
    }

    function showQuestion(index) {

        document.getElementById("title").innerText =
            questions[index].title;

        document.getElementById("question").innerText =
            (index + 1) + ". " + questions[index].question;

        document.getElementById("answerBox").value =
            userAnswers[index] || "";

        if (index === questions.length - 1) {
            document.querySelector(".submit").style.display = "block";
        } else {
            document.querySelector(".submit").style.display = "none";
        }
    }

    function nextQuestion() {
        saveAnswer();

        if (currentIndex < questions.length - 1) {
            currentIndex++;
            showQuestion(currentIndex);
        }
    }

    function prevQuestion() {
        saveAnswer();

        if (currentIndex > 0) {
            currentIndex--;
            showQuestion(currentIndex);
        }
    }

    document.getElementById("quizForm").addEventListener("submit", function () {
        saveAnswer();
        document.getElementById("answers").value =
            JSON.stringify(userAnswers);
    });

    showQuestion(currentIndex);
</script>
</html>