<?php require('connect.php'); ?>

<?php if(isset($_SESSION['logined']) and $_SESSION['user_lv']==0) { ?>

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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  </head>
  <body class="dark-bg">
      <?php require('navbar.php'); ?>

      <?php
        $sql = "SELECT * FROM User WHERE user_id='".$_SESSION['user_id']."'";
        $result = mysqli_query($dbcon, $sql);
        $row = mysqli_fetch_assoc($result);
      ?>

    <div class="container justify-content-center text-center" style="margin-top: 100px;">
      <h1>แก้ไขโปรไฟล์</h1>

      <div class="container justify-content-center mt-5">
        <form action="user_edit_save.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
          <div class="row justify-content-center mt-4">
                <img id="Preview" class="img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="Preview" src="img/profile/<?php if($row['user_img']!='-') echo $row['user_img']; ?>">
            </div>
            <div class="row justify-content-center mt-3">
              <input id="profilepic" type="file" name="profile" accept="image/*" class="form-control mb-3 w-25" onchange="handleFileChange(this);">
            </div>
            <div class="row justify-content-center mb-2">
                <div class="row justify-content-center mt-3 mb-2">
                    <div class="row mb-2">
                        <label>ชื่อผู้ใช้</label>
                    </div>
                    <input name="username" type="text" class="form-control mb-3 text-center w-50" placeholder="ระบุชื่อผู้ใช้" value="<?php echo $row['user_name']; ?>" required>
                </div>

                <div class="row justify-content-center mt-3 mb-2">
                  <div class="row mb-2">
                      <label>อีเมล</label>
                  </div>
                  <input name="email" type="email" class="form-control mb-3 text-center w-50" placeholder="ระบุอีเมล" value="<?php echo $row['user_email']; ?>" required>
                </div>

                <div class="row justify-content-center mt-3 mb-2">
                    <div class="row mb-2">
                        <label>รหัสผ่าน</label>
                    </div>
                    <div class="input-group" style="width: 52%;">
                        <input name="password" id="password" class="form-control mb-3 text-center" type="password" placeholder="ระบุรหัสผ่าน (กรณีเปลี่ยนรหัสผ่าน)">
                        <i class="bi bi-eye-slash input-group-text mb-3" id="togglePassword"></i>
                    </div>
                </div>
    
                <div class="row justify-content-center mt-3 mb-2">
                  <div class="row mb-2">
                      <label>วันเกิด</label>
                  </div>
                  <input name="dob" type="date" class="form-control mb-3 text-center w-50" value="<?php echo $row['user_birthdate']; ?>" readonly>
                </div>
                
                <div class="row justify-content-center mt-3 mb-2">
                  <input type="submit" class="btn btn-warning" style="width: 150px;" value="บันทึก" onclick="return confirm('ยืนยันการบันทึก?');"></input>
                  <button type="button" class="btn btn-danger text-black" style="width: 150px; margin-left: 25px;"onclick="if (confirm('ยืนยันการยกเลิก?')) history.back();">ยกเลิก</button>
                </div> 
            </div>
        </form>
  
        </div>
        </div>
      </div>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        function handleFileChange(input) {
            var profile_img = document.getElementById("profilepic");
            var profile_Preview = document.getElementById("Preview");
            // Check if a file is selected
            if (profile_img.files.length > 0) {
            var file = profile_img.files[0];

            // Check if the file is an image
            if (file.type.match(/image.*/)) {
                // Update the image preview
                var reader = new FileReader();
                reader.onload = function (e) {
                profile_Preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            }
        }
    </script>
    <script>
      const toggle = document.getElementById('togglePassword');
      const password = document.getElementById('password');

      toggle.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
      });
    </script>

    <?php require('footer.php'); ?>

  </body>
  </html>
<?php } else {
  echo "<script>location.href='index.php';</script>";
  exit;
} ?>