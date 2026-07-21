<?php
    include("../config.php");
    include("sidebar.php");

    $errmsg="";

    $getUsers="SELECT * FROM users";
    $queryUsers=mysqli_query($conn,$getUsers);
    $count=1;

    function checkCount($email){
        $numUsers=mysqli_num_rows($email);
        return $numUsers;
    } 

    if(isset($_POST['submit'])){
        $role=$_POST['role'];
        $email=$_POST['email'];
        $getUsers="SELECT * FROM users WHERE role='$role'";
        $getUsersByEmail="SELECT * FROM users WHERE role='$role' AND email='$email'";
        if(empty($email)){
            $queryUsers=mysqli_query($conn,$getUsers);
        }
        else{
            $queryUsers=mysqli_query($conn,$getUsersByEmail);
        }
        
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/manageUser.css">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <div class="roleSelection">
            <h2>Select Role</h2>
            <select class="role" name="role" id="">
                <option value="user">User</option>
                <option value="admin">Admin</option>
                <option value="moderator">Moderator</option>
            </select>
        </div>
        <div class="usernameSelection">
            <h2>Enter Email</h2>
            <input name="email" class="email" type="text">
        </div>
        <input name="submit" class="submit" type="submit" value="submit">
    </form>

    <div class="userTable">
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Date Created</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if(checkCount($queryUsers)!=0):?>
                    <?php while ($row = mysqli_fetch_assoc($queryUsers)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <button onclick="window.location.href='editUser.php?userID=<?php echo $row['userID']; ?>'" class="edit">Edit</button>
                        </td>
                        <td>
                            <button onclick="window.location.href='deleteUser.php?userID=<?php echo $row['userID']; ?>'" class="delete">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else:?>
                    <tr>
                        <td class="count"></td>
                        <td class="signupUsername">No users yet</td>
                    </tr>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</body>
</html>