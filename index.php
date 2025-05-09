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
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/mycss.css" rel="stylesheet">

        <style>
            .text-truncate-multiline {
                display: -webkit-box;
                -webkit-line-clamp: 5;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .poster {
                transition: transform 0.4s ease-in-out;
            }

            .poster:hover {
                transform: scale(1.05);
                cursor: pointer;
            }

            .btn {
                transition: transform 0.4s ease-in-out;
            }

            .btn:hover {
                transform: scale(1.05);
                cursor: pointer;
            }

            .scroll-container {
                display: flex;
                overflow-x: auto;
                gap: 30px;
                -ms-overflow-style: none;
                scrollbar-width: none;
                scroll-behavior: smooth;
                padding: 10px;
                min-width: 100%;
            }

            .scroll-container::-webkit-scrollbar {
                display: none;
            }

            .poster-wrapper {
                flex-shrink: 0;
                height: 25vh;
                width: 200px;
                display: inline-block;
            }

            .scroll-btn {
                background-color: rgba(0,0,0,0.5);
                border: none;
                color: white;
                font-size: 2rem;
                cursor: pointer;
                z-index: 10;
                position: absolute;
                top: 40%;
                transform: translateY(-50%);
                padding: 5px 10px;
                border-radius: 5px;
                z-index: 9999;
            }

            .scroll-btn-left {
                left: 10px;
                z-index: 2;
            }

            .scroll-btn-right {
                right: 10px;
                z-index: 2;
            }

            .scroll-wrapper {
                position: relative;
            }

            .bg-blur-fade {
                position: relative;
                background-size: cover;
                background-position: center;
                overflow: hidden;
                z-index: 1;
            }

            .bg-blur-fade::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px); /* รองรับ Safari */
                background-color: rgba(0, 0, 0, 0.4); /* ช่วยให้ข้อความเด่นขึ้น */
                z-index: 2;
            }

            .bg-blur-fade::after {
                content: '';
                position: absolute;
                bottom: 0; left: 0; right: 0;
                height: 100px;
                background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
                z-index: 3;
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
        </style>
    </head>

    <body class="dark-bg">
        <?php require('navbar.php') ?>

        <?php
            $sql_rand = "SELECT * FROM Media WHERE media_status=1 ORDER BY RAND() LIMIT 1";
            $result_rand = mysqli_query($dbcon, $sql_rand);
            $row_rand = mysqli_fetch_assoc($result_rand);
            $num_rand = mysqli_num_rows($result_rand);

            $sql_list = "SELECT w.*, m.* FROM Watchlist w INNER JOIN Media m ON w.media_id=m.media_id WHERE m.media_status=1 AND w.user_id='".$_SESSION['user_id']."'";
            $result_list = mysqli_query($dbcon, $sql_list);

            $watchlist = [];
            foreach($result_list as $wl) {
                $watchlist[] = $wl['media_id'];
            }
            $jsonWatchlist = json_encode($watchlist);

            $sql_type = "SELECT * FROM Type ORDER BY type_name ASC";
            $result_type = mysqli_query($dbcon, $sql_type);
        ?>

        <div class="p-5 bg-blur-fade" <?php if($num_rand!=0) { ?> style="background-image: url('img/media/posters/<?php echo $row_rand['media_img']; ?>');" <?php } ?>>
            <div class="container justify-content-center mt-4" style="position: relative; z-index: 4; color: white;">
                <div class="row justify-content-center align-items-center">
                <?php if($num_rand!=0) { ?>
                    <div class="col-md-6 text-center">
                        <img id="movie-img" src="img/media/posters/<?php echo $row_rand['media_img']; ?>" class="rounded-3 poster shadow" style="height: 50vh;"
                        data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $row_rand['media_id']; ?>);">
                    </div>
                    <div class="col-md-6">
                        <div class="row mt-5">
                            <h1 id="movie-title"><?php echo $row_rand['media_title']; ?></h1>
                            <p id="movie-desc" class="mt-4 text-truncate-multiline"><?php echo $row_rand['media_desc']; ?></p>
                        </div>
        
                        <div class="row justify-content-center">
                            <button class="btn btn-warning m-4 shadow" style="width: 180px; height: 50px;" onclick="window.location.href='video.php?id=<?php echo $row_rand['media_id']; ?>&ep=1'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                </svg>
                            </button>
                            <button class="btn btn-light m-4 shadow" style="width: 180px; height: 50px;" onclick="toggleWatchlist(<?php echo $row_rand['media_id']; ?>)">
                                <span id="watchlist-icon">
                                    <?php if(!in_array($row_rand['media_id'], $watchlist)) { ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                        </svg>
                                    <?php } else { ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                        </svg>
                                    <?php } ?>
                                </span>
                                รายการของฉัน
                            </button>
                        </div>
                    </div>
                <?php } else { ?>
                    <h1 class="text-center mt-3">ยินดีต้อนรับเข้าสู่ Yuno!</h1>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="p-5">
            <?php if($num_rand!=0) { ?>
            
                <?php
                    $sql_top = "SELECT m.*, h.view_count FROM Media m
                                JOIN (SELECT media_id, COUNT(*) AS view_count FROM History GROUP BY media_id) h ON m.media_id = h.media_id WHERE m.media_status=1 ORDER BY h.view_count DESC LIMIT 10";
                    $result_top = mysqli_query($dbcon, $sql_top);

                    $sql_history = "SELECT m.* FROM Media m
                                LEFT JOIN History h ON m.media_id = h.media_id WHERE m.media_status=1 AND h.user_id='".$_SESSION['user_id']."' ORDER BY h.watch_date DESC LIMIT 20";
                    $result_history = mysqli_query($dbcon, $sql_history);

                    $sql_latest = "SELECT * FROM Media WHERE media_status=1 ORDER BY media_id DESC LIMIT 20";
                    $result_latest = mysqli_query($dbcon, $sql_latest);
                ?>
                <?php if(mysqli_num_rows($result_top)!=0) { ?>
                    <div class="mb-5">
                        <a href="discover.php?t=hit" class="text-decoration-none text-white"><h3>อันดับสูงสุดวันนี้</h3></a>
                        <div class="scroll-wrapper mt-3">
                            <button class="scroll-btn scroll-btn-left" data-target="scroll-container-1" data-direction="left">&#10094;</button>
                            <button class="scroll-btn scroll-btn-right" data-target="scroll-container-1" data-direction="right">&#10095;</button>

                            <div id="scroll-container-1" class="scroll-container">
                                <?php foreach($result_top as $t) { ?> 
                                    <div class="poster-wrapper">
                                        <img src="img/media/posters/<?php echo $t['media_img']; ?>" 
                                            class="rounded-3 poster shadow" 
                                            style="width: 180px; height: 250px; object-fit: cover;"
                                            data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $t['media_id']; ?>);">
                                    </div>
                                <?php } ?>
                            </div>
                    </div>
                <?php } ?>

                <?php if(mysqli_num_rows($result_history)!=0) { ?>
                    <div class="mb-5 mt-5">
                        <a href="watchlist.php" class="text-decoration-none text-white"><h3>รับชมต่อ</h3></a>
                        <div class="scroll-wrapper mt-3">
                            <button class="scroll-btn scroll-btn-left" data-target="scroll-container-2" data-direction="left">&#10094;</button>
                            <button class="scroll-btn scroll-btn-right" data-target="scroll-container-2" data-direction="right">&#10095;</button>

                            <div id="scroll-container-2" class="scroll-container">
                                <?php foreach($result_history as $h) { ?> 
                                    <div class="poster-wrapper">
                                        <img src="img/media/posters/<?php echo $h['media_img']; ?>" 
                                            class="rounded-3 poster shadow" 
                                            style="width: 180px; height: 250px; object-fit: cover;"
                                            data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $h['media_id']; ?>);">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if(mysqli_num_rows($result_list)!=0) { ?>
                    <div class="mb-5 mt-5">
                        <a href="watchlist.php" class="text-decoration-none text-white"><h3>รายการของฉัน</h3></a>
                        <div class="scroll-wrapper mt-3">
                            <button class="scroll-btn scroll-btn-left" data-target="scroll-container-3" data-direction="left">&#10094;</button>
                            <button class="scroll-btn scroll-btn-right" data-target="scroll-container-3" data-direction="right">&#10095;</button>

                            <div id="scroll-container-3" class="scroll-container">
                                <?php foreach($result_list as $wa) { ?> 
                                    <div class="poster-wrapper">
                                        <img src="img/media/posters/<?php echo $wa['media_img']; ?>" 
                                            class="rounded-3 poster shadow" 
                                            style="width: 180px; height: 250px; object-fit: cover;"
                                            data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $h['media_id']; ?>);">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                    <div class="mb-5 mt-5">
                        <a href="discover.php?t=new" class="text-decoration-none text-white"><h3>มาใหม่ล่าสุด</h3></a>
                        <div class="scroll-wrapper mt-3">
                            <button class="scroll-btn scroll-btn-left" data-target="scroll-container-4" data-direction="left">&#10094;</button>
                            <button class="scroll-btn scroll-btn-right" data-target="scroll-container-4" data-direction="right">&#10095;</button>

                            <div id="scroll-container-4" class="scroll-container">
                                <?php foreach($result_latest as $l) { ?> 
                                    <div class="poster-wrapper">
                                        <img src="img/media/posters/<?php echo $l['media_img']; ?>" 
                                            class="rounded-3 poster shadow" 
                                            style="width: 180px; height: 250px; object-fit: cover;"
                                            data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $l['media_id']; ?>);">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php
                        $i = 5;
                        foreach($result_type as $type) {

                            $sql_t = "SELECT * FROM Media WHERE media_status=1 AND type_id='".$type['type_id']."' ORDER BY media_id DESC";
                            $result_t = mysqli_query($dbcon, $sql_t);
                    ?>
                        <?php if(mysqli_num_rows($result_t) != 0) { ?>
                            <div class="mb-5 mt-5">
                                <a href="discover.php?t=<?php echo $type['type_id']; ?>" class="text-decoration-none text-white"><h3><?php echo $type['type_name']; ?>แนะนำ</h3></a>
                                <div class="scroll-wrapper mt-3">
                                    <button class="scroll-btn scroll-btn-left" data-target="scroll-container-<?php echo $i; ?>" data-direction="left">&#10094;</button>
                                    <button class="scroll-btn scroll-btn-right" data-target="scroll-container-<?php echo $i; ?>" data-direction="right">&#10095;</button>

                                    <div id="scroll-container-<?php echo $i; ?>" class="scroll-container">
                                        <?php foreach($result_t as $tt) { ?> 
                                            <div class="poster-wrapper">
                                                <img src="img/media/posters/<?php echo $tt['media_img']; ?>" 
                                                    class="rounded-3 poster shadow" 
                                                    style="width: 180px; height: 250px; object-fit: cover;"
                                                    data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $tt['media_id']; ?>);">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                    <?php } $i++; } ?>

            <?php } else { ?>
                <h2 class="text-center mt-5">โปรดรอติดตามเร็วๆนี้...</h2>
            <?php } ?>
        </div>

        <?php include('modals.php'); ?>

        <script src="js/bootstrap.bundle.js"></script>

        <script>
            document.querySelectorAll('.scroll-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    const direction = btn.getAttribute('data-direction');
                    const container = document.getElementById(targetId);

                    if (container) {
                        const scrollAmount = 300;
                        container.scrollLeft += (direction === 'right' ? scrollAmount : -scrollAmount);
                    }
                });
            });
        </script>

        <script>
            function toggleWatchlist(mediaId) {
                const iconSpan = document.getElementById('watchlist-icon');

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
                        iconSpan.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                            </svg>`;
                    } else if (result.trim() === 'removed') {
                        iconSpan.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>`;
                    }
                });
            }

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
                    console.log(data);
                    document.getElementById('media-poster').src = "img/media/posters/" + data.media_img;
                    document.getElementById('media-title').innerText = data.media_title;
                    document.getElementById('media-desc').innerText = data.media_desc;
                    document.getElementById('media-release').innerText = data.media_release;
                    document.getElementById('media-rate').innerText = data.media_rate;
                    document.getElementById('media-genre').innerText = data.genres;
                    document.getElementById('media-director').innerText = 'ผู้กำกับ: ' + data.directors;
                    document.getElementById('media-actor').innerText = 'นักแสดง: ' + data.actors;
                    document.getElementById('media-bg').style="background-image: url('img/media/posters/"+ data.media_img + "');";
                    document.getElementById('duration-p').innerText = data.duration;

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

        <?php require('footer.php'); ?>

    </body>
    </html>

<?php } else {
    echo "<script>alert('กรุณาเข้าสู่ระบบ!');
    location.href='login.php';</script>";
} ?>