<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined'])) {
        extract($_POST);

        $sql = "SELECT * FROM User WHERE user_name='$username'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num!=0) {
            die("<script> alert('ชื่อผู้ใช้ซ้ำ!'); history.back(); </script>");
        }

        $sql = "SELECT * FROM User WHERE user_email='$email'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num!=0) {
            die("<script> alert('อีเมลนี้มีการสมัครสมาชิกแล้ว!'); history.back(); </script>");
        }

        $options = [
            'cost' => 10,
        ];

        $passwordHash = password_hash($password,  PASSWORD_BCRYPT, $options);

        $da = date("Y-m-d");

        $sql = "INSERT INTO User(user_name, user_password, user_email, user_birthdate, user_lv, register_date) VALUES('$username', '$passwordHash', '$email', '$dob', 0, '$da')";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("สมัครสมาชิกไม่สำเร็จ โปรดลองอีกครั้ง!"); window.location="register.php";</script>');
        }

        echo "<script>alert('สมัครสมาชิกสำเร็จ!');
        location.href='login.php';</script>";
    } else {
        header("Location: index.php");
    }
?>