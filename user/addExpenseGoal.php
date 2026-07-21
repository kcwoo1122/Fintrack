<?php
    include("../config.php");
    include("sidebar.php");

    $getExpenses=mysqli_query($conn,"SELECT * FROM expense WHERE userID=$userID");
    $errmsg='';

    if(isset($_POST['submit'])){
        $title=$_POST['title'];
        $originalID=$_POST['originalID'];
        $amount=$_POST['amount'];

        if(empty($title)||empty($amount)){
            $errmsg="All fields are required";
        }
        else{
            mysqli_query($conn,"INSERT INTO goal(userID,title,amount,status,originalID,originalType) VALUES($userID,'$title',$amount,'unachieved','$originalID','expense')");
            header("Location:goals.php");
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
        <h1 class="mainTitle">Add New Goal</h1>
        <div class="addGrid">
            <form class="grid" method="post">
                <div class="addTitle">
                    <p>Title</p>
                    <input class="title" name="title" type="text">
                </div>

                <div class="addAmount">
                    <p>Category</p>
                    <select class="amount" name="originalID" id="">
                        <option value="Total Income">Total Expense</option>
                        <?php while($rowExpense=mysqli_fetch_assoc($getExpenses)):?>
                            <option value="<?php echo $rowExpense['expenseID']?>"><?php echo $rowExpense['title']?></option>
                        <?php endwhile;?>
                    </select>

                </div>

                <div class="addDate">
                    <p>Amount</p>
                    <input class="amount" name="amount" type="number" step="0.01" min="0">
                </div>
                
                <div class="addDate"></div>

                <input class="submit" name="submit" value="submit" type="submit">
            </form>     
            <p class="errmsg"><?php echo $errmsg;?></p>
        </div>
    </div>
</body>
</html>