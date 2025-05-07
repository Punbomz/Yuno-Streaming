<?php require('connect.php'); ?>

<?php
    if(isset($_SESSION['logined']) and $_SESSION['user_lv']==0) {
        extract($_POST);

        $d_start = new DateTime();
        $d_end = clone $d_start;
        $d_end->modify('+1 month');

        $start_date = $d_start->format('Y-m-d');
        $end_date = $d_end->format('Y-m-d');

        $sql = "UPDATE User SET package_name='$package', package_start='$start_date', package_end='$end_date' WHERE user_id='".$_SESSION['user_id']."'";    
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("สมัครแพ็คเกจไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        $sql_pk = "SELECT price FROM Package WHERE package_name = '$package'";
        $result_pk = mysqli_query($dbcon, $sql_pk);
        $row_pk = mysqli_fetch_assoc($result_pk);

        $sql = "INSERT INTO Payment_History(user_id, package_name, payment_id, price) VALUES('".$_SESSION['user_id']."', '$package', '$pay_id', '".$row_pk['price']."')";
        $result = mysqli_query($dbcon, $sql);
        
        if(!$result) {
            die('<script>alert("สมัครแพ็คเกจไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        echo "<script>alert('สมัครแพ็คเกจสำเร็จ!');
        history.back();</script>";
    } else {
        header("Location: index.php");
    }
?>