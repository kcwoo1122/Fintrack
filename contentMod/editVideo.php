<?php
    include("../config.php");
    include("sidebar.php");

    $errmsg="";
    $videoID=$_GET['videoID'];
    $getVideo=mysqli_query($conn,"SELECT * FROM video WHERE videoID=$videoID");

    
    if(isset($_POST['submit'])){
        $title=$_POST['title'];
        $url=$_POST['url'];
        $category=$_POST['category'];
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        $videoUrl = $params['v'];

        if(empty($title)||empty($url)||empty($category)){
            $errmsg='All fields are required';
        }
        else{
            mysqli_query($conn,"UPDATE video SET title='$title',videoUrl='$videoUrl',category='$category' WHERE videoID=$videoID");
            header("Location:videos.php");
            exit();
        }
    }

    if(isset($_POST['delete'])){
        mysqli_query($conn,"DELETE FROM video WHERE videoID=$videoID");
        header("Location:videos.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/add.css">

    <title>Document</title>
</head>
<body>
    <div class="addIncome">
        <h1 class="mainTitle">Edit Video</h1>
        <div class="addGrid">
            <?php while($rowVideos=mysqli_fetch_assoc($getVideo)):?>
                <form class="grid" method="post">
                    <div class="addTitle">
                        <p>Title</p>
                        <input value="<?php echo $rowVideos['title']?>" class="title" name="title" type="text">
                    </div>

                    <div class="addAmount">
                        <p>URL</p>
                        <input value="https://www.youtube.com/watch?v=<?php echo $rowVideos['videoUrl'];?>" class="title" name="url" type="text">
                    </div>

                    <div class="addCategory">
                        <p>Category</p>
                        <select class="category" name="category" id="category">
                            <option selected value="<?php echo $rowVideos['category'];?>"><?php echo $rowVideos['category']?></option>
                            <option value="Budgeting">Budgeting</option>
                            <option value="Investing">Investing</option>
                            <option value="Debt Management">Debt Management</option>
                            <option value="Saving Money">Saving Money</option>
                            <option value="Taxes">Taxes</option>
                            <option value="Financial Literacy">Financial Literacy</option>
                            <option value="Student Finance">Student Finance</option>
                            <option value="Career & Income">Career & Income</option>
                            <option value="Scam Awareness & Safety">Scam Awareness & Safety</option>
                        </select>
                        <p class="errmsg"><?php echo $errmsg;?></p>
                    </div>

                
                    <div class="buttons">
                        <input class="submit" name="submit" value="submit" type="submit">
                        <input class="delete" name="delete" value="delete" type="submit">
                    </div>
                </form>     
            <?php endwhile;?>
        </div>
    </div>
</body>
</html>