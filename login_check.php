<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined'])) {
        extract($_POST);

        $options = [
            'cost' => 10,
        ];

        $sql = "SELECT * FROM User WHERE user_name='$username'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);
        
        if($num==0) {
            die("<script> alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!'); history.back(); </script>");
        }
        
        $row = mysqli_fetch_assoc($result);
        $validPassword = password_verify($password, $row['user_password']);

        if(!$validPassword) {
            die("<script> alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!'); history.back(); </script>");
        }
        
        $_SESSION['logined'] = True;
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['user_lv'] = $row['user_lv'];
        session_write_close();

        if($row['user_lv'] == 0) {
            echo "<script>location.href='index.php';</script>";
        } else {
            echo "<script>location.href='admin_index.php';</script>";
        }
        
    } else {
        header("Location: index.php");
    }
?>