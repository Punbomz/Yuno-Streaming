<?php require('connect.php') ?>

<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) { ?>

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
</head>

<body class="dark-bg">
    <?php require('admin_navbar.php') ?>

    <div class="container justify-content-center text-center mt-5">
        <h1>แก้ไขมีเดีย</h1>

        <?php
            $sql = "SELECT * FROM Media WHERE media_id = '".$_GET['id']."'";
            $result = mysqli_query($dbcon, $sql);
            $row = mysqli_fetch_assoc($result);

            $sqld = "SELECT director_name FROM Media_Director WHERE media_id = '".$_GET['id']."'";
            $resultd = mysqli_query($dbcon, $sqld);
            $dc = [];
            foreach($resultd as $rowd) {
                array_push($dc, $rowd['director_name']);
            }
            $directors = implode(",", $dc);

            $sqla = "SELECT actor_name FROM Media_Actor WHERE media_id = '".$_GET['id']."'";
            $resulta = mysqli_query($dbcon, $sqla);
            $ac = [];
            foreach($resulta as $rowa) {
                array_push($ac, $rowa['actor_name']);
            }
            $actors = implode(",", $ac);
        ?>

        <form action="save_edit_media.php?id=<?php echo $row['media_id']; ?>" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center rounded-3 p-4 mt-5 mb-5" style="background-color: #412E2E;">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-center">
                            <label class="form-label mt-2">โปสเตอร์</label>
                            <img id="Preview" class="mb-3" alt="poster" src="img/media/posters/<?php echo $row['media_img']; ?>" style="width: 288px; height: 386px; object-fit: cover; border-radius: 20px;">
                        </div>
                        <div class="row justify-content-center">
                            <input id="Posterpic" type="file" name="poster" accept="image/*" class="form-control mb-3 w-50" onchange="handleFileChange(this);">
                            <input type="hidden" name="old_poster" value="<?php echo $row['media_img']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-center">
                            <div class="w-50">
                                <label class="form-label mt-2">ประเภท</label>
                                <select id="typeSelect" name="t" class="form-select text-center" onchange="toggleAddFileButton()">
                                    <?php
                                        $sql1 = "SELECT * FROM Type ORDER BY type_name";
                                        $result1 = mysqli_query($dbcon, $sql1);
                                        foreach($result1 as $row1) { ?>
                                            <option value="<?php echo $row1['type_id']; ?>" <?php if($row1['type_id']==$row['type_id']) echo 'selected'; ?>><?php echo $row1['type_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">ชื่อ</label>
                                <input type="text" name="title" class="form-control mt-2" placeholder="ระบุชื่อ" value="<?php echo $row['media_title']; ?>" required>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">รายละเอียด</label>
                                <textarea rows="5" name="detail" class="form-control mt-2" placeholder="ระบุรายละเอียด" required><?php echo $row['media_desc']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">หมวดหมู่</label>
                                <?php
                                    $sql2 = "SELECT * FROM Genre ORDER BY genre_name ASC";
                                    $result2 = mysqli_query($dbcon, $sql2);
                                ?>
                                <div id="categoryContainer">
                                    <?php

                                    $sql3 = "SELECT * FROM Medias_Genre WHERE media_id='".$row['media_id']."'";
                                    $result3 = mysqli_query($dbcon, $sql3);
                                    
                                    $genre_i = 1;
                                    foreach ($result3 as $genre_id) { ?>
                                        <div class="row align-items-center">
                                            <select name="genre[]" class="form-select text-center mt-3 col" required>
                                                <?php
                                                foreach ($result2 as $row2) { ?>
                                                    <option value='<?php echo $row2['genre_id'] ?>' <?php if($row2['genre_id'] == $genre_id['genre_id']) echo 'selected'; ?> > <?php echo $row2['genre_name']; ?> </option>
                                                <?php } ?>
                                            </select>
                                            <?php if($genre_i > 1) { ?>
                                                <button type="button" class="btn btn-danger btn-sm ms-2 mt-3 col" style="width: 25px;" onclick="removeSelect(this)">ลบ</button>
                                            <?php } ?>
                                        </div>
                                    <?php $genre_i++; } ?>
                                </div>

                                <div class="row justify-content-center">
                                    <button type="button" class="btn mt-3" style="width: 100px; background-color: #BDB487; margin-right: 25px;" onclick="addCategorySelect()"><b>+ เพิ่ม</b></button>
                                    <button type="button" class="btn mt-3" style="width: 100px; background-color: #BDB487; margin-right: 25px;" onclick="addNewCategory()"><b>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                        </svg> สร้าง</b>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">ผู้กำกับ</label>
                                <input type="text" name="director" class="form-control mt-2" placeholder="ระบุผู้กำกับ" value="<?php echo $directors; ?>" required>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">วันที่ฉาย</label>
                                <input type="date" name="release" class="form-control mt-2" value="<?php echo $row['media_release']; ?>" required>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">เรทอายุ</label>
                                <select name="rate" class="form-select text-center" required>
                                    <option value='1' <?php if($row['media_rate']==1) echo 'selected'; ?>>สำหรับเด็ก</option>
                                    <option value='2' <?php if($row['media_rate']==2) echo 'selected'; ?>>ทุกวัย</option>
                                    <option value='3' <?php if($row['media_rate']==3) echo 'selected'; ?>>13+</option>
                                    <option value='3' <?php if($row['media_rate']==4) echo 'selected'; ?>>15+</option>
                                    <option value='4' <?php if($row['media_rate']==5) echo 'selected'; ?>>18+</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">นักแสดง</label>
                                <textarea rows="4" name="actor" class="form-control mt-2" placeholder="ระบุนักแสดง" required><?php echo $actors; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="row mt-5 justify-content-center">
                        <div class="w-50">
                            <label class="form-label">ไฟล์มีเดีย</label>
                            <div class="row justify-content-center" id="fileContainer">
                                <?php

                                    $sql4 = "SELECT * FROM Media_Files WHERE media_id='".$row['media_id']."'";
                                    $result4 = mysqli_query($dbcon, $sql4);

                                    $ep = 1;
                                    
                                    foreach ($result4 as $file_id) { 
                                        $tmp_duration = $file_id['media_duration'];
                                        $minutes = floor($tmp_duration);
                                        $seconds = round(($tmp_duration - $minutes) * 60);
                                        $timeFormatted = sprintf('%02d:%02d', $minutes, $seconds);
                                    ?>
                                        <div class="row align-items-center mt-3 file-entry">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0 episode-label">ตอน <?php echo $ep; ?></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="file" name="file[]" accept="video/*" class="form-control" onchange="duration(this);">
                                                <input type="hidden" name="duration[]" class="duration-hidden" value="<?php echo ($minutes.':'.$seconds); ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label mb-0 dur-label">ระยะเวลา: <?php echo $timeFormatted; ?></label>
                                            </div>
                                            <?php if($file_id['episode'] > 1) { ?>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger" style="width: 100px;" onclick="if (confirm('ยืนยันการยกเลิก?')) removeFile(this)">ลบ</button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php $ep++; } ?>
                            </div>

                            <div class="row justify-content-center">
                                <button id="addFileBtn" type="button" class="btn mt-3" style="width: 100px; background-color: #BDB487; margin-right: 25px;" onclick="addFile()"><b>+ เพิ่ม</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4 mb-5">
                <input type="submit" class="btn btn-warning" style="width: 150px; margin-right: 25px;" value="บันทึก" onclick="return confirm('ยืนยันการบันทึก?');">
                <?php if($row['media_status']==1) { ?>
                    <a href="showing.php?id=<?php echo $row['media_id']; ?>&t=0" class="btn btn-secondary" style="width: 150px; margin-right: 25px; margin-left: 25px;"onclick="return confirm('หยุดฉายมีเดีย?');">หยุดฉาย</a>
                <?php } else { ?>
                    <a href="showing.php?id=<?php echo $row['media_id']; ?>&t=1" class="btn btn-success" style="width: 150px; margin-right: 25px; margin-left: 25px;"onclick="return confirm('เริ่มฉายมีเดีย?');">เริ่มฉาย</a>
                <?php } ?>
                <button type="button" class="btn btn-danger text-black" style="width: 150px; margin-left: 25px;"onclick="if (confirm('ยืนยันการยกเลิก?')) history.back();">ยกเลิก</button>
            </div>
        </form>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        function handleFileChange(input) {
            var Poster_img = document.getElementById("Posterpic");
            var Poster_Preview = document.getElementById("Preview");
            // Check if a file is selected
            if (Poster_img.files.length > 0) {
            var file = Poster_img.files[0];

            // Check if the file is an image
            if (file.type.match(/image.*/)) {
                // Update the image preview
                var reader = new FileReader();
                reader.onload = function (e) {
                Poster_Preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            }
        }
    </script>
    <script>
        function toggleAddFileButton() {
            const type = document.getElementById('typeSelect').value;
            const addFileBtn = document.getElementById('addFileBtn');
            
            if (type === '2') {
                addFileBtn.style.display = 'none';
            } else {
                addFileBtn.style.display = 'inline-block';
            }
        }

        window.onload = toggleAddFileButton;

        function addCategorySelect() {
            const container = document.getElementById('categoryContainer');
            const newSelectDiv = document.createElement('div');
            newSelectDiv.className = 'row';
            newSelectDiv.innerHTML = `<select name="genre[]" class="form-select text-center mt-3 col" required>
                                        <?php
                                            foreach($result2 as $row2) { ?>
                                                <option value="<?php echo $row2['genre_id']; ?>"><?php echo $row2['genre_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <button type="button" class="btn btn-danger btn-sm ms-2 mt-3 col" style="width: 25px;" onclick="removeSelect(this)">ลบ</button>`;
            container.appendChild(newSelectDiv);
        }

        function removeSelect(button) {
            const wrapper = button.parentElement;
            wrapper.remove();
        }

        function addNewCategory() {
            const container = document.getElementById('categoryContainer');
            const newSelectDiv = document.createElement('div');
            newSelectDiv.className = 'row align-items-center';
            newSelectDiv.innerHTML = `<input type="text" name="newgenre[]" class="form-control text-center mt-3 col" placeholder="ระบุชื่อหมวดหมู่" required>
                                    <button type="button" class="btn btn-danger btn-sm ms-2 mt-3 col" style="width: 25px;" onclick="removeSelect(this)">ลบ</button>`;
            container.appendChild(newSelectDiv);
        }

        let episodeCount = 2;

        function addFile() {
            const container = document.getElementById('fileContainer');
            const newSelectDiv = document.createElement('div');
            newSelectDiv.className = 'row align-items-center mt-3 file-entry';

            newSelectDiv.innerHTML = `
                <div class="col-md-3">
                    <label class="form-label mb-0 episode-label">ตอน ${episodeCount}</label>
                </div>
                <div class="col-md-4">
                    <input type="file" name="file[]" accept="video/*" class="form-control" onchange="duration(this);" required>
                    <input type="hidden" name="duration[]" class="duration-hidden">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-0 dur-label">ระยะเวลา: </label>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" style="width: 100px;" onclick="if (confirm('ยืนยันการยกเลิก?')) removeFile(this)">ลบ</button>
                </div>
            `;

            episodeCount++;
            container.appendChild(newSelectDiv);
            updateEpisodeNumbers();
        }

        function removeFile(button) {
            const entry = button.closest('.file-entry');
            if (entry) {
                entry.remove();
                episodeCount--;
                updateEpisodeNumbers();
            }
        }

        function updateEpisodeNumbers() {
            const labels = document.querySelectorAll('.episode-label');
            labels.forEach((label, index) => {
                label.textContent = `ตอน ${index + 1}`; // เริ่มนับจาก 2
            });
        }

        function duration(input) {
            const file = input.files[0];
            if (!file) return;

            const video = document.createElement('video');
            video.preload = 'metadata';

            video.onloadedmetadata = function () {
                window.URL.revokeObjectURL(video.src);

                const seconds = Math.floor(video.duration);
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                const timeString = `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;

                const row = input.closest('.row');
                const label = row.querySelector('.dur-label');
                const hiddenInput = row.querySelector('.duration-hidden');

                label.textContent = `ระยะเวลา: ${timeString}`;
                hiddenInput.value = timeString;
            };

            video.src = URL.createObjectURL(file);
        }
    </script>
</body>
</html>

<?php } else { echo "<script>location.href='index.php';</script>";
    exit; } ?>