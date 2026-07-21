<?php
    include("../config.php");
    include("sidebar.php");



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
            <h2 class="mainTitle">Add Goal</h2>
            <p class="description">Choose your goal type</p>
        </div>
    </div>

    <div class="goalType">
        <div class="choose">
            <div onclick="window.location.href='addIncomeGoal.php'">
                Income
            </div>
            <div onclick="window.location.href='addExpenseGoal.php'">
                Expense
            </div>
        </div>
    </div>

<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>