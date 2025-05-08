<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined']) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==1)) {
        extract($_POST);
        extract($_GET);

        $sql = "SELECT * FROM Package WHERE package_name='$name' AND package_name != '$id'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num!=0) {
            die("<script> alert('ชื่อแพ็คเกจซ้ำ!'); history.back(); </script>");
        }

        $devices = implode(", ", $device);

        $sql = "UPDATE Package SET package_name='$name', price='$price', devices='$devices', screens='$screen', resolution='$res' WHERE package_name='$id'";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("บันทึกไม่สำเร็จ โปรดลองอีกครั้ง!");  history.back();</script>');
        }

        echo "<script>alert('บันทึกสำเร็จ!');
        location.href='admin_package.php';</script>";

    } else {
        if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
            echo "<script>location.href='admin_index.php';</script>";
    exit;
        } else {
            echo "<script>location.href='index.php';</script>";
    exit;
        }
    }
?>