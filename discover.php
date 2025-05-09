<?php require('connect.php');
    if(!isset($_SESSION['logined'])) {
        echo "<script>alert('กรุณาเข้าสู่ระบบ!');
        location.href='login.php';</script>";
        exit;
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
        .discover-header {
            position: fixed;
            top: 70px; /* ปรับตามความสูง navbar */
            left: 0;
            right: 0;
            z-index: 10;
            padding: 20px 15%;
        }

        .discover-header h1 {
            font-size: 48px;
            font-weight: bold;
            margin: 0;
            margin-bottom: 1px;
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
<div class="m-5 justify-content-center">

    <?php
        extract($_GET);

        $sql_all = "SELECT * FROM Media WHERE media_status=1 ORDER BY RAND() LIMIT 20";
        $sql_srch = "SELECT m.* FROM Media m INNER JOIN Medias_Genre mg ON m.media_id=mg.media_id WHERE m.media_status=1";
        if(isset($srch) and $srch!="") {
            $sql_srch .= " AND m.media_title LIKE '%$srch%'";
        }
        if(isset($g) and $g!="") {
            $sql_srch .= " AND mg.genre_id = '$g'";
        }
        if(isset($t) and $t!="") {
            $sql_srch .= " AND m.type_id='$t'";
        }
        $sql_srch .= " GROUP BY m.media_id";

        $sql_genre = "SELECT * FROM Genre ORDER BY genre_name ASC";
        $result_genre = mysqli_query($dbcon, $sql_genre);

        $sql_type = "SELECT * FROM Type ORDER BY type_name ASC";
        $result_type = mysqli_query($dbcon, $sql_type);

        $sql_type_name = "SELECT type_name FROM Type WHERE type_id = '$t'";
        $result_type_name = mysqli_query($dbcon, $sql_type_name);
        $row_type_name = mysqli_fetch_assoc($result_type_name);

        if((!isset($t) or $t=="") or (isset($t) and $t=='hit')) {
            $first = 'อันดับสูงสุดวันนี้';
            $sql = "SELECT m.*, h.view_count FROM Media m
                        JOIN (SELECT media_id, COUNT(*) AS view_count FROM History GROUP BY media_id) h ON m.media_id = h.media_id WHERE m.media_status=1 ORDER BY h.view_count DESC LIMIT 10";
        } else if($t=='new') {
            $first = 'มาใหม่ล่าสุด';
            $sql = "SELECT * FROM Media m INNER JOIN Medias_Genre mg ON m.media_id=mg.media_id WHERE m.media_status=1";
            if(isset($g) and $g!="") {
                $sql .= " AND mg.genre_id = '$g'";
            }
            $sql .= " ORDER BY m.media_id DESC";
            $sql_srch .= " ORDER BY m.media_id DESC";
        } else {
            $first = $row_type_name['type_name'].'อันดับสูงสุดวันนี้';
            $sql = "SELECT m.*, h.view_count FROM Media m
                        JOIN (SELECT media_id, COUNT(*) AS view_count FROM History GROUP BY media_id) h ON m.media_id = h.media_id WHERE m.type_id='$t' AND m.media_status=1 ORDER BY h.view_count DESC LIMIT 10";
        }
        
        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);

        $sql_latest = "SELECT * FROM Media WHERE media_status=1 ORDER BY media_id DESC LIMIT 20";
        $result_latest = mysqli_query($dbcon, $sql_latest);

        $result_all = mysqli_query($dbcon, $sql_all);
        $num_all = mysqli_num_rows($result_all);

        $result_srch  = mysqli_query($dbcon, $sql_srch);
    ?>

    <div class="row align-items-center justify-content-between mb-3 mt-5">
        <div class="col-auto mt-5">
            <h1 class="mb-0">Discover</h1>
        </div>
        <div class="col-auto d-flex gap-3 mt-5">
            <select name="t" class="form-select text-center" style="width: 200px;" 
                onchange="window.location.href='discover.php?srch=<?php echo $_GET['srch']; ?>&g=<?php echo $_GET['g']; ?>&t=' + this.value;">
                <option value="">ประเภท</option>
                <?php foreach($result_type as $type) { ?>
                    <option value="<?php echo $type['type_id']; ?>" <?php if($type['type_id']==$t) echo 'selected'; ?>>
                        <?php echo $type['type_name']; ?>
                    </option>
                <?php } ?>
            </select>

            <select name="g" class="form-select text-center" style="width: 200px;" 
                onchange="window.location.href='discover.php?srch=<?php echo $_GET['srch']; ?>&t=<?php echo $_GET['t']; ?>&g=' + this.value;">
                <option value="">หมวดหมู่</option>
                <?php foreach($result_genre as $genre) { ?>
                    <option value="<?php echo $genre['genre_id']; ?>" <?php if($genre['genre_id']==$g) echo 'selected'; ?>>
                        <?php echo $genre['genre_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    
    <div class="p-5">
        <?php if($num_all!=0) { ?>

            <?php if(!isset($srch) or $srch=="") { ?>
                <?php if($num!=0) { ?>
                    <?php if($t != 'new' and (!isset($g) or $g=="")) { ?>
                        
                        <!-- อันดับสูงสุด -->
                        <div class="mb-5">
                            <a href="discover.php?t=hit&srch=<?php echo $_GET['srch']; ?>&g=<?php echo $_GET['g']; ?>" class="text-decoration-none text-white"><h3><?php echo $first; ?></h3></a>
                            <div class="scroll-wrapper mt-3">
                                <button class="scroll-btn scroll-btn-left" data-target="scroll-container-1" data-direction="left">&#10094;</button>
                                <button class="scroll-btn scroll-btn-right" data-target="scroll-container-1" data-direction="right">&#10095;</button>

                                <div id="scroll-container-1" class="scroll-container">
                                    <?php foreach($result as $m) { ?> 
                                        <div class="poster-wrapper">
                                            <img src="img/media/posters/<?php echo $m['media_img']; ?>" 
                                                class="rounded-3 poster shadow" 
                                                style="width: 180px; height: 250px; object-fit: cover;"
                                                data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $m['media_id']; ?>);">
                                        </div>
                                    <?php } ?>
                                </div>
                        </div>
                    <?php } if(isset($t) and $t=='new') { ?>

                        <!-- มาใหม่ล่าสุด -->
                        <div class="mb-5 mt-5">
                            <a href="discover.php?t=new&srch=<?php echo $_GET['srch']; ?>&g=<?php echo $_GET['g']; ?>" class="text-decoration-none text-white"><h3>มาใหม่ล่าสุด</h3></a>
                            <div class="scroll-wrapper mt-3">
                                <button class="scroll-btn scroll-btn-left" data-target="scroll-container-3" data-direction="left">&#10094;</button>
                                <button class="scroll-btn scroll-btn-right" data-target="scroll-container-3" data-direction="right">&#10095;</button>

                                <div id="scroll-container-3" class="scroll-container">
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
                    <?php } ?>
                <?php } ?>

                <!-- ประเภท -->
                    <?php
                        $i = 4;
                        foreach($result_type as $type) {
                            $sql_t = "SELECT m.* FROM Media m LEFT JOIN Medias_Genre mg ON m.media_id = mg.media_id WHERE m.media_status=1";
                            if(isset($g) and $g!="") {
                                $sql_t .= " AND mg.genre_id = '$g'";
                            }
                            if(isset($t) and $t!="" and $t!="new" and $t!='hit') {
                                if($type['type_id']!=$t) {
                                    continue;
                                }
                            }
                            $sql_t .= " AND m.type_id='".$type['type_id']."'";
                            $sql_t .= " GROUP BY m.media_id ORDER BY m.media_id DESC";
                            $result_t = mysqli_query($dbcon, $sql_t);
                    ?>
                        <?php if(mysqli_num_rows($result_t) != 0) { ?>
                            <div class="mb-5 <?php if($num!=0 and (!isset($g) or $g=="")) echo 'mt-5'; ?>">
                                <a href="discover.php?t=<?php echo $type['type_id']; ?>&srch=<?php echo $_GET['srch']; ?>&g=<?php echo $_GET['g']; ?>" class="text-decoration-none text-white"><h3><?php echo $type['type_name']; ?>แนะนำ</h3></a>
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

                    <!-- หมวดหมู่ -->
                    <?php
                        foreach($result_genre as $genre) {
                            $sql_g = "SELECT * FROM Medias_Genre mg INNER JOIN Media m ON mg.media_id=m.media_id WHERE m.media_status=1";
                            if(isset($t) and $t!="" and $t!='hit' and $t!='new') {
                                $sql_g .= " AND m.type_id = '$t'";
                            }
                            if(isset($g) and $g!="") {
                                if($genre['genre_id']!=$g) {
                                    continue;
                                }
                            }
                            $sql_g .= " AND mg.genre_id='".$genre['genre_id']."'";
                            $sql_g .= " GROUP BY m.media_id ORDER BY m.media_id DESC";
                            $result_g = mysqli_query($dbcon, $sql_g);
                    ?>
                        <?php if(mysqli_num_rows($result_g) != 0) { ?>
                            <div class="mb-5 <?php if(mysqli_num_rows($result_t) != 0) echo 'mt-5'; ?>">
                                <a href="discover.php?g=<?php echo $genre['genre_id']; ?>&srch=<?php echo $_GET['srch']; ?>&t=<?php echo $_GET['t']; ?>" class="text-decoration-none text-white"><h3><?php echo $genre['genre_name']; ?></h3></a>
                                <div class="scroll-wrapper mt-3">
                                    <button class="scroll-btn scroll-btn-left" data-target="scroll-container-<?php echo $i; ?>" data-direction="left">&#10094;</button>
                                    <button class="scroll-btn scroll-btn-right" data-target="scroll-container-<?php echo $i; ?>" data-direction="right">&#10095;</button>

                                    <div id="scroll-container-<?php echo $i; ?>" class="scroll-container">
                                        <?php foreach($result_g as $gg) { ?> 
                                            <div class="poster-wrapper">
                                                <img src="img/media/posters/<?php echo $gg['media_img']; ?>" 
                                                    class="rounded-3 poster shadow" 
                                                    style="width: 180px; height: 250px; object-fit: cover;"
                                                    data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $gg['media_id']; ?>);">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } $i++; } ?>
            <?php } ?>
            
            <!-- ทั้งหมด -->
            <?php if(mysqli_num_rows($result_srch)!=0 and isset($srch) and $srch!="") { ?>
                <div class="mb-5">
                    <ul class="list-unstyled d-flex flex-wrap justify-content-center mt-4" style="gap: 60px;">
                        <?php foreach($result_srch as $sc) { ?> 
                            <li style="height: 25vh;">
                                <img src="img/media/posters/<?php echo $sc['media_img']; ?>" 
                                    class="rounded-3 poster shadow" 
                                    style="width: 180px; height: 250px; object-fit: cover;"
                                    data-bs-toggle="modal" data-bs-target="#movieModal" 
                                    onclick="fetchMediaData(<?php echo $sc['media_id']; ?>);">
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <!-- เรื่องที่อาจสนใจ -->
            <div class="mb-5">
                <h3>เรื่องที่คุณอาจสนใจ</h3>
                <div class="scroll-wrapper mt-3">
                    <button class="scroll-btn scroll-btn-left" data-target="scroll-container-<?php echo $i; ?>" data-direction="left">&#10094;</button>
                    <button class="scroll-btn scroll-btn-right" data-target="scroll-container-<?php echo $i; ?>" data-direction="right">&#10095;</button>

                    <div id="scroll-container-<?php echo $i; ?>" class="scroll-container">
                        <?php foreach($result_all as $a) { ?> 
                            <div class="poster-wrapper">
                                <img src="img/media/posters/<?php echo $a['media_img']; ?>" 
                                    class="rounded-3 poster shadow" 
                                    style="width: 180px; height: 250px; object-fit: cover;"
                                    data-bs-toggle="modal" data-bs-target="#movieModal" onclick="fetchMediaData(<?php echo $a['media_id']; ?>);">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <h2 class="text-center mt-5">โปรดรอติดตามเร็วๆนี้...</h2>
        <?php } ?>
    </div>

</div>
    
    <?php include('modals.php'); ?>

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
                    document.getElementById('duration-p').innerText = data.duration;
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

    <script src="js/bootstrap.bundle.js"></script>
    <?php require('footer.php'); ?>
</body>
</html>
