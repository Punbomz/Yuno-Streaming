<?php require('connect.php'); ?>

<?php if(isset($_SESSION['logined']) and $_SESSION['user_lv']==0) {
        extract($_GET);

        $sql = "DELETE FROM Payment WHERE payment_id='$id'";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("ลบช่องทางการชำระเงินไม่สำเร็จ!"); history.back();</script>');
        }

        echo "<script>alert('ลบช่องทางการชำระเงินสำเร็จ!'); history.back();</script>";
} else {
    header("Location: index.php");
} ?>