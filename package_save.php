<?php require('connect.php'); ?>

<?php
    if(!isset($_SESSION['logined']) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==1)) {
        extract($_POST);

        $sql = "SELECT * FROM Package WHERE package_name='$name'";
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        if($num!=0) {
            die("<script> alert('ชื่อแพ็คเกจซ้ำ!'); history.back(); </script>");
        }

        $devices = implode(", ", $device);

        $sql = "INSERT INTO Package(package_name, price, devices, screens, resolution) VALUES('$name', '$price', '$devices', '$screen', '$res')";
        $result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("เพิ่มแพ็คเกจไม่สำเร็จ โปรดลองอีกครั้ง!"); history.back();</script>');
        }

        echo "<script>alert('เพิ่มแพ็คเกจสำเร็จ!');
        location.href='admin_package.php';</script>";

    } else {
        if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
            header("Location: admin_index.php");
        } else {
            header("Location: index.php");
        }
    }
?>