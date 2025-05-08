<?php
    require('connect.php');

    if (isset($_SESSION['logined']) && $_SESSION['user_lv'] == 0) {
        extract($_POST);

        $user_id = $_SESSION['user_id'];
        $media_id = mysqli_real_escape_string($dbcon, $id);

        $sql = "SELECT media_id FROM Watchlist WHERE media_id = '$media_id' AND user_id = '$user_id'";
        $result = mysqli_query($dbcon, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            mysqli_query($dbcon, "DELETE FROM Watchlist WHERE user_id='$user_id' AND media_id='$media_id'");
            echo 'removed';
        } else {
            mysqli_query($dbcon, "INSERT INTO Watchlist (user_id, media_id) VALUES ('$user_id', '$media_id')");
            echo 'added';
        }

        $result = mysqli_query($dbcon, $sql);
    } else {
        echo "<script>alert('กรุณาเข้าสู่ระบบ!');
        location.href='login.php';</script>";
    }
?>