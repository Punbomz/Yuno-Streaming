<?php require('connect.php'); ?>

<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==2 or $_SESSION['user_lv']==1)) {
        extract($_GET);

        $sql = "SELECT media_img FROM Media WHERE media_id='$id'";
        $result = mysqli_query($dbcon, $sql);
        $row = mysqli_fetch_assoc($result);

        $file = 'img/media/posters/'.$row['media_img'];

        if (file_exists($file)) {
            unlink($file);
        }

        $sql1 = "SELECT file_name FROM Media_Files WHERE media_id='$id'";
        $result1 = mysqli_query($dbcon, $sql1);
        
        foreach($result1 as $row1) {
            $file1 = 'files/'.$row1['file_name'];

            if (file_exists($file1)) {
                unlink($file1);
            }
        }

        $sql2 = "DELETE FROM Media WHERE media_id='$id'";
        $result2 = mysqli_query($dbcon, $sql2);

        if(!$result2) {
            die('<script>alert("ลบมีเดียไม่สำเร็จ!"); history.back();</script>');
        }

        $sql3 = "DELETE FROM Medias_Genre WHERE media_id='$id'";
        $result3 = mysqli_query($dbcon, $sql3);

        if(!$result3) {
            die('<script>alert("ลบมีเดียไม่สำเร็จ!"); history.back();</script>');
        }

        $sql4 = "DELETE FROM Media_Files WHERE media_id='$id'";
        $result4 = mysqli_query($dbcon, $sql4);

        if(!$result4) {
            die('<script>alert("ลบมีเดียไม่สำเร็จ!"); history.back();</script>');
        }
        
        $sql = "DELETE FROM Media_Actor WHERE media_id = '$id'";
        $result = mysqli_query($dbcon, $sql);

        $sql = "DELETE FROM Media_Director WHERE media_id = '$id'";
        $result = mysqli_query($dbcon, $sql);

        echo "<script>alert('ลบมีเดียสำเร็จ!'); history.back();</script>";
} else {
    echo "<script>location.href='index.php';</script>";
    exit;
} ?>