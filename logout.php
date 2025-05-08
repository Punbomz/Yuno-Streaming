<?php require('connect.php'); ?>

<?php
    if(isset($_SESSION['logined'])) {
        session_destroy();
        echo "<script>location.href='login.php';</script>";
    } else {
        echo "<script>location.href='login.php';</script>";
    exit;
    }
?>