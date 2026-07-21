<?php 
    include("sidebar.php");
    include("../config.php");

    $getQuiz=mysqli_query($conn,"SELECT * FROM quiz WHERE userID=$userID");
    $countQuiz=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(quizID) AS total FROM quiz WHERE userID=$userID"));
    $countVideos=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(videoID) AS total FROM video WHERE userID=$userID"));
    $totalAttempts=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(quizlog.quizID) AS total FROM quiz INNER JOIN quizlog ON quiz.quizID=quizlog.quizID WHERE quiz.userID=$userID"));

    $quizAttempts = mysqli_query($conn, "
        SELECT quiz.title, COUNT(quizlog.quizID) AS attempts 
        FROM quiz 
        LEFT JOIN quizlog ON quiz.quizID = quizlog.quizID 
        WHERE quiz.userID = $userID 
        GROUP BY quiz.quizID, quiz.title
    ");



    $quizLabels = [];
    $quizData = [];

    while($row = mysqli_fetch_assoc($quizAttempts)) {
        $quizLabels[] = $row['title'];
        $quizData[] = $row['attempts'];
    }


    $avgScores = mysqli_query($conn, "
        SELECT quiz.title, ROUND(AVG(quizlog.score), 1) AS avg_score
        FROM quiz 
        LEFT JOIN quizlog ON quiz.quizID = quizlog.quizID 
        WHERE quiz.userID = $userID 
        GROUP BY quiz.quizID, quiz.title
    ");

    $avgLabels = [];
    $avgData = [];

    while($row = mysqli_fetch_assoc($avgScores)) {
        $avgLabels[] = $row['title'];
        $avgData[] = $row['avg_score'] ?? 0;
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
    <div class="searchbar">
        <form method="post">
            <select name="quizID">
                <?php while($row = mysqli_fetch_assoc($getQuiz)): ?>
                    <option value="<?php echo $row['quizID']; ?>">
                        <?php echo $row['title']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <div class="all">
        <div class="userAnalytics">
            <div class="userBoxes">
                <div class="totalUsers">
                    <div class="title">Total Quiz Uploaded</div>
                    <div class="total"><?php echo $countQuiz['total'];?></div>
                </div>

                <div class="activeUsers">
                    <div class="title">Total Videos Uploaded </div>
                    <div class="total"><?php echo $countVideos['total'];?></div>
                </div>

                <div class="inactiveUsers">
                    <div class="title">Total Quiz Attempts</div>
                    <div class="total"><?php echo $totalAttempts['total'];?></div>
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
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const quizLabels = <?php echo json_encode($quizLabels); ?>;
    const quizData = <?php echo json_encode($quizData); ?>;

    const ctx = document.getElementById('registrationChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: quizLabels,
            datasets: [{
                label: 'Number of Attempts',
                data: quizData,
                backgroundColor: 'rgb(207, 225, 255)',
                borderColor: 'rgb(0, 78, 212)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });


    const avgLabels = <?php echo json_encode($avgLabels); ?>;
    const avgData = <?php echo json_encode($avgData); ?>;

    const avgCtx = document.getElementById('activeUserChart').getContext('2d');
    new Chart(avgCtx, {
        type: 'bar',
        data: {
            labels: avgLabels,
            datasets: [{
                label: 'Average Score (%)',
                data: avgData,
                backgroundColor: avgData.map(score =>
                    score >= 75 ? 'rgba(0, 200, 100, 0.2)' :
                    score >= 50 ? 'rgba(255, 180, 0, 0.2)' :
                    'rgba(255, 80, 80, 0.2)'
                ),
                borderColor: avgData.map(score =>
                    score >= 75 ? 'rgb(0, 200, 100)' :
                    score >= 50 ? 'rgb(255, 180, 0)' :
                    'rgb(255, 80, 80)'
                ),
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { 
                        stepSize: 10,
                        callback: value => value + '%'
                    }
                }
            }
        }
    });
</script>
</html>