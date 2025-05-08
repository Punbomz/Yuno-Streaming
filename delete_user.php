<?php require('connect.php'); ?>

<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==2 or $_SESSION['user_lv']==1)) {
        extract($_GET);

        $sql = "SELECT user_img FROM User WHERE user_id='$id'";
        $result = mysqli_query($dbcon, $sql);
        $row = mysqli_fetch_assoc($result);

        $file = 'img/profile/'.$row['user_img'];

        if (file_exists($file)) {
            unlink($file);
        }

        $sql2 = "DELETE FROM User WHERE user_id='$id'";
        $result2 = mysqli_query($dbcon, $sql2);

        if(!$result2) {
            die('<script>alert("ลบผู้ใช้ไม่สำเร็จ!"); history.back();</script>');
        }

        $sql3 = "DELETE FROM Payment WHERE user_id='$id'";
        $result3 = mysqli_query($dbcon, $sql3);
        if(!$result3) {
            die('<script>alert("ลบผู้ใช้ไม่สำเร็จ!"); history.back();</script>');
        }

        $sql4 = "DELETE FROM Watchlist WHERE user_id='$id'";
        $result4 = mysqli_query($dbcon, $sql4);
        if(!$result4) {
            die('<script>alert("ลบผู้ใช้ไม่สำเร็จ!"); history.back();</script>');
        }

        echo "<script>alert('ลบผู้ใช้สำเร็จ!'); history.back();</script>";
} else {
    echo "<script>location.href='index.php';</script>";
    exit;
} ?>