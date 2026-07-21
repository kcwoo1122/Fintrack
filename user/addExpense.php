<?php
    include("../config.php");
    include("sidebar.php");

    $errmsg="";

    if(isset($_POST['submit'])){
        $title=$_POST['title'];
        $amount=$_POST['amount'];
        $date=$_POST['date'];
        $category=$_POST['category'];
        $isRecurring=isset($_POST['isRecurring']) ? 'yes':'no';

        if(empty($title)||empty($amount)||empty($date)){
            $errmsg='All fields are required';
        }
        else{
            mysqli_query($conn,"INSERT INTO expense(amount,title,date,recurring,userID,category) VALUES($amount,'$title','$date','$isRecurring','$userID','$category')");
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
        <h1 class="mainTitle">Add New Expense</h1>
        <div class="addGrid">
            <form class="grid" method="post">
                <div class="addTitle">
                    <p>Title</p>
                    <input class="title" name="title" type="text">
                </div>

                <div class="addAmount">
                    <p>Amount</p>
                    <input class="amount" name="amount" min="0" step="0.01" type="number">
                </div>

                <div class="addDate">
                    <p>Date</p>
                    <input class="date" name="date" type="date">
                </div>
                <div class="addCategory">
                    <p>Category</p>
                    <select class="category" name="category" id="category">
                        <option value="lifestyle">Lifestyle</option>
                        <option value="essential">Essential</option>
                        <option value="financial">Financial</option>
                        <option value="other">Other</option>
                    </select>
                </div>


                <div class="isRecurring">
                    <p>Recurring Income</p>
                    <input class="isRecurring" name="isRecurring" type="checkbox" value="yes">
                </div>   
            
                <input class="submit" name="submit" value="submit" type="submit">
                <p class="errmsg"><?php echo $errmsg;?></p>
            </form>     
        </div>
    </div>
</body>
</html>