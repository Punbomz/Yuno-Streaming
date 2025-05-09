<?php require('connect.php');
    if(!isset($_SESSION['logined'])) {
        echo "<script>alert('กรุณาเข้าสู่ระบบ!');
        location.href='login.php';</script>";
        exit;
    }

    $sql = "SELECT COUNT(*) AS Episodes,
            m.media_id,
            m.media_title,
            m.media_desc,
            m.media_img,
            m.type_id,
            m.media_status,
            h.watch_length,
            h.episode
        FROM 
            History h
        JOIN 
            Media m ON h.media_id = m.media_id
        WHERE 
            h.user_id = '" . $_SESSION['user_id'] . "' AND m.media_status=1
        GROUP BY 
            m.media_id, h.episode
        ORDER BY 
            h.watch_date DESC";
    $result = $dbcon->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $media_items[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo web_title ?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo favicon; ?>">
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/mycss.css" rel="stylesheet">
    <style>
        .history-header {
            position: fixed;
            top: 70px; /* ปรับตามความสูง navbar */
            left: 0;
            right: 0;
            z-index: 10;
            padding: 20px 15%;
        }

        .history-header h1 {
            font-size: 48px;
            font-weight: bold;
            margin: 0;
            margin-bottom: 1px;
        }

        .history-scroll {
            position: absolute;
            top: 150px; /* ต้องไม่ชน navbar + header */
            left: 0;
            right: 0;
            bottom: 0;
            overflow-y: auto;
            padding: 20px 15%;
            color: white;
        }

        .history-item {
            display: flex;
            margin-bottom: 40px;
        }

        .history-item img {
            width: 300px;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        .history-info {
            margin-left: 30px;
        }

        .history-info h2 {
            font-size: 24px;
            font-weight: bold;
        }

        .history-info p {
            margin-top: 10px;
            color: #ccc;
        }

        .poster {
            transition: transform 0.4s ease-in-out;
        }

        .poster:hover {
            transform: scale(1.02);
            cursor: pointer;
        }

        .modalBg {
            background-size: cover;
            background-position: center;
            filter: blur(12px);
            height: 400px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1;
        }

        .modalBg::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px); /* รองรับ Safari */
            background-color: rgba(0, 0, 0, 0.4); /* ช่วยให้ข้อความเด่นขึ้น */
            z-index: 2;
        }

        .modalBg::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
            z-index: 3;
        }

        .text-truncate-multiline {
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn {
            transition: transform 0.4s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
            cursor: pointer;
        }
    </style>
</head>
<body class="dark-bg">
    <?php require('navbar.php') ?>

    <div class="history-header dark-bg mt-2" >
        <h1>History</h1>
    </div>

    <div class="history-scroll mt-5">
    <?php foreach ($media_items as $item) { ?>
        <div class="history-item poster" style="height: 250px;" data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $item['media_id']; ?>);">
        <img src="img/media/posters/<?php echo $item['media_img']; ?>" style="width: 180px; height: 250px; object-fit: cover;" alt="<?php echo htmlspecialchars($item['media_title']); ?>">
        <div class="history-info">
            <h2><?php echo htmlspecialchars($item['media_title']); ?></h2>
            <p class="text-truncate-multiline"><?php echo nl2br(htmlspecialchars($item['media_desc'])); ?></p>
            
            <!-- เพิ่มข้อมูลตอนที่และเวลา -->
            <strong><p class="mb-0" id="episode-<?php echo $item['media_id']; ?>">
                <?php
                    $duration = $item['watch_length'];
                    $totalSeconds = $duration;

                    if($item['type_id']==2) {
                        if($totalSeconds < 60) {
                            echo 'คุณดูไปแล้ว '.$totalSeconds.' วินาที';
                        } else if($totalSeconds < 3600) {
                            $m = floor($totalSeconds / 60);
                            $totalSeconds -= $m*60;
                            echo 'คุณดูไปแล้ว '.$m.' นาที '.$totalSeconds.' วินาที';
                        } else {
                            $m = floor($totalSeconds / 60);
                            $h = floor($totalSeconds / 3600);
                            echo 'คุณดูไปแล้ว '.$h.' ชั่วโมง '.$m.' นาที';
                        }
                    } else {
                        if($totalSeconds < 60) {
                            echo 'คุณดูตอนที่ '.$item['episode'].' ไปแล้ว '.$totalSeconds.' วินาที';
                        } else if($totalSeconds < 3600) {
                            $m = floor($totalSeconds / 60);
                            $totalSeconds -= $m*60;
                            echo 'คุณดูตอนที่ '.$item['episode'].' ไปแล้ว '.$m.' นาที '.$totalSeconds.' วินาที';
                        } else {
                            $m = floor($totalSeconds / 60);
                            $h = floor($totalSeconds / 3600);
                            echo 'คุณดูตอนที่ '.$item['episode'].' ไปแล้ว '.$h.' ชั่วโมง '.$m.' นาที';
                        }
                    }
                ?></p>
            <p class="" id="duration-<?php echo $item['media_id']; ?>"></p></strong>
        </div>
    </div>
    <?php } ?>
            <?php if (empty($media_items)) { ?>
                <p class="text-center">ไม่พบสื่อในระบบ</p>
            <?php } ?>
        </div>
    </div>

    <?php include('modals.php'); ?>

    <?php require('footer.php'); ?>

    <script src="js/bootstrap.bundle.js"></script>

    <script>
        function toggleWatchlist2(mediaId) {
            const iconSpan2 = document.getElementById('watchlist-icon2');

            fetch('add_watchlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(mediaId)
            })
            .then(response => response.text())
            .then(result => {
                if (result.trim() === 'added') {
                    iconSpan2.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                        </svg>`;
                } else if (result.trim() === 'removed') {
                    iconSpan2.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>`;
                }
            });
        }
        </script>

        <script>
        const iconSpan2 = document.getElementById('watchlist-icon2');

        function fetchMediaData(mediaId) {
            fetch('get_media_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'media_id=' + encodeURIComponent(mediaId)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('media-poster').src = "img/media/posters/" + data.media_img;
                document.getElementById('media-title').innerText = data.media_title;
                document.getElementById('media-desc').innerText = data.media_desc;
                document.getElementById('media-release').innerText = data.media_release;
                document.getElementById('media-rate').innerText = data.media_rate;
                document.getElementById('media-genre').innerText = data.genres;
                document.getElementById('media-director').innerText = 'ผู้กำกับ: ' + data.directors;
                document.getElementById('media-actor').innerText = 'นักแสดง: ' + data.actors;
                document.getElementById('media-bg').style="background-image: url('img/media/posters/"+ data.media_img + "');";

                document.getElementById('play-btn').onclick = function() {
                    window.location.href = "video.php?id=" + data.media_id + "&ep=" + data.episode;
                };

                document.getElementById('watchlist-btn2').onclick = function() {
                    toggleWatchlist2(data.media_id);
                };

                if (data.watched == true) {
                    document.getElementById('continue-p').innerText = data.continue;
                } else {
                    document.getElementById('continue-p').innerText = '';
                }

                if (data.type_id == 2) {
                    document.getElementById('duration-p').innerText = data.duration;
                } else {
                    document.getElementById('duration-p').innerText = data.duration + ' ตอน';
                }

                if (data.fav == true) {
                    iconSpan2.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                        </svg>`;
                } else {
                    iconSpan2.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>`;
                }
            });
        }
    </script>

</body>
</html>
