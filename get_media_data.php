<?php
    require('connect.php');
    header('Content-Type: application/json');

    if (isset($_SESSION['logined']) && isset($_POST['media_id'])) {
        $media_id = intval($_POST['media_id']);

        $sql = "SELECT * FROM Media WHERE media_id = '$media_id'";
        $result = mysqli_query($dbcon, $sql);

        if ($data = $result->fetch_assoc()) {

            $sql2 = "SELECT g.genre_name 
                    FROM Genre g 
                    INNER JOIN Medias_Genre mg ON g.genre_id = mg.genre_id 
                    WHERE mg.media_id = '$media_id' 
                    ORDER BY g.genre_name ASC";

            $result2 = mysqli_query($dbcon, $sql2);

            $genres = [];
            while ($row = mysqli_fetch_assoc($result2)) {
                $genres[] = $row['genre_name'];
            }

            $genres = implode(', ', $genres);
            $data['genres'] = $genres;
            
            $dateStr = $data['media_release'];
            $timestamp = strtotime($dateStr);

            if ($timestamp !== false) {
                $data['media_release'] = date("Y", $timestamp);
            } else {
                $data['media_release'] = 'ไม่ทราบปี';
            }

            $rate = ['สำหรับเด็ก', 'ทุกวัย', '13+', '15+', '18+'];
            $data['media_rate'] = $rate[$data['media_rate']];

            $sql_watch = "SELECT * FROM Watchlist WHERE media_id = '$media_id'";
            $result_watch = mysqli_query($dbcon, $sql_watch);
            if(mysqli_num_rows($result_watch)==0) {
                $data['fav'] = false;
            } else {
                $data['fav'] = true;
            }

            $sql_history = "SELECT episode, watch_length FROM History WHERE media_id = '$media_id' AND user_id='".$_SESSION['user_id']."' ORDER BY episode DESC";
            $result_history = mysqli_query($dbcon, $sql_history);
            $row_history = mysqli_fetch_assoc($result_history);
            if(mysqli_num_rows($result_history)==0) {
                $data['episode'] = 1;
                $data['watched'] = false;
            } else {
                $tmp_duration = $row_history['watch_length'];
                $minutes = floor($tmp_duration);
                $seconds = round(($tmp_duration - $minutes) * 60);
                $timeFormatted = sprintf('%02d.%02d', $minutes, $seconds);

                if($data['type_id']==2) {
                    $data['continue'] = 'คุณดูไปแล้ว '.$timeFormatted.' นาที';
                } else {
                    $data['continue'] = 'คุณดูตอนที่ '.$row_history['episode'].' ไปแล้ว '.$timeFormatted.' นาที';
                }
                $data['episode'] = $row_history['episode'];
                $data['watched'] = true;
            }

            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'ไม่พบข้อมูล']);
        }
} else {
    echo json_encode(['error' => 'unauthorized']);
}