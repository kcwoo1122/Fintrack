<?php
    include("../config.php");
    include("sidebar.php");

    $errmsg="";
    $expenseID=$_GET['expenseID'];
    $getExpense=mysqli_query($conn,"SELECT * FROM expense WHERE expenseID=$expenseID");
    
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
            mysqli_query($conn,"UPDATE expense SET title='$title',amount='$amount',date='$date',category='$category',recurring='$isRecurring' WHERE expenseID=$expenseID");
            header("Location:expense.php");
            exit();
        }
    }

    if(isset($_POST['delete'])){
        mysqli_query($conn,"DELETE FROM expense WHERE expenseID=$expenseID");
        header("Location:expense.php");
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
        <h1 class="mainTitle">Edit Expense</h1>
        <div class="addGrid">
            <form class="grid" method="post">
                <?php while($rowExpense=mysqli_fetch_assoc($getExpense)):?>
                    <div class="addTitle">
                        <p>Title</p>
                        <input value='<?php echo $rowExpense['title'];?>' class="title" name="title" type="text">
                    </div>

                    <div class="addAmount">
                        <p>Amount</p>
                        <input value='<?php echo $rowExpense['amount'];?>' class="amount" name="amount" min="0" step="0.01" type="number">
                    </div>

                    <div class="addDate">
                        <p>Date</p>
                        <input value='<?php echo $rowExpense['date'];?>' class="date" name="date" type="date">
                    </div>
                    <div class="addCategory">
                        <p>Category</p>
                        <select class="category" name="category" id="category">
                            <option <?php if($rowExpense['category']=='lifestyle') echo 'selected';?> value="lifestyle">Lifestyle</option>
                            <option <?php if($rowExpense['category']=='essential') echo 'selected';?> value="essential">Essential</option>
                            <option <?php if($rowExpense['category']=='financial') echo 'selected';?> value="financial">Financial</option>
                            <option <?php if($rowExpense['category']=='other') echo 'selected';?> value="other">Other</option>
                        </select>
                    </div>


                    <div class="isRecurring">
                        <p>Recurring Expense</p>
                        <input <?php if($rowExpense['recurring']=='yes') echo 'checked';?> class="isRecurring" name="isRecurring" type="checkbox" value="yes">
                    </div>   
                    
                    <div class="buttons">
                        <input class="submit" name="submit" value="submit" type="submit">
                        <input class="delete" name="delete" value="delete" type="submit">
                    </div>
                    
                    <p class="errmsg"><?php echo $errmsg;?></p>
                <?php endwhile;?>
            </form>     
        </div>
    </div>
</body>
</html>