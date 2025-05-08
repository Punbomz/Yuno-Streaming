<?php
require('connect.php');

if(isset($_SESSION['logined'])) {
    $media_id = $_POST['media_id'];
    $episode = $_POST['episode'];
    $time = $_POST['time'];
    
    $sql = "REPLACE INTO History (user_id, media_id, episode, watch_length) VALUES ('$user_id', '$media_id', '$episode', '$time')";
    mysqli_query($dbcon, $sql);
}

?>