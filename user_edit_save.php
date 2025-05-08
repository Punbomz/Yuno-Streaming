<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined']) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==1) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==0)) {
        extract($_POST);
        extract($_GET);

        if($_SESSION['user_lv']==0) {
            $id = $_SESSION['user_id'];
        }

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
            die("<script> alert('อีเมลนี้มีการสมัครสมาชิกแล้ว!'); history.back();</script>");
        }

        $sql_pic = "SELECT user_img FROM User WHERE user_id='$id'";
        $result_pic = mysqli_query($dbcon, $sql_pic);
        $row_pic = mysqli_fetch_assoc($result_pic);

        if(isset($_FILES['profile']) && !empty($_FILES['profile']['name'])) {
            $ext=pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
            $pic = $title.time().'_'.$id.'_profile'.'.'.$ext;
            if(!move_uploaded_file($_FILES["profile"]["tmp_name"],'img/profile/'.$pic)) {
                die("<script> alert('อัปโหลดไม่สำเร็จ'); history.back(); </script>");
            }
        } else {
            $pic = $row_pic['user_img'];
        }

        if(isset($password) and $password!="") {
            $options = [
                'cost' => 10,
            ];

            $passwordHash = password_hash($password,  PASSWORD_BCRYPT, $options);

            $da = date("Y-m-d");

            if($_SESSION['user_lv']==1) {
                $sql = "UPDATE User SET user_name = '$username', user_password = '$passwordHash', user_email = '$email', user_img='$pic' WHERE user_id='$id'";
            } else {
                $sql = "UPDATE User SET user_name = '$username', user_password = '$passwordHash', user_email = '$email', user_img='$pic' WHERE user_id='$id'";
            }
        } else {
            if($_SESSION['user_lv']==1) {
                $sql = "UPDATE User SET user_name = '$username', user_email = '$email', user_img='$pic' WHERE user_id='$id'";
            } else {
                $sql = "UPDATE User SET user_name = '$username', user_email = '$email', user_img='$pic' WHERE user_id='$id'";
            }
        }
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("บันทึกไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        if(isset($_SESSION['logined']) and $_SESSION['user_lv']==1) {
            echo "<script>alert('บันทึกสำเร็จ!');
            location.href='admin_user.php';</script>";
        } else {
            echo "<script>alert('บันทึกสำเร็จ!');
            location.href='profile.php';</script>";
        }
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