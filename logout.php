<?php require('connect.php'); ?>

<?php
    if(isset($_SESSION['logined'])) {
        session_destroy();
        echo "<script>location.href='index.php';</script>";
    } else {
        header("Location: index.php");
    }
?>