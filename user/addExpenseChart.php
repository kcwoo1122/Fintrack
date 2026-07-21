<?php
    include("../config.php");
    include("sidebar.php");

    $getCategories=mysqli_query($conn,"SELECT DISTINCT category FROM expense WHERE userID=$userID");
    $errmsg='';

    if(isset($_POST['submit'])){
        $chartType=$_POST['chartType'];
        $category=$_POST['category'];
        $startDate=$_POST['startDate'];
        $endDate=$_POST['endDate'];

        if(empty($startDate)||empty($endDate)){
            $errmsg="All fields are required";
        }
        else{
            mysqli_query($conn,"INSERT INTO expensechart(chartType,startDate,endDate,userID,category) VALUES('$chartType','$startDate','$endDate',$userID,'$category')");
            header("Location:expense.php");
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
        <h1 class="mainTitle">Add New Chart</h1>
        <div class="addGrid">
            <form class="grid" method="post">
                <div class="addTitle">
                    <p>Chart Type</p>
                    <select class="title" name="chartType" id="chartType">
                        <option value="line">Line</option>
                        <option value="bar">bar</option>
                        <option value="doughnut">Doughnut</option>
                        <option value="pie">Pie</option>
                    </select>
                </div>

                <div class="addAmount">
                    <p>Category</p>
                    <select class="amount" name="category" id="">
                        <option value="All">All</option>
                        <?php while($rowCategory=mysqli_fetch_assoc($getCategories)):?>
                            <option value="<?php echo $rowCategory['category']?>"><?php echo $rowCategory['category']?></option>
                        <?php endwhile;?>
                    </select>

                </div>

                <div class="addDate">
                    <p>Start Date</p>
                    <input class="date" name="startDate" type="date">
                </div>
                
                <div class="addDate">
                    <p>End Date</p>
                    <input class="date" name="endDate" type="date">
                </div>

                <input class="submit" name="submit" value="submit" type="submit">
            </form>     
            <p class="errmsg"><?php echo $errmsg;?></p>
        </div>
    </div>
</body>
</html>