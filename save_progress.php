<?php
    require('connect.php');

    $media_id = $_POST['media_id'];
    $episode = $_POST['episode'];
    $time = $_POST['time'];
    $user_id = $_POST['user_id'];

    $sql = "INSERT INTO History (user_id, media_id, episode, watch_length)
            VALUES ('$user_id', '$media_id', '$episode', '$time')
            ON DUPLICATE KEY UPDATE watch_length = '$time'";

    mysqli_query($dbcon, $sql);
?>