<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined']) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==1)) {
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

        $sql = "INSERT INTO User(user_name, user_password, user_email, user_lv, register_date) VALUES('$username', '$passwordHash', '$email', '$lv', '$da')";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("เพิ่มแอดมินไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        echo "<script>alert('เพิ่มแอดมินสำเร็จ!');
        location.href='admin_user.php';</script>";

    } else {
        if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
            header("Location: admin_index.php");
        } else {
            header("Location: index.php");
        }
    }
?>