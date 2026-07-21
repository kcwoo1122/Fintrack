<?php
    include("../config.php");
    include("sidebar.php");

    $errmsg="";
    $incomeID=$_GET['incomeID'];
    $getIncome=mysqli_query($conn,"SELECT * FROM income WHERE incomeID=$incomeID");
    
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
            mysqli_query($conn,"UPDATE income SET title='$title',amount='$amount',date='$date',category='$category',recurring='$isRecurring' WHERE incomeID=$incomeID");
            header("Location:income.php");
            exit();
        }
    }

    if(isset($_POST['delete'])){
        mysqli_query($conn,"DELETE FROM income WHERE incomeID=$incomeID");
        header("Location:income.php");
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
        <h1 class="mainTitle">Edit Income</h1>
        <div class="addGrid">
            <form class="grid" method="post">
                <?php while($rowIncome=mysqli_fetch_assoc($getIncome)):?>
                    <div class="addTitle">
                        <p>Title</p>
                        <input value='<?php echo $rowIncome['title'];?>' class="title" name="title" type="text">
                    </div>

                    <div class="addAmount">
                        <p>Amount</p>
                        <input value='<?php echo $rowIncome['amount'];?>' class="amount" name="amount" min="0" step="0.01" type="number">
                    </div>

                    <div class="addDate">
                        <p>Date</p>
                        <input value='<?php echo $rowIncome['date'];?>' class="date" name="date" type="date">
                    </div>
                    <div class="addCategory">
                        <p>Category</p>
                        <select class="category" name="category" id="category">
                            <option <?php if($rowIncome['category']=='Salary') echo 'selected';?> value="Salary">Salary</option>
                            <option <?php if($rowIncome['category']=='Freelance') echo 'selected';?> value="Freelance">Freelance</option>
                            <option <?php if($rowIncome['category']=='Business') echo 'selected';?> value="Business">Business</option>
                            <option <?php if($rowIncome['category']=='Investment') echo 'selected';?> value="Investment">Investment</option>
                            <option <?php if($rowIncome['category']=='Salary') echo 'selected';?> value="Allowance/Gifts">Allowance/Gifts</option>
                            <option <?php if($rowIncome['category']=='Other') echo 'selected';?> value="Other">Other</option>
                        </select>
                    </div>


                    <div class="isRecurring">
                        <p>Recurring Income</p>
                        <input <?php if($rowIncome['recurring']=='yes') echo 'checked';?> class="isRecurring" name="isRecurring" type="checkbox" value="yes">
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