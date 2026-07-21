<?php
    include("../config.php");
    include("sidebar.php");

    $errmsg="";

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

            mysqli_query($conn,"INSERT INTO video(title,videoUrl,category,userID) VALUES('$title','$videoUrl','$category',$userID)");
            header("Location:home.php");
            exit();
        }
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
        <h1 class="mainTitle">Add New Video</h1>
        <div class="addGrid">
            <form class="grid" method="post">
                <div class="addTitle">
                    <p>Title</p>
                    <input class="title" name="title" type="text">
                </div>

                <div class="addAmount">
                    <p>URL</p>
                    <input class="title" name="url" type="text">
                </div>

                <div class="addCategory">
                    <p>Category</p>
                    <select class="category" name="category" id="category">
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

            
                <input class="submit" name="submit" value="submit" type="submit">
            </form>     
            
        </div>
    </div>
</body>
</html>