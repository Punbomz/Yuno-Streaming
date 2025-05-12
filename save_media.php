<?php require('connect.php'); ?>
<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
        extract($_POST);

        $durations = $_POST['duration'];

        $totalMinutes = [];
        foreach($durations as $tmp_duration) {
            list($minutes, $seconds) = explode(':', $tmp_duration);
            $tmp2 = (int)$minutes + ((int)$seconds / 60);
            $tmp2 = round($tmp2, 2);
            array_push($totalMinutes, $tmp2);
        }

        if(isset($_FILES['poster']) && !empty($_FILES['poster']['name'])) {
            $ext=pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
            $pic = $title.time().'_poster'.'.'.$ext;
            move_uploaded_file($_FILES["poster"]["tmp_name"],'img/media/posters/'.$pic);
        }

        $file_names = [];
        if (!empty($_FILES['file']['name'][0])) {
            foreach ($_FILES['file']['name'] as $i => $name) {
                if ($_FILES['file']['error'][$i] === 0) {
                    $ext2 = pathinfo($name, PATHINFO_EXTENSION);
                    $file_name = $title.time().'_ep'. ($i + 1) .'.'.$ext2;
                    if(move_uploaded_file($_FILES["file"]["tmp_name"][$i],'files/'.$file_name)) {
                        array_push($file_names, $file_name);
                    } else {
                        die("<script> alert('อัปโหลดไม่สำเร็จ'); history.back(); </script>");
                    }
                }
                else {
                    die("<script> alert('อัปโหลดไม่สำเร็จ'); history.back(); </script>");
                }
            }
        }

        $sql = "INSERT INTO Media(media_title, media_desc, media_release, media_rate, type_id, media_img, media_status)
                VALUES('$title', '$detail', '$release', '$rate', '$t', '$pic', 1)";
		$result = mysqli_query($dbcon, $sql);
        
        if(!$result) {
            die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
        }

        $media_id = mysqli_insert_id($dbcon);
        
        $actor = explode(",", $actor);
        $actor = array_unique($actor);
        foreach($actor as $ac) {
            $sql = "INSERT INTO Media_Actor(media_id, actor_name) VALUES('$media_id', '$ac')";
            $result = mysqli_query($dbcon, $sql);
            if(!$result) {
                die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
            }
        }

        $director = explode(",", $director);
        $director = array_unique($director);
        foreach($director as $dc) {
            $sql = "INSERT INTO Media_Director(media_id, director_name) VALUES('$media_id', '$dc')";
            $result = mysqli_query($dbcon, $sql);
            if(!$result) {
                die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
            }
        }

        if(isset($_POST['newgenre'])) {
            $newgenres = $_POST['newgenre'];
            
            $sql_genre = "SELECT genre_name FROM Genre";
            $result_genre = mysqli_query($dbcon, $sql_genre);
            $row_genre = mysqli_fetch_assoc($result_genre);
    
            $newgenres = array_unique($newgenres);
            if(isset($newgenres)) {
                foreach($newgenres as $ng) {
                    if(!in_array($ng, $row_genre)) {
                        $sql3 = "INSERT INTO Genre(genre_name) VALUES('$ng')";
                        $result3 = mysqli_query($dbcon, $sql3);
    
                        $genre_id = mysqli_insert_id($dbcon);
    
                        $sql2 = "INSERT INTO Medias_Genre(media_id, genre_id) VALUES('$media_id', '$genre_id')";
                        $result2 = mysqli_query($dbcon, $sql2);
                    }
                }
            }
        }

        $genre = array_unique($genre);
        foreach($genre as $g) {
            $sql2 = "INSERT INTO Medias_Genre(media_id, genre_id) VALUES('$media_id', '$g')";
            $result2 = mysqli_query($dbcon, $sql2);

            if(!$result2) {
                die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
            }
        }

        $ep = 1;
        foreach($file_names as $f) {
            $sql4 = "INSERT INTO Media_Files(media_id, file_name, episode, media_duration) VALUES('$media_id', '$f', '$ep', '".$totalMinutes[$ep-1]."')";
            $result4 = mysqli_query($dbcon, $sql4);
            $ep++;

            if(!$result4) {
                die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
            }
        }
		
		echo "<script>alert('บันทึกมีเดียสำเร็จ!');
        location.href='admin_media.php';</script>";
} else {
    echo "<script>location.href='index.php';</script>";
    exit;
} ?>