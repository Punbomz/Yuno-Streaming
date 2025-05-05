<?php require('connect.php'); ?>

<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
    $id = $_GET['id'];
    $st = $_GET['t'];

    $sql = "UPDATE Media SET media_status='$st' WHERE media_id='$id'";
    $result = mysqli_query($dbcon, $sql);

    if(!$result) {
        die('<script>alert("ดำเนินการไม่สำเร็จ!"); history.back();</script>');
    }

    echo "<script>alert('ดำเนินการสำเร็จ!');
    location.href='admin_media.php';</script>";

} else {
    header("Location: index.php");
} ?>