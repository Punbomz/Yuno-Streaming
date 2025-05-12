<?php require('connect.php'); ?>
<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
        extract($_POST);
        extract($_GET);

        $sql = "DELETE FROM Media_Actor WHERE media_id = '$id'";
        $result = mysqli_query($dbcon, $sql);

        $sql = "DELETE FROM Media_Director WHERE media_id = '$id'";
        $result = mysqli_query($dbcon, $sql);

        $durations = $_POST['duration'];

        $totalMinutes = [];
        foreach($durations as $tmp_duration) {
            list($minutes, $seconds) = explode(':', $tmp_duration);
            $tmp2 = (int)$minutes + ((int)$seconds / 60);
            $tmp2 = round($tmp2, 2);
            array_push($totalMinutes, $tmp2);
        }

        if(isset($_FILES['poster']) && !empty($_FILES['poster']['name'])) {
            $sql_poster = "SELECT media_img FROM Media WHERE media_id='$id'";
            $result_poster = mysqli_query($dbcon, $sql_poster);
            $row_poster = mysqli_fetch_assoc($result_poster);
            $file_poster = 'img/media/posters/'.$row_poster['media_img'];

            if (file_exists($file_poster)) {
                unlink($file_poster);
            }

            $ext=pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
            $pic = $title.time().'_poster'.'.'.$ext;
            move_uploaded_file($_FILES["poster"]["tmp_name"],'img/media/posters/'.$pic);
        } else {
            $pic = $old_poster;
        }
        
        $sql_file = "SELECT file_name FROM Media_Files WHERE media_id='$id' ORDER BY episode ASC";
        $result_file = mysqli_query($dbcon, $sql_file);
        
        $row_file = [];
        foreach($result_file as $r) {
            array_push($row_file, $r['file_name']);
        }

        $file_names = [];
        if (!empty($_FILES['file']['name']) && isset($_FILES['file']['name'])) {
            for ($i = 0; $i < count($_FILES['file']['name']); $i++) {

                if ($_FILES['file']['error'][$i] === 0) {
                    // ถ้ามีไฟล์เดิม และชื่อไม่ตรงกับไฟล์ใหม่ -> ลบ
                    if (isset($row_file[$i]) && $row_file[$i] != $_FILES['file']['name'][$i]) {
                        $file_media = 'files/' . $row_file[$i];
                        if (file_exists($file_media)) {
                            unlink($file_media);
                        }
                    }

                    // อัปโหลดไฟล์ใหม่
                    $ext2 = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                    $file_name = $title . time() . '_ep' . ($i + 1) . '.' . $ext2;

                    if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], 'files/' . $file_name)) {
                        $file_names[] = $file_name;
                    } else {
                        die("<script> alert('อัปโหลดไม่สำเร็จ'); history.back(); </script>");
                    }

                } else {
                    // ไม่มีไฟล์ใหม่ ใช้ชื่อเดิม
                    if (isset($row_file[$i])) {
                        $file_names[] = $row_file[$i];
                    }
                }
            }
        } else {
            // ไม่ได้อัปโหลดใหม่เลย ใช้ไฟล์เดิมทั้งหมด
            $file_names = $row_file;
        }


        $sql = "UPDATE Media SET media_title = '$title', media_desc = '$detail', media_release = '$release', media_rate = '$rate', type_id = '$t', media_img = '$pic' WHERE media_id = '$id'";
		$result = mysqli_query($dbcon, $sql);

        if(!$result) {
            die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
        }

        $actor = explode(",", $actor);
        $actor = array_unique($actor);
        foreach($actor as $ac) {
            $sql = "INSERT INTO Media_Actor(media_id, actor_name) VALUES('$id', '$ac')";
            $result = mysqli_query($dbcon, $sql);
            if(!$result) {
                die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
            }
        }

        $director = explode(",", $director);
        $director = array_unique($director);
        foreach($director as $dc) {
            $sql = "INSERT INTO Media_Director(media_id, director_name) VALUES('$id', '$dc')";
            $result = mysqli_query($dbcon, $sql);
            if(!$result) {
                die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
            }
        }

        $sql_dgenre = "DELETE FROM Medias_Genre WHERE media_id='$id'";
        $result_dgenre = mysqli_query($dbcon, $sql_dgenre);

        if(isset($_POST['newgenre'])) {
            $newgenres = $_POST['newgenre'];
            
            $sql_genre = "SELECT genre_name FROM Genre";
            $result_genre = mysqli_query($dbcon, $sql_genre);
            $row_genre = [];

            foreach($result_genre as $g) {
                array_push($row_genre, $g['genre_name']);
            }
    
            $newgenres = array_unique($newgenres);
            if(isset($newgenres)) {
                foreach($newgenres as $ng) {
                    if(!in_array($ng, $row_genre)) {
                        $sql3 = "INSERT INTO Genre(genre_name) VALUES('$ng')";
                        $result3 = mysqli_query($dbcon, $sql3);
    
                        $genre_id = mysqli_insert_id($dbcon);
    
                        $sql2 = "INSERT INTO Medias_Genre(media_id, genre_id) VALUES('$id', '$genre_id')";
                        $result2 = mysqli_query($dbcon, $sql2);
                    }
                }
            }
        }

        $genre = array_unique($genre);
        foreach($genre as $g) {
            $sql2 = "INSERT INTO Medias_Genre(media_id, genre_id) VALUES('$id', '$g')";
            $result2 = mysqli_query($dbcon, $sql2);

            if(!$result2) {
                die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); history.back();</script>');
            }
        }


        $sql_dfile = "DELETE FROM Media_Files WHERE media_id='$id'";
        $result_dfile = mysqli_query($dbcon, $sql_dfile);

        $ep = 1;
        foreach($file_names as $f) {
            $sql4 = "INSERT INTO Media_Files(media_id, file_name, episode, media_duration) VALUES('$id', '$f', '$ep', '".$totalMinutes[$ep-1]."')";
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