<?php require('connect.php'); ?>

<?php if(isset($_SESSION['logined']) and $_SESSION['user_lv']==1) {
        extract($_GET);

        $sql = "DELETE FROM Package WHERE package_name='$id'";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("ลบแพ็คเกจไม่สำเร็จ!"); history.back();</script>');
        }

        echo "<script>alert('ลบแพ็คเกจสำเร็จ!'); history.back();</script>";
} else {
    header("Location: index.php");
} ?>