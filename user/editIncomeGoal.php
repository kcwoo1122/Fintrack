<?php
    include("../config.php");
    include("sidebar.php");
    $goalID=$_GET['goalID'];
    $getGoal=mysqli_query($conn,"SELECT * FROM goal WHERE goalID=$goalID");
    $getIncomes=mysqli_query($conn,"SELECT * FROM income WHERE userID=$userID");
    $getSelectedCategory=mysqli_query($conn,"SELECT income.title FROM goal INNER JOIN income ON goal.originalID=income.incomeID WHERE goal.userID=$userID AND goalID=$goalID");
    $errmsg='';

    if(isset($_POST['submit'])){
        $title=$_POST['title'];
        $originalID=$_POST['originalID'];
        $amount=$_POST['amount'];

        if(empty($title)||empty($amount)){
            $errmsg="All fields are required";
        }
        else{
            mysqli_query($conn,"UPDATE goal SET title='$title',originalID=$originalID,amount=$amount WHERE goalID=$goalID");
            header("Location:goals.php");
            exit();
        }
        
    }

    if(isset($_POST['delete'])){
        mysqli_query($conn,"DELETE FROM goal WHERE goalID=$goalID");
        header("Location:goals.php");
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
        <h1 class="mainTitle">Edit Goal</h1>
        <div class="addGrid">
            <?php while($rowGoal=mysqli_fetch_assoc($getGoal)):?>
                <form class="grid" method="post">
                    <div class="addTitle">
                        <p>Title</p>
                        <input value="<?php echo $rowGoal['title'];?>" class="title" name="title" type="text">
                    </div>

                    <div class="addAmount">
                        <p>Category</p>
                        <select class="amount" name="originalID" id="">
                            <option value="Total Income">Total Income</option>
                            <?php while($rowIncome=mysqli_fetch_assoc($getIncomes)):?>
                                <option value="<?php echo $rowIncome['incomeID']?>"><?php echo $rowIncome['title']?></option>
                            <?php endwhile;?>
                            <option selected value=<?php echo $rowGoal['originalID'];?>>
                                <?php while($rowCategory=mysqli_fetch_assoc($getSelectedCategory)):?>
                                    <?php echo $rowCategory['title'];?>
                                <?php endwhile;?>
                            </option>
                        </select>

                    </div>

                    <div class="addDate">
                        <p>Amount</p>
                        <input value="<?php echo $rowGoal['amount'];?>" class="amount" name="amount" type="number" step="0.01" min="0">
                    </div>
                    
                    <div class="addDate"></div>
                    <div class="buttons">
                        <input class="submit" name="submit" value="submit" type="submit">
                        <input class="delete" name="delete" value="delete" type="submit">
                    </div>
                </form>     
            <?php endwhile;?>
            <p class="errmsg"><?php echo $errmsg;?></p>
        </div>
    </div>
</body>
</html>