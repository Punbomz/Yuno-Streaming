<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined']) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==1)) {
        extract($_POST);
        extract($_GET);

        $sql = "SELECT * FROM User WHERE user_name='$username' AND user_id != '$id'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num!=0) {
            die("<script> alert('ชื่อผู้ใช้ซ้ำ!'); history.back(); </script>");
        }

        $sql = "SELECT * FROM User WHERE user_email='$email' AND user_id != '$id'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num!=0) {
            die("<script> alert('อีเมลนี้มีการสมัครสมาชิกแล้ว!'); history.back(); </script>");
        }

        if(isset($password) and $password!="") {
            $options = [
                'cost' => 10,
            ];

            $passwordHash = password_hash($password,  PASSWORD_BCRYPT, $options);

            $da = date("Y-m-d");

            $sql = "UPDATE User SET user_name = '$username', user_password = '$passwordHash', user_email = '$email', user_lv = '$lv' WHERE user_id='$id'";
        } else {
            $sql = "UPDATE User SET user_name = '$username', user_email = '$email', user_lv = '$lv' WHERE user_id='$id'";
        }
            $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("บันทึกไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        echo "<script>alert('บันทึกข้อมูลสำเร็จ!');
        location.href='admin_user.php';</script>";

    } else {
        if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
            header("Location: admin_index.php");
        } else {
            header("Location: index.php");
        }
    }
?>