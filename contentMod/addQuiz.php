<?php
    include("../config.php");
    include("sidebar.php");

    $errmsg="";

    if(isset($_POST['submit'])){
        $title=$_POST['title'];
        $category=$_POST['category'];
        $description=$_POST['description'];
        $question=$_POST['question'];
        $answer=$_POST['answer'];

        if(empty($title)||empty($category)||empty($question)||empty($answer)||empty($description)){
            $errmsg='All fields are required';
        }
        else{
            mysqli_query($conn,"INSERT INTO quiz(userID,category,description,title) VALUES($userID,'$category','$description','$title')");
            $quizID = mysqli_insert_id($conn);

            for($i=0;$i<count($question);$i++){
                $q=mysqli_real_escape_string($conn, $question[$i]);
                $a = mysqli_real_escape_string($conn, strtolower(trim($answer[$i])));
                mysqli_query($conn,"INSERT INTO questions(quizID,question,answer) VALUES($quizID,'$q','$a')");

            }
            header("Location:quizzes.php");
        }
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/quiz.css">
    <title>Document</title>
</head>
<body>
    <h1 class="mainTitle">Add Quiz</h1>
    <form method="post">
        <div class="titleCategory">
            <div>
                <div>Title</div>
                <input class="title" name="title" type="text">
            </div>
        
            <div>
                <div>Category</div>
                <select class="category" name="category" id="category">
                    <option value="BUDGETING">Budgeting</option>
                    <option value="INVESTING">Investing</option>
                    <option value="DEBT_MANAGEMENT">Debt Management</option>
                    <option value="SAVING_MONEY">Saving Money</option>
                    <option value="TAXES">Taxes</option>
                    <option value="FINANCIAL_LITERACY">Financial Literacy</option>
                    <option value="STUDENT_FINANCE">Student Finance</option>
                    <option value="CAREER_INCOME">Career & Income</option>
                    <option value="SCAM_AWARENESS">Scam Awareness & Safety</option>
                </select>
            </div>
        </div>
        <div class="quizDescription">
            <div>Description</div>
            <textarea class="description" name="description" type="text"></textarea>
        </div>
        <h1 class="addQuestions">Add Questions</h1>
        <div class="quizContainer">
            <div class="questionBox">
                <div>Question</div>
                <input class="question" type="text" name="question[]">
            </div>
            <div class="answerBox">
                <div>Answer</div>
                <input class="question" type="text" name="answer[]">
            </div>
        </div>
        <div class="addQuestion">
            <i class="fa-solid fa-plus"></i>
        </div>
        
        <input value="submit" name="submit" class="submit" type="submit">
    </form>
    <div class="errmsg">
        <?php echo $errmsg;?>
    </div>
</body>
<script>
    const addQuestion=document.querySelector(".addQuestion")
    const quizContainer=document.querySelector(".quizContainer")

    addQuestion.addEventListener("click",function(){
        const newQuestion = document.createElement("div");

        newQuestion.classList.add("quizItem");

        newQuestion.innerHTML = `
            <div class="questionBox">
                <div>Question</div>
                <input class="question" type="text" name="question[]">
            </div>
            <div class="answerBox">
                <div>Answer</div>
                <input class="question" type="text" name="answer[]">
            </div>
            <div class="delete">
                <div>Delete</div>
            </div>
        `;

        quizContainer.appendChild(newQuestion);


        
    })
    quizContainer.addEventListener("click", function (e) {
        if (e.target.classList.contains("delete")) {
            e.target.parentElement.remove();
        }
    });
</script>
</html>