<?php 
    include("sidebar.php");
    include("../config.php");

    $getUsers=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(userID) AS totalUsers FROM users"));
    $getSignups=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(userID) AS totalSignups FROM users WHERE YEAR(created_at)=YEAR(CURDATE())"));
    $getActive=mysqli_fetch_assoc(mysqli_query($conn,"SELECT DISTINCT COUNT(userID) AS active FROM income WHERE date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)"));

    $getUser=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(userID) AS user FROM users WHERE role='user'"));
    $getMod=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(userID) AS moderator FROM users WHERE role='moderator'"));
    $getAdmin=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(userID) AS admin FROM users WHERE role='admin'"));

    $getRegPerMonth=mysqli_query($conn, "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(userID) AS total FROM users WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY month ORDER BY month ASC");
    $regLabels = [];
    $regData = [];
    while ($row = mysqli_fetch_assoc($getRegPerMonth)) {
        $regLabels[] = $row['month'];
        $regData[]   = $row['total'];
    }

    $totalUsers  = $getUsers['totalUsers'];
    $activeUsers = $getActive['active'];
    $inactiveUsers = $totalUsers - $activeUsers;

    $getTotalIncome=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS total FROM income"));
    $getTotalExpense=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS total FROM expense"));
    $getAverageIncome=mysqli_fetch_assoc(mysqli_query($conn,"SELECT AVG(amount) AS average FROM income"));
    $getRecurring=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS total FROM income WHERE recurring='yes'"));
    $getNotRecurring=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS total FROM income WHERE recurring='no'"));

    $getIncomeByCategory = mysqli_query($conn, "
        SELECT category, SUM(amount) AS total
        FROM income
        GROUP BY category
        ORDER BY total DESC
    ");

    $incomeCategories = [];
    $incomeCategoryData = [];
    while ($row = mysqli_fetch_assoc($getIncomeByCategory)) {
        $incomeCategories[]    = $row['category'];
        $incomeCategoryData[]  = (float)$row['total'];
    }

    $getTotalQuiz=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(quizID) AS total FROM quiz"));
    $getQuizAttempts=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(quizlogID) AS total FROM quizlog"));
    $getPopularCategory=mysqli_fetch_assoc(mysqli_query($conn,"SELECT q.category, COUNT(*) AS total_attempts FROM quizlog ql JOIN quiz q ON ql.quizID=q.quizID GROUP BY q.category ORDER BY total_attempts DESC LIMIT 1"));

    $getAttemptsByCategory = mysqli_query($conn, "
        SELECT q.category, COUNT(*) AS total_attempts
        FROM quizlog ql
        JOIN quiz q ON ql.quizID = q.quizID
        GROUP BY q.category
        ORDER BY q.category ASC
    ");

    // Average score per category
    $getAvgScoreByCategory = mysqli_query($conn, "
        SELECT q.category, AVG(ql.score) AS avg_score
        FROM quizlog ql
        JOIN quiz q ON ql.quizID = q.quizID
        GROUP BY q.category
        ORDER BY q.category ASC
    ");

    $quizCategories  = [];
    $quizAttempts    = [];
    $avgScores       = [];

    while ($row = mysqli_fetch_assoc($getAttemptsByCategory)) {
        $quizCategories[] = $row['category'];
        $quizAttempts[]   = (int)$row['total_attempts'];
    }

    while ($row = mysqli_fetch_assoc($getAvgScoreByCategory)) {
        $avgScores[] = round((float)$row['avg_score'], 1);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/analytics.css">
    <title>Document</title>
</head>
<body>
    <h1 class="mainTitle">Analytics</h1>
    <div class="all">
        <div class="userAnalytics">
            <div class="userBoxes">
                <div class="totalUsers">
                    <div class="title">Total Users</div>
                    <div class="total"><?php echo $getUsers['totalUsers'];?></div>
                </div>

                <div class="activeUsers">
                    <div class="title">Total Signups This Year</div>
                    <div class="total"><?php echo $getSignups['totalSignups'];?></div>
                </div>

                <div class="inactiveUsers">
                    <div class="title">Active Users</div>
                    <div class="total"><?php echo $getActive['active'];?></div>
                </div>

                <div class="userSplit">
                    <p>User Roles</p>
                    <div class="userRoles">
                        <div class="user">
                            <p>User:</p>
                            <p><?php echo $getUser['user'];?></p>
                        </div>
                        <div class="moderator">
                            <p>Moderator:</p>
                            <p> <?php echo $getMod['moderator'];?></p>
                        </div>
                        <div class="admin">
                            <p>Admin:</p>
                            <p> <?php echo $getAdmin['admin'];?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="userChart">
                <div class="registrationChart">
                    <canvas height="250" id="registrationChart"></canvas>
                </div>
                <div class="activeUserChart">
                    <canvas id="activeUserChart"></canvas>
                </div>
                
            </div>
        </div>

        <div class="financialAnalytics">
            <div class="userBoxes">
                <div class="totalUsers">
                    <div class="title">Total Income</div>
                    <div class="total">RM <?php echo number_format($getTotalIncome['total']?? 0,2);?></div>
                </div>

                <div class="activeUsers">
                    <div class="title">Total Expenses</div>
                    <div class="total">RM <?php echo number_format($getTotalExpense['total']?? 0,2);?></div>
                </div>

                <div class="inactiveUsers">
                    <div class="title">Average Income per User</div>
                    <div class="total">RM <?php echo number_format($getAverageIncome['average']?? 0,2);?></div>
                </div>

                <div class="userSplit">
                    <p>Income Type</p>
                    <div class="userRoles">
                        <div class="user">
                            <p>Recurring:</p>
                            <p> RM <?php echo number_format($getRecurring['total']?? 0,2);?></p>
                        </div>
                        <div class="moderator">
                            <p>One Time:</p>
                            <p> RM <?php echo number_format($getNotRecurring['total']?? 0,2);?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="userChart">
                <div class="registrationChart">
                    <canvas id="incomeCategoryBarChart"></canvas>
                </div>
                <div class="activeUserChart">
                    <canvas id="incomeCategoryPieChart"></canvas>
                </div>
                
            </div>
        </div>

        <div class="quizAnalytics">
            <div class="userBoxes">
                <div class="totalUsers">
                    <div class="title">Total Quizzes</div>
                    <div class="total"><?php echo $getTotalQuiz['total']?? 0;?></div>
                </div>

                <div class="activeUsers">
                    <div class="title">Total Attempts</div>
                    <div class="total"><?php echo $getQuizAttempts['total']?? 0;?></div>
                </div>

                <div class="inactiveUsers">
                    <div class="title">Most Popular</div>
                    <div class="total"><?php echo $getPopularCategory['category']?? 0;?></div>
                    <p><?php echo $getPopularCategory['total_attempts']?? 0;?></p>
                </div>
            </div>
            <div class="userChart">
                <div class="registrationChart">
                    <canvas id="quizAttemptsBarChart"></canvas>
                </div>
                <div class="activeUserChart">
                    <canvas id="avgScoreBarChart"></canvas>
                </div>
                
            </div>
        </div>

        <div class="selectAnalytics">
            <div class="user">User</div>
            <div class="financial">Financial</div>
            <div class="quiz">Quizzes</div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels=<?php echo json_encode($regLabels);?>;
    const data  =<?php echo json_encode($regData);?>;

    const ctx = document.getElementById('registrationChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'New Registrations',
                data: data,
                backgroundColor: 'rgb(0, 78, 212)',
                borderColor: 'rgb(0, 78, 212)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: {
                    display: true,
                    text: 'User Registrations Over Time'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });


    const activeCtx = document.getElementById('activeUserChart').getContext('2d');

    new Chart(activeCtx, {
        type: 'pie',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [<?php echo $activeUsers; ?>, <?php echo $inactiveUsers; ?>],
                backgroundColor: [
                    'rgba(130, 176, 255, 1)',
                    'rgb(0, 78, 212)'
                ],
                borderColor: [
                    'rgba(130, 176, 255, 1)',
                    'rgb(0, 78, 212)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: {
                    display: true,
                    text: 'Active vs Inactive Users'
                }
            }
        }
    });


const incomeLabels = <?php echo json_encode($incomeCategories); ?>;
const incomeData   = <?php echo json_encode($incomeCategoryData); ?>;
const incomeColors = [
    'rgb(0, 78, 212)',
    'rgba(0, 78, 212, 0.8)',
    'rgba(0, 78, 212, 0.6)',
    'rgba(0, 78, 212, 0.4)',
    'rgba(130, 176, 255, 1)',
    'rgba(130, 176, 255, 0.6)'
];

// Bar Chart
const incomeCategoryBarCtx = document.getElementById('incomeCategoryBarChart').getContext('2d');
new Chart(incomeCategoryBarCtx, {
    type: 'bar',
    data: {
        labels: incomeLabels,
        datasets: [{
            label: 'Total Income (RM)',
            data: incomeData,
            backgroundColor: 'rgb(0, 78, 212)',
            borderColor: 'rgb(0, 78, 212)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true },
            title: {
                display: true,
                text: 'Total Income by Category'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return ' RM ' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'RM ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Pie Chart
const incomeCategoryPieCtx = document.getElementById('incomeCategoryPieChart').getContext('2d');
new Chart(incomeCategoryPieCtx, {
    type: 'pie',
    data: {
        labels: incomeLabels,
        datasets: [{
            label: 'Total Income (RM)',
            data: incomeData,
            backgroundColor: incomeColors,
            borderColor: 'white',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' },
            title: {
                display: true,
                text: 'Total Income by Category'
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


const quizCategories = <?php echo json_encode($quizCategories); ?>;
const quizAttempts   = <?php echo json_encode($quizAttempts); ?>;
const avgScores      = <?php echo json_encode($avgScores); ?>;

const sections = {
    user: document.querySelector('.userAnalytics'),
    financial: document.querySelector('.financialAnalytics'),
    quiz: document.querySelector('.quizAnalytics')
};

function showSection(section) {
    // hide all
    Object.values(sections).forEach(s => s.style.display = 'none');
    // show selected
    sections[section].style.display = 'flex';
}



document.querySelector('.selectAnalytics .user').addEventListener('click', () => showSection('user'));
document.querySelector('.selectAnalytics .financial').addEventListener('click', () => showSection('financial'));
document.querySelector('.selectAnalytics .quiz').addEventListener('click', () => showSection('quiz'));

// Bar Chart - Total Attempts
const quizAttemptsBarCtx = document.getElementById('quizAttemptsBarChart').getContext('2d');
new Chart(quizAttemptsBarCtx, {
    type: 'bar',
    data: {
        labels: quizCategories,
        datasets: [{
            label: 'Total Attempts',
            data: quizAttempts,
            backgroundColor: 'rgb(0, 78, 212)',
            borderColor: 'rgb(0, 78, 212)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true },
            title: { display: true, text: 'Total Quiz Attempts by Category' }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 5 } }
        }
    }
});

// Bar Chart - Average Score
const avgScoreBarCtx = document.getElementById('avgScoreBarChart').getContext('2d');
new Chart(avgScoreBarCtx, {
    type: 'bar',
    data: {
        labels: quizCategories,
        datasets: [{
            label: 'Average Score (%)',
            data: avgScores,
            backgroundColor: 'rgba(0, 78, 212, 0.6)',
            borderColor: 'rgb(0, 78, 212)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true },
            title: { display: true, text: 'Average Score by Category' }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        }
    }
});
</script>
</html>