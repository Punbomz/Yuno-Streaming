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
            $data['media_rate'] = $rate[$data['media_rate']-1];

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
                $duration = $row_history['watch_length'];
                $totalSeconds = $duration;

                if($data['type_id']==2) {
                    if($totalSeconds <= 0) {
                        $data['continue'] = '';
                    } else if($totalSeconds < 60) {
                        $data['continue'] = 'คุณดูไปแล้ว '.$totalSeconds.' วินาที';
                    } else if($totalSeconds < 3600) {
                        $m = floor($totalSeconds / 60);
                        $totalSeconds -= $m*60;
                        $data['continue'] = 'คุณดูไปแล้ว '.$m.' นาที '.$totalSeconds.' วินาที';
                    } else {
                        $m = floor($totalSeconds / 60);
                        $h = floor($totalSeconds / 3600);
                        $data['continue'] = 'คุณดูไปแล้ว '.$h.' ชั่วโมง '.$m.' นาที';
                    }
                } else {
                    if($totalSeconds <= 0) {
                        $data['continue'] = '';
                    } else if($totalSeconds < 60) {
                        $data['continue'] = 'คุณดูตอนที่ '.$row_history['episode'].' ไปแล้ว '.$totalSeconds.' วินาที';
                    } else if($totalSeconds < 3600) {
                        $m = floor($totalSeconds / 60);
                        $totalSeconds -= $m*60;
                        $data['continue'] = 'คุณดูตอนที่ '.$row_history['episode'].' ไปแล้ว '.$m.' นาที '.$totalSeconds.' วินาที';
                    } else {
                        $m = floor($totalSeconds / 60);
                        $h = floor($totalSeconds / 3600);
                        $data['continue'] = 'คุณดูตอนที่ '.$row_history['episode'].' ไปแล้ว '.$h.' ชั่วโมง '.$m.' นาที';
                    }
                }
                $data['episode'] = $row_history['episode'];
                $data['watched'] = true;
            }

            if($data['type_id']==2) {
                $sql_file = "SELECT media_duration FROM Media_Files WHERE media_id = '$media_id' AND episode=1";
                $result_file = mysqli_query($dbcon, $sql_file);
                $row_file = mysqli_fetch_assoc($result_file);
    
                $duration = $row_file['media_duration'];
                $totalSeconds = round($duration * 60);
                
                if($totalSeconds < 60) {
                    $data['duration'] = $totalSeconds.' วินาที';
                } else if($totalSeconds < 3600) {
                    $m = floor(($totalSeconds % 3600) / 60);
                    $totalSeconds -= ($m * 60);
                    $data['duration'] = $m.' นาที '.$totalSeconds.' วินาที';
                } else {
                    $h = floor($totalSeconds / 3600);
                    $m = floor(($totalSeconds % 3600) / 60);
                    $data['duration'] = $h.' ชั่วโมง '.$m.' นาที';
                }
            } else {
                $sql_file = "SELECT COUNT(*) AS Episodes FROM Media_Files WHERE media_id = '$media_id'";
                $result_file = mysqli_query($dbcon, $sql_file);
                $row_file = mysqli_fetch_assoc($result_file);
                $data['duration'] = $row_file['Episodes']." ตอน";
            }

            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'ไม่พบข้อมูล']);
        }
} else {
    echo json_encode(['error' => 'unauthorized']);
}