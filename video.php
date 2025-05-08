<?php require('connect.php') ?>

<?php if(isset($_SESSION['logined'])) { ?>

    <!DOCTYPE html>
    <html lang="th">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo web_title ?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo favicon; ?>">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/mycss.css" rel="stylesheet">
    </head>

    <body class="dark-bg mt-5">
        <?php require('navbar.php') ?>

        <?php
            extract($_GET);

            $user_id = $_SESSION['user_id'];
            $ep_now = isset($ep) ? $ep : 1;

            $sql_progress = "SELECT watch_length FROM History 
                            WHERE user_id = '$user_id' 
                            AND media_id = '$id' 
                            AND episode = '$ep_now'";
            $res_progress = mysqli_query($dbcon, $sql_progress);
            $row_progress = mysqli_fetch_assoc($res_progress);
            $start_time = isset($row_progress['watch_length']) ? (int)$row_progress['watch_length'] : 0;

            $sql = "SELECT m.media_title, m.media_id, f.* FROM Media m INNER JOIN Media_Files f ON m.media_id=f.media_id WHERE m.media_id = '$id' ORDER BY f.episode ASC";
            $result = mysqli_query($dbcon, $sql);
            $row = mysqli_fetch_assoc($result);
            $num = mysqli_num_rows($result);
        ?>

        <div class="container mt-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="text-white"><?php echo $row['media_title']; ?></h3>
                </div>
                <?php if($num>1) { ?>
                    <div class="col d-flex justify-content-end">
                        <select name='ep' class="form-select w-25 text-center" onchange="window.location.href='video.php?id=<?php echo $id; ?>&ep='+ this.value;">
                            <?php $i=1; foreach($result as $row) { ?>
                                <option value="<?php echo $i; ?>" <?php if($i==$ep) echo 'selected'; ?>>ตอน <?php echo $i; ?></option>
                            <?php $i++; } ?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            
            <div class="video-container mt-3">
                <video id="videoPlayer" width="100%" height="auto" controls autoplay>
                    <source src="files/<?php echo $row['file_name']; ?>" type="video/mp4">
                    เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
                </video>
            </div>
        </div>

        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap.bundle.js"></script>

        <script>
            const video = document.getElementById('videoPlayer');
            const mediaId = <?php echo json_encode($id); ?>;
            const episode = <?php echo json_encode(isset($ep) ? $ep : 1); ?>;
            const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
            const startTime = <?php echo json_encode($start_time); ?>;

            let intervalId;

            // โหลด progress เดิม
            video.addEventListener('loadedmetadata', () => {
                if (startTime > 0 && startTime < video.duration) {
                    video.currentTime = startTime;
                }
            });

            // ส่ง progress ครั้งแรก
            window.onload = function () {
                sendProgress(startTime);
            }

            video.addEventListener('play', () => {
                clearInterval(intervalId);
                intervalId = setInterval(() => {
                    if (!video.paused && !video.ended) {
                        const currentTime = Math.floor(video.currentTime);
                        sendProgress(currentTime);
                    }
                }, 5000); // ทุก 5 วินาที
            });

            const stopAndSend = () => {
                clearInterval(intervalId);
                const currentTime = Math.floor(video.currentTime);
                sendProgress(currentTime);
            }

            video.addEventListener('pause', stopAndSend);
            video.addEventListener('ended', stopAndSend);

            function sendProgress(time) {
                fetch('save_progress.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `media_id=${mediaId}&episode=${episode}&time=${time}&user_id=${userId}`
                }).catch((err) => console.warn("ไม่สามารถส่ง progress ได้:", err));
            }
        </script>

        <?php require('footer.php'); ?>
    </body>
    </html>

<?php } else {
    echo "<script>alert('กรุณาเข้าสู่ระบบ!');
    location.href='index.php';</script>";
} ?>