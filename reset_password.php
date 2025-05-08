<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined']) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==1) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==0)) {
        extract($_POST);

        $sql = "SELECT * FROM User WHERE user_email='$email'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num==0) {
            die("<script> alert('อีเมลไม่ถูกต้อง! โปรดตรวจสอบอีเมลแล้วลองอีกครั้ง!'); history.back();</script>");
            exit;
        }

        $options = [
            'cost' => 10,
        ];

        $passwordHash = password_hash($password,  PASSWORD_BCRYPT, $options);

        $da = date("Y-m-d");

        $sql = "UPDATE User SET user_password = '$passwordHash' WHERE user_email='$email'";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("รีเซ็ตรหัสผ่านไม่สำเร็จ! โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        echo "<script>alert('รีเซ็ตรหัสผ่านสำเร็จ!');
        location.href='login.php';</script>";
    } else {
        if(isset($_SESSION['logined']) and $_SESSION['user_lv']==2) {
            echo "<script>location.href='admin_index.php';</script>";
    exit;
        } else {
            echo "<script>location.href='index.php';</script>";
    exit;
        }
    }
?>