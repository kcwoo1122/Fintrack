<?php
    include("../config.php");
    include("sidebar.php");

    $getLifetimeIncome=mysqli_query($conn,"SELECT SUM(amount) AS lifetimeIncome FROM income WHERE userID='$userID'");
    $rowLifetimeIncome=mysqli_fetch_assoc($getLifetimeIncome);
    $lifetimeIncome=$rowLifetimeIncome['lifetimeIncome'];

    $getMonthlyIncome=mysqli_query($conn,"SELECT SUM(amount) AS monthlyIncome FROM income WHERE userID='$userID' AND MONTH(date)=MONTH(CURDATE()) AND YEAR(date)=YEAR(CURDATE())");
    $rowMonthlyIncome=mysqli_fetch_assoc($getMonthlyIncome);
    $monthlyIncome=$rowMonthlyIncome['monthlyIncome'];

    $getRecurringIncome=mysqli_query($conn,"SELECT SUM(amount) AS recurringIncome FROM income WHERE userID='$userID' AND recurring='yes'");
    $rowRecurringIncome=mysqli_fetch_assoc($getRecurringIncome);
    $recurringIncome=$rowRecurringIncome['recurringIncome'];

    $getAll=mysqli_query($conn,"SELECT incomeID,title,amount,date,category,recurring FROM income WHERE userID='$userID'");

    $getChartDate=mysqli_query($conn,"SELECT income.category,incomechart.chartType,income.date,income.amount,income.title FROM income INNER JOIN incomechart ON income.category=incomechart.category WHERE income.userID=$userID AND income.date BETWEEN incomechart.startDate AND incomechart.endDate");

    if(isset($_POST['removeChart'])){
        $chartID=$_POST['removeChart'];
        mysqli_query($conn,"DELETE FROM incomechart WHERE category='$chartID'");
        header("Location:income.php");
        exit();
    }

    $charts = [];

    while ($row = mysqli_fetch_assoc($getChartDate)) {
        $id = $row['category']; 
        
        if (!isset($charts[$id])) {
            $charts[$id] = [
                'type' => $row['chartType'],
                'title' => $row['title'],
                'category' => $row['category'], // Add this line to grab the category name
                'labels' => [],
                'data' => []
            ];
        }
        
        $charts[$id]['labels'][] = $row['title'];
        $charts[$id]['data'][] = $row['amount'];
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
            <h2 class="mainTitle">Income Management</h2>
            <p class="description">Track and Manage your income</p>
        </div>
        
        <div class="buttons">
            <div onclick="window.location.href='addIncome.php'" class="add">
                <i class="fa-solid fa-plus"></i>
                <p>Add Income</p>
            </div>
            <div onclick="window.location.href='addIncomeChart.php'" class="addChart">
                <i class="fa-solid fa-plus"></i>
                <p>Add Chart</p>
            </div>
        </div>
    </div>

    <div class="middle">
        <div class="middleContent">
            <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <div class="middleRight">
                <p class="middleTitle">Lifetime Income</p>
                <p class="amount"><?php echo $lifetimeIncome;?></p>
            </div>
        </div>
        <div class="middleContent">
            <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <div class="middleRight">
                <p class="middleTitle">This Month's Income</p>
                <p class="amount"><?php echo $monthlyIncome;?></p>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <form method="post">
        <div class="charts"> 
            <?php foreach ($charts as $id => $chartData): ?>
                <div>
                    <button type="submit" class="removeChart" name="removeChart" value="<?php echo $id; ?>">Remove</button>
                    <!-- Changed to display the category name dynamically -->
                    <h3><?php echo htmlspecialchars($chartData['category']); ?></h3>
                    
                    <!-- Unique ID for every canvas stays intact -->
                    <canvas id="canvas_<?php echo $id;?>"></canvas>
                </div>

                <script>
                (function() {
                    const ctx = document.getElementById('canvas_<?php echo $id;?>').getContext('2d');
                    new Chart(ctx, {
                        type: '<?php echo $chartData["type"]; ?>',
                        data: {
                            labels: <?php echo json_encode($chartData['labels']); ?>,
                            datasets: [{
                                label: 'Amount',
                                data: <?php echo json_encode($chartData['data']); ?>,
                                backgroundColor: [
                                    'rgb(0, 78, 212)',   // base blue
                                    'rgb(0, 62, 170)',   // darker
                                    'rgb(0, 48, 140)',   // deeper navy
                                    'rgb(0, 98, 255)',   // brighter accent (still same family)
                                    'rgb(0, 40, 120)',   // very dark blue
                                    'rgb(30, 110, 255)'  // lighter highlight blue
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                })();
                </script>
                    
            <?php endforeach; ?>  
        </div>
    </form>
    <div class="bottom">
        <h3>Income History</h3>
        <?php while($rowAll=mysqli_fetch_assoc($getAll)):?>
            <div class="historyRow">
                <div class="historyRowLeft">
                    <div class="rowLeftTop">
                        <p class="title"><?php echo $rowAll['title'];?></p>
                        <?php if ($rowAll['recurring'] == 'yes') { ?>
                            <p class="recurring">Recurring</p>
                        <?php } ?>
                    </div>
                    <p class="date"><?php echo $rowAll['date'];?></p>
                </div>
                <div class="historyRowRight">
                    <p class="amountHistory">$&nbsp<?php echo $rowAll['amount'];?></p>
                    <i onclick="window.location.href='editIncome.php?incomeID=<?php echo $rowAll['incomeID'];?>'" class="fa-solid fa-pen-to-square"></i>
                </div>
                
            </div>
        <?php endwhile;?>
    </div>
</body>
</html>