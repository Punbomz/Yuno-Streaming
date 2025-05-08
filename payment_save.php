<?php require('connect.php'); ?>

<?php
    if(isset($_SESSION['logined']) and $_SESSION['user_lv']==0) {
        extract($_POST);

        $sql = "SELECT * FROM Payment WHERE number='$card_number' AND user_id='".$_SESSION['user_id']."'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num!=0) {
            die("<script> alert('คุณได้เพิ่มช่องทางการชำระเงินนี้ไปแล้ว!'); history.back(); </script>");
        }

        $sql = "INSERT INTO Payment(user_id, payment_type, number, name, expired, cvv) VALUES('".$_SESSION['user_id']."', '$type', '$card_number', '$card_name', '$expired', '$cvv')";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("บันทึกช่องทางการชำระเงินไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        echo "<script>alert('บันทึกช่องทางการชำระเงินสำเร็จ!');
        history.back();</script>";

    } else {
        echo "<script>location.href='index.php';</script>";
    exit;
    }
?>