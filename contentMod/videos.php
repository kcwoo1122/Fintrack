<?php
    include("../config.php");
    include("sidebar.php");

    $getVideos=mysqli_query($conn,"SELECT * FROM video WHERE userID=$userID");

    if(isset($_POST['edit'])){
        $videoID=$_POST['edit'];
        header("Location:editVideo.php?videoID=$videoID");
    }

    if(isset($_POST['search'])){
        $title=$_POST['searchBar'];
        $getVideos=mysqli_query($conn,"SELECT * FROM video WHERE userID=$userID AND title='$title'");
    }

    if(isset($_POST['categorySearch'])){
        $category=$_POST['category'];
        $getVideos=mysqli_query($conn,"SELECT * FROM video WHERE userID=$userID AND category='$category'");
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
    <h2 class="pageTitle">Search Your Videos</h2>
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
        <?php if(mysqli_num_rows($getVideos)==0):?>
                <div class="noVideos">No videos Uploaded</div>
        <?php else:?>
            <?php while($rowVideos=mysqli_fetch_assoc($getVideos)):?>
                <div class="video">
                    <iframe src="https://www.youtube.com/embed/<?php echo $rowVideos['videoUrl'];?>" allowfullscreen class="thumbnail"></iframe>
                    <div class="title"><?php echo $rowVideos['title'];?></div>
                    <div class="videoButtons">
                        <div class="category"><?php echo $rowVideos['category'];?></div>
                        <div class="buttons">
                            <form method="post">
                                <button value="<?php echo $rowVideos['videoID'];?>" name="edit" class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                            </form>

                        </div>
                    </div>
                    
                </div>
            <?php endwhile;?>
        <?php endif;?>
    </div>

    <div onclick="window.location.href='addVideo.php'" class="addVideo"><i class="fa-solid fa-plus"></i> Add Video</div>
</body>
</html>