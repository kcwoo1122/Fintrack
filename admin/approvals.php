<?php
    include("../config.php");
    include("sidebar.php");
    $getRequests=mysqli_query($conn,"SELECT * FROM request WHERE status='pending'");



if(isset($_POST['approve'])){
    $requestID=$_POST['requestID'];
    $requestQuery=mysqli_query($conn,"SELECT * FROM request WHERE requestID='$requestID'");
    $requestDetails=mysqli_fetch_assoc($requestQuery);

    $name=$requestDetails['name'];
    $email=$requestDetails['email'];
    $password=$requestDetails['password'];

    mysqli_query($conn,"UPDATE request SET status='approved' WHERE requestID='$requestID'");
    mysqli_query($conn,"INSERT INTO users(name,email,password,role)VALUES('$name','$email','$password','moderator')");
    header("Location: approvals.php");
    exit();
}

if(isset($_POST['reject'])){
    $requestID=$_POST['requestID'];
    mysqli_query($conn,"UPDATE request SET status='rejected' WHERE requestID='$requestID'");
    header("Location: approvals.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/approvals.css">
    <title>Document</title>
</head>
<body>
    <h2>Account Requests</h2>
    <form method="post">
        <div class="grid">
            <?php if(mysqli_num_rows($getRequests)>0):?>
                <?php while($rowRequests=mysqli_fetch_assoc($getRequests)):?>
                    <div class="request">
                        <div class="left">
                            <div class="icon"><i class="fa-solid fa-circle-user"></i></div>
                            <div class="name">Name: <?php echo $rowRequests['name'];?></div>
                            <div class="email">Email: <?php echo $rowRequests['email'];?></div>
                            <div class="password">Password: <?php echo $rowRequests['password'];?></div>
                            <div class="createdAt">Created At: <?php echo $rowRequests['created_at'];?></div>
                            <div class="buttons">
                                <input class="approve" name="approve" value="Approve" type="submit">
                                <input class="reject" name="reject" value="Reject" type="submit">
                                <input type="hidden" name="requestID" value="<?php echo $rowRequests['requestID']; ?>">
                            </div>
                        </div>
                        <div class="right">
                            <h3>Reason</h3>
                            <div class="reason"><?php echo $rowRequests['reason'];?></div>
                        </div>
                    </div>
                <?php endwhile;?>
            <?php else:?>
                <div class="noInput">No requests yet</div>
            <?php endif;?>
        </div>

    </form>

</body>
</html>