CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255)
);
<?php require('connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Manage Users</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mycss.css" rel="stylesheet">
</head>
<body class="dark-bg">
<?php require('admin_navbar.php'); ?>

<div class="container mt-5">
    <h2 class="text-white mb-4">ผู้ใช้</h2>
    <table class="table table-bordered table-light text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>ชื่อ Users</th>
                <th>Email</th>
                <th>รายละเอียด</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td><a href='view_user.php?id={$row['id']}' class='text-primary'>ดูข้อมูลผู้ใช้</a></td>
                    <td><a href='edit_user.php?id={$row['id']}'><img src='img/edit.png' width='20'></a></td>
                    <td><a href='delete_user.php?id={$row['id']}' onclick='return confirm(\"ยืนยันการลบ?\")'><img src='img/delete.png' width='20'></a></td>
                </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
    <a href="add_user.php" class="btn btn-success">➕ เพิ่มผู้ใช้</a>
</div>

<script src="js/bootstrap.bundle.js"></script>
</body>
</html>
