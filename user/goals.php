<?php
    include("../config.php");
    include("sidebar.php");
    $getRemaining=mysqli_query($conn,"SELECT COUNT(goalID) AS total FROM goal WHERE status='unachieved' AND userID=$userID");
    $rowRemaining = mysqli_fetch_assoc($getRemaining);
    $getAchieved=mysqli_query($conn,"SELECT COUNT(goalID) AS total FROM goal WHERE status='achieved' AND userID=$userID");
    $rowAchieved = mysqli_fetch_assoc($getAchieved);

    $getGoals=mysqli_query($conn, "SELECT 
    goal.goalID,
    goal.title,
    goal.originalType,
    goal.amount,

    COALESCE(income.amount, expense.amount) AS originalAmount

    FROM goal

    LEFT JOIN income 
        ON goal.originalID = income.incomeID
        AND goal.originalType = 'income'

    LEFT JOIN expense 
        ON goal.originalID = expense.expenseID
        AND goal.originalType = 'expense'
    WHERE goal.status='unachieved' AND goal.userID=$userID"
    );

    if(mysqli_num_rows($getGoals)>0){
        while($rowG = mysqli_fetch_assoc($getGoals)){
            $max = ($rowG['originalType'] == 'income') 
                ? $rowG['amount'] 
                : $rowG['originalAmount'];

            $current = ($rowG['originalType'] == 'income') 
                ? $rowG['originalAmount'] 
                : ($rowG['originalAmount'] - $rowG['amount']);

            $progress = ($max > 0) ? ($current / $max) * 100 : 0;

            if ($progress >= 100) {
                mysqli_query($conn, "UPDATE goal SET status='achieved' WHERE goalID=" . (int)$rowG['goalID']);
            };
        };
        mysqli_data_seek($getGoals, 0);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/management.css">
    <title>Document</title>
</head>
<body>
    
    <div class="top">
        <div class="topleft">
            <h2 class="mainTitle">Goal Management</h2>
            <p class="description">Track and Manage your goals</p>
        </div>
        
        <div class="buttons">
            <div onclick="window.location.href='goalType.php'" class="addChart">
                <i class="fa-solid fa-plus"></i>
                <p>Add Goal</p>
            </div>
        </div>
    </div>

    <div class="middle">
        <div class="middleContent">
            <div class="icon"><i class="fa-solid fa-bullseye"></i></div>
            <div class="middleRight">
                <p class="middleTitle">Remaining Goals</p>
                <p class="amount"><?php echo $rowRemaining['total'];?></p>
            </div>
        </div>
        <div class="middleContent">
            <div class="icon"><i class="fa-solid fa-star"></i></div>
            <div class="middleRight">
                <p class="middleTitle">Achieved Goals</p>
                <p class="amount"><?php echo $rowAchieved['total'];?></p>
            </div>
        </div>
        <div class="middleContent">
            <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <div class="middleRight">
                <p class="middleTitle">Total Increased</p>
                <p class="amount"><?php echo "";?></p>
            </div>
        </div>
    </div>
                        

    <div class="goals">
        <?php while($rowGoals=mysqli_fetch_assoc($getGoals)):?>
            <div class="goal">
                <div class="goalTitle"><?php echo $rowGoals['title'];?></div>
                <div class="progress">
                    <progress class="progressBar" value="<?php echo ($rowGoals['originalType']=='income' ? $rowGoals['originalAmount']:($rowGoals['originalAmount']-$rowGoals['amount']));?>" max="<?php echo ($rowGoals['originalType']=='income' ? $rowGoals['amount']:$rowGoals['originalAmount']);?>"></progress>
                    <p class="progressPercentage"><?php echo ($rowGoals['originalType']=='income'?round(($rowGoals['originalAmount']/$rowGoals['amount'])*100,2):round(($rowGoals['amount']/$rowGoals['originalAmount'])*100,2));?>&nbsp%</p>
                </div>
                <div class="goalTarget"><?php echo "Goal: ".($rowGoals['originalType'] == 'expense' ? '' : '+ ').($rowGoals['amount']-$rowGoals['originalAmount']);?></div>
                <i onclick="window.location.href='<?php echo ($rowGoals['originalType']=='income' ? 'editIncomeGoal.php?goalID='.$rowGoals['goalID'] : 'editExpenseGoal.php?goalID='.$rowGoals['goalID']); ?>'" class="fa-solid fa-pen-to-square"></i>            </div>
        <?php endwhile;?>
        
    </div>

    

<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>