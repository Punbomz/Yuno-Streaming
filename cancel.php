<?php require('connect.php'); ?>

<?php
    if(isset($_SESSION['logined']) and $_SESSION['user_lv']==0) {

        $sql = "UPDATE User SET package_name=NULL, package_start=NULL, package_end=NULL WHERE user_id='".$_SESSION['user_id']."'";    
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("ยกเลิกการสมัครแพ็คเกจไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        echo "<script>alert('ยกเลิกการสมัครแพ็คเกจสำเร็จ!');
        history.back();</script>";
    } else {
        echo "<script>location.href='index.php';</script>";
    exit;
    }
?>