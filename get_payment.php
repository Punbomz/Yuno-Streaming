<?php
    require('connect.php');

    if (isset($_GET['payment_id'])) {
        $payment_id = $_GET['payment_id'];
        $sql = "SELECT * FROM Payment WHERE payment_id = '$payment_id'";
        $result = mysqli_query($dbcon, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'ไม่พบข้อมูล']);
        }
    }
?>