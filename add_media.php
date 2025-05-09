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
        <h1>เพิ่มมีเดีย</h1>

        <form action="save_media.php" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center rounded-3 p-4 mt-5 mb-5" style="background-color: #412E2E;">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-center">
                            <label class="form-label mt-2">โปสเตอร์</label>
                            <img id="Preview" class="mb-3" style="width: 288px; height: 386px; object-fit: cover; border-radius: 25px;" alt="Preview">
                        </div>
                        <div class="row justify-content-center">
                            <input id="Posterpic" type="file" name="poster" accept="image/*" class="form-control mb-3 w-50" onchange="handleFileChange(this);" required>
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
                                            <option value="<?php echo $row1['type_id']; ?>"><?php echo $row1['type_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">ชื่อ</label>
                                <input type="text" name="title" class="form-control mt-2" placeholder="ระบุชื่อ" required>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">รายละเอียด</label>
                                <textarea rows="5" name="detail" class="form-control mt-2" placeholder="ระบุรายละเอียด" required></textarea>
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
                                <div class="row justify-content-center" id="categoryContainer">
                                    <div>
                                        <select name="genre[]" class="form-select text-center mt-3" required>
                                            <?php
                                                foreach($result2 as $row2) { ?>
                                                    <option value="<?php echo $row2['genre_id']; ?>"><?php echo $row2['genre_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
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
                                <input type="text" name="director" class="form-control mt-2" placeholder="ระบุผู้กำกับ" required>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">วันที่ฉาย</label>
                                <input type="date" name="release" class="form-control mt-2" required>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">เรทอายุ</label>
                                <select name="rate" class="form-select text-center" required>
                                    <option value='1'>สำหรับเด็ก</option>
                                    <option value='2'>ทุกวัย</option>
                                    <option value='3'>13+</option>
                                    <option value='4'>15+</option>
                                    <option value='5'>18+</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="w-50">
                                <label class="form-label">นักแสดง</label>
                                <textarea rows="4" name="actor" class="form-control mt-2" placeholder="ระบุนักแสดง" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="row mt-5 justify-content-center">
                        <div class="w-50">
                            <label class="form-label">ไฟล์มีเดีย</label>
                            <div class="row justify-content-center" id="fileContainer">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label mb-0">ตอน 1</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="file[]" accept="video/*" class="form-control" onchange="duration(this);" required>
                                        <input type="hidden" name="duration[]" class="duration-hidden">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label mb-0 dur-label">ระยะเวลา: </label>
                                    </div>
                                </div>
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
                label.textContent = `ตอน ${index + 2}`; // เริ่มนับจาก 2
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