<?php
    include("../config.php");
    include("sidebar.php");

    $getQuizzes=mysqli_query($conn,"SELECT * FROM quiz WHERE userID=$userID");

    if(isset($_POST['edit'])){
        $quizID=$_POST['edit'];
        header("Location:editQuiz.php?quizID=$quizID");
    }

    if(isset($_POST['delete'])){
        $quizID=$_POST['delete'];
        mysqli_query($conn,"DELETE FROM quiz WHERE quizID=$quizID");
        header("Location:quizzes.php");
    }

    if(isset($_POST['search'])){
        $title=$_POST['searchBar'];
        $getQuizzes=mysqli_query($conn,"SELECT * FROM quiz WHERE userID=$userID AND title='$title'");
    }

    if(isset($_POST['categorySearch'])){
        $category=$_POST['category'];
        $getQuizzes=mysqli_query($conn,"SELECT * FROM quiz WHERE userID=$userID AND category='$category'");
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/video.css">

    <title>Document</title>
</head>
<body>
    <h2 class="pageTitle">Search Your Quizzes</h2>
    <form method="post">
        <div class="top">
            <div><input name="searchBar" class="searchBar" type="text"></div>
            <button name="search" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
            <div class="filter">
                <select name="category" id="category">
                    <option disabled selected>Category</option>
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
            <button name="categorySearch" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>
    <div class="bottom">
        <?php if(mysqli_num_rows($getQuizzes)==0):?>
                <div class="noVideos">No Quizzes Added</div>
        <?php else:?>
            <?php while($rowQuizzes=mysqli_fetch_assoc($getQuizzes)):?>
                <div class="video">
                    <div class="quizThumbnail"><img height="150" src="../images/<?php echo $rowQuizzes['category'].".svg";?>"></div>
                    <div class="title"><?php echo $rowQuizzes['title'];?></div>
                    <div class="videoButtons">
                        <div class="category"><?php echo $rowQuizzes['category'];?></div>
                        <div class="buttons">
                            <form method="post">
                                <button value="<?php echo $rowQuizzes['quizID'];?>" name="edit" class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button value="<?php echo $rowQuizzes['quizID'];?>" name="delete" class="delete"><i class="fa-solid fa-trash"></i></button>
                            </form>

                        </div>
                    </div>
                    
                </div>
            <?php endwhile;?>
        <?php endif;?>
    </div>

    <div onclick="window.location.href='addQuiz.php'" class="addVideo"><i class="fa-solid fa-plus"></i> Add Quiz</div>
</body>
</html>