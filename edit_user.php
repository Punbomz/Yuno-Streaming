<?php require('connect.php'); ?>

<?php if(!isset($_SESSION['logined']) or (isset($_SESSION['logined']) and $_SESSION['user_lv']==1)) { ?>

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

      <style>
        form i {
          margin-left: -30px;
          cursor: pointer;
        }
      </style>
  </head>

  <body class="dark-bg d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="w-100">
      <?php if(isset($_SESSION['logined']) and $_SESSION['user_lv']!=0) require('admin_navbar.php'); else require('navbar.php'); ?>
      <div class="container d-flex justify-content-center align-items-center flex-column" style="min-height: 80vh;">

      <?php if(isset($_SESSION['logined']) and $_SESSION['user_lv']==1) { ?>
        <h1 class="mb-4">แก้ไขข้อมูลผู้ใช้</h1>
      <?php } else { ?>
        <h1 class="mb-4">แก้ไขโปรไฟล์</h1>
      <?php } ?>

      <?php
        $sql = "SELECT user_email, user_name, user_birthdate, user_img FROM User WHERE user_id = '".$_GET['id']."'";
        $result = mysqli_query($dbcon, $sql);
        $row = mysqli_fetch_assoc($result);
      ?>

        <form action="user_edit_save.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
          <div class="row p-3 rounded-3 justify-content-center" style="background-color: #412E2E; width: 550px;">
            <div class="row justify-content-center mt-4">
                <img id="Preview" class="img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="Preview" src="img/profile/<?php if($row['user_img']!='-') echo $row['user_img']; ?>">
            </div>
            <div class="row justify-content-center mt-3">
              <input id="profilepic" type="file" name="profile" accept="image/*" class="form-control mb-3 w-50" onchange="handleFileChange(this);" required>
            </div>
            
            <div class="row justify-content-center mt-3">
              <div class="row mb-2" style="margin-left: 3px;">
                  <label>อีเมล</label>
              </div>
              <input name="email" type="email" class="form-control mb-2" style="width: 428px; background-color: #A8A0A0;" placeholder="ระบุอีเมล" required value="<?php echo $row['user_email']; ?>">
            </div>

            <div class="row justify-content-center mt-3">
              <div class="row mb-2" style="margin-left: 3px;">
                  <label>ชื่อผู้ใช้</label>
              </div>
              <input name="username" type="text" class="form-control mb-2" style="width: 428px; background-color: #A8A0A0;" placeholder="ระบุชื่อผู้ใช้" required value="<?php echo $row['user_name']; ?>">
            </div>

            <div class="row justify-content-center mt-3">
              <div class="row mb-2" style="margin-left: 3px;">
                  <label>วันเกิด</label>
              </div>
              <input name="dob" type="date" class="form-control mb-2" style="width: 428px; background-color: #A8A0A0;" max="<?php echo date('Y-m-d'); ?>" required value="<?php echo $row['user_birthdate']; ?>">
            </div>

            <div class="row justify-content-center mt-3 mb-2">
              <div class="row mb-2" style="margin-left: 3px;">
                  <label>รหัสผ่าน</label>
              </div>
              <div class="input-group" style="width: 450px;">
                <input name="password" id="password" class="form-control mb-2" style="background-color: #A8A0A0;" type="password" placeholder="ระบุรหัสผ่าน (กรณีเปลี่ยนรหัสผ่าน)">
                <i class="bi bi-eye-slash input-group-text mb-2" id="togglePassword"></i>
              </div>
            </div>
          </div>

          <div class="row justify-content-center mt-4">
            <button class="btn btn-warning" style="width: 150px; margin-right: 25px;" onclick="return confirm('ยืนยันการบันทึก?');">
                บันทึก
            </button>
            <button type="button" class="btn btn-danger text-black" style="width: 150px; margin-left: 25px;" onclick="if (confirm('ยืนยันการยกเลิก?')) history.back();">ยกเลิก</button>
          </div>
        </form>

      </div>

      <?php if(!(isset($_SESSION['logined']) and $_SESSION['user_lv']!=0)) require('footer.php'); ?>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    
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
  </body>

  </html>
<?php } else {
  header("Location: index.php");
} ?>