<?php require('connect.php'); ?>
<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) {
        extract($_POST);

        $durations = $_POST['duration'];
        if(isset($_POST['newgenre'])) {
            $newgenres = $_POST['newgenre'];
        }

        if(count($durations)>1) {
            $totalMinutes = 0;
        } else {
            $duration = $durations[0];
            list($minutes, $seconds) = explode(':', $duration);
            $totalMinutes = (int)$minutes + ((int)$seconds / 60);
            $totalMinutes = round($totalMinutes, 2);
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
                    $file_name = $title.time().'_file'. $i .'.'.$ext2;
                    if(move_uploaded_file($_FILES["file"]["tmp_name"][$i],'files/'.$file_name)) {
                        array_push($file_names, $file_name);
                    }
                }
                else {
                    die("<script> alert('อัปโหลดไม่สำเร็จ'); history.back(); </script>");
                }
            }
        }

        $sql = "INSERT INTO Media(media_title, media_desc, media_duration, media_release, media_rate, type_id, media_img, actors, directors, media_status)
                VALUES('$title', '$detail', '$totalMinutes', '$release', '$rate', '$t', '$pic', '$actor', '$director', 1)";
		$result = mysqli_query($dbcon, $sql);

        if(!$result) {
            echo mysqli_error($dbcon);
            die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!");</script>');
        }

        $media_id = mysqli_insert_id($dbcon);

        if(isset($newgenres)) {
            foreach($newgenres as $ng) {
                $sql3 = "INSERT INTO Genre(genre_name) VALUES('$ng')";
                $result3 = mysqli_query($dbcon, $sql3);

                $genre_id = mysqli_insert_id($dbcon);

                $sql2 = "INSERT INTO Medias_Genre(media_id, genre_id) VALUES('$media_id', '$genre_id')";
                $result2 = mysqli_query($dbcon, $sql2);
            }
        }

        $genre = array_unique($genre);
        foreach($genre as $g) {
            $sql2 = "INSERT INTO Medias_Genre(media_id, genre_id) VALUES('$media_id', '$g')";
            $result2 = mysqli_query($dbcon, $sql2);
        }

        if(!$result2) {
            die('<script>alert("บันทึกข้อมูลไม่สำเร็จ!"); window.location="add_media.php";</script>');
        }

        $ep = 1;
        foreach($file_names as $f) {
            $sql4 = "INSERT INTO Media_Files(media_id, file_name, episode) VALUES('$media_id', '$f', '$ep')";
            $result4 = mysqli_query($dbcon, $sql4);
            $ep++;
        }
		
		echo "<script>alert('บันทึกมีเดียสำเร็จ!');
        location.href='admin_media.php';</script>";
} else {
    header("Location: index.php");
} ?>