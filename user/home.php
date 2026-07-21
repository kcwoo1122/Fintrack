<?php
    include("../config.php");
    include("sidebar.php");
    $name=$_SESSION['name'];
    $getLifetimeIncome=mysqli_query($conn,"SELECT * FROM income WHERE userID='$userID' GROUP BY category");
    $getLifetimeExpense=mysqli_query($conn,"SELECT * FROM expense WHERE userID=$userID GROUP BY category");

    $getIncome=mysqli_query($conn,"SELECT * FROM income WHERE userID='$userID' ORDER BY created_at DESC LIMIT 3");
    $getExpense=mysqli_query($conn,"SELECT * FROM expense WHERE userID='$userID' ORDER BY created_at DESC LIMIT 3");
    $incomeCategories = [];
    $incomeTotals     = [];
    $expenseCategories = [];
    $expenseTotals     = [];



    while ($row = mysqli_fetch_assoc($getLifetimeIncome)) {
        $incomeCategories[] = $row['category'];
        $incomeTotals[]=(float)$row['amount'];
    }



    while ($row = mysqli_fetch_assoc($getLifetimeExpense)) {
        $expenseCategories[]=$row['category'];
        $expenseTotals[]=(float)$row['amount'];
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/userHome.css">

    <title>Document</title>
</head>
<body>
    <div class="all">
        <div class="top">
            <div class="topLeft">
                <canvas id="incomePieChart"></canvas>
                <canvas id="totalIncomeChart"></canvas>
            </div>

            <div class="topRight">
                <div class="advice">
                    <div id="content" class="content"></div>
                </div>
            </div>


        </div>
        <div class="history">
            <div class="incomeBox">
                <h3>Recent Income</h3>
                <?php while($rowIncome=mysqli_fetch_assoc($getIncome)):?>
                    <div class="income">
                        <div class="left">
                            <div><?php echo $rowIncome['title']?></div>
                            <div class="category"><?php echo $rowIncome['category']?></div>
                        </div>
                        <div class="right">
                            <div><?php echo $rowIncome['amount']?></div>
                        </div>
                    </div>
                <?php endwhile;?>
            </div>
            <div class="incomeBox">
                <h3>Recent Expense</h3>
                <?php while($rowExpense=mysqli_fetch_assoc($getExpense)):?>
                    <div class="income">
                        <div class="left">
                            <div><?php echo $rowExpense['title']?></div>
                            <div class="category"><?php echo $rowExpense['category']?></div>
                        </div>
                        <div class="right">
                            <div><?php echo $rowExpense['amount']?></div>
                        </div>
                    </div>
                <?php endwhile;?>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const advice = [
    "Save at least 20% of your income each month.",
    "Pay yourself first — set aside savings before spending.",
    "Track your expenses daily to spot patterns early.",
    "Avoid lifestyle inflation when your income increases.",
    "Wait 24 hours before making any unplanned purchase.",
    "Try the 50/30/20 rule: needs, wants, and savings.",
    "Review your budget at the end of every month.",
    "Pay off high-interest debt before investing.",
    "Spend less than you earn — always.",
    "Consistency beats intensity when building financial habits.",
];
let current = 0;
const el = document.getElementById('content');

function cycleAdvice() {
    // fade out
    el.style.opacity = 0;

    setTimeout(() => {
        current = (current + 1) % advice.length;
        el.textContent = advice[current];
        // fade in
        el.style.opacity = 1;
    }, 600); // matches transition duration
}

// set first advice immediately
el.textContent = advice[0];
el.style.opacity = 1;

setInterval(cycleAdvice, 2000);
const pieCtx = document.getElementById('incomePieChart').getContext('2d');

new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($incomeCategories); ?>,
        datasets: [{
            data: <?php echo json_encode($incomeTotals); ?>,
            backgroundColor: [
                'rgb(0, 78, 212)',
                'rgba(0, 78, 212, 0.8)',
                'rgba(0, 78, 212, 0.6)',
                'rgba(0, 78, 212, 0.4)',
                'rgba(130, 176, 255, 1)',
                'rgba(130, 176, 255, 0.6)'
            ],
            borderColor: 'white',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: {
                display: true,
                text: 'Total Income',
                color: 'black',
                font: {
                    size: 18,
                    weight: 'bold'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return ' RM ' + context.parsed.toLocaleString();
                    }
                }
            }
        }
    }
});

const totalIncomeCtx = document.getElementById('totalIncomeChart').getContext('2d');

new Chart(totalIncomeCtx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($expenseCategories); ?>,
        datasets: [{
            data: <?php echo json_encode($expenseTotals); ?>,
            backgroundColor: [
                'rgb(0, 78, 212)',
                'rgba(0, 78, 212, 0.8)',
                'rgba(0, 78, 212, 0.6)',
                'rgba(0, 78, 212, 0.4)',
                'rgba(130, 176, 255, 1)',
                'rgba(130, 176, 255, 0.6)'
            ],
            borderColor: 'white',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: {
                display: true,
                text: 'Total Expense by Category',
                color: 'black',
                font: {
                    size: 18,
                    weight: 'bold'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percent = ((context.parsed / total) * 100).toFixed(1);
                        return ' RM ' + context.parsed.toLocaleString() + ' (' + percent + '%)';
                    }
                }
            }
        }
    }
});
</script>
</html>