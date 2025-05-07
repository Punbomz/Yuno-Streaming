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
  </head>
  <body class="dark-bg">
      <?php require('navbar.php'); ?>

      <?php
        $sql = "SELECT * FROM User WHERE user_id='".$_SESSION['user_id']."'";
        $result = mysqli_query($dbcon, $sql);
        $row = mysqli_fetch_assoc($result);
      ?>

    <div class="container justify-content-center text-center mt-5">
      <h1>โปรไฟล์</h1>

      <div class="container justify-content-center mt-5">
        <div class="row">
          <div class="col">
            <div class="row justify-content-center mb-2">
              <?php if($row['user_img']!='-') { ?>
                <img src="img/profile/<?php echo $row['user_img']; ?>" class="rounded-3 img-thumbnail" alt="Profile" style="width: 250px; height: 250px; object-fit: cover;">
              <?php } else { ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="white" class="bi bi-person-circle" viewBox="0 0 16 16">
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
              <?php } ?>
            </div>
            <div class="row justify-content-center mb-2 mt-4">
              <h3 class="text-center"><?php echo $row['user_name']; ?></h3>
            </div>
            <div class="row text-center">
              <p>เริ่มเป็นสมาชิก: <?php echo (new DateTime($row['register_date']))->format('d/m/Y'); ?></p>
            </div>
          </div>
  
          <div class="col">
            <form action="#" enctype="multipart/form-data">
              <div class="row justify-content-center mt-3 mb-2">
                <div class="row mb-2">
                    <label>อีเมล</label>
                </div>
                <input name="email" type="email" class="form-control mb-3 text-center" placeholder="ระบุอีเมล" value="<?php echo $row['user_email']; ?>" readonly>
              </div>

              <div class="row justify-content-center mt-3 mb-2">
                <div class="row mb-2">
                    <label>วันเกิด</label>
                </div>
                <input name="dob" type="date" class="form-control mb-3 text-center" value="<?php echo $row['user_birthdate']; ?>" readonly>
              </div>

              <div class="buttons">
                <a href="profile_edit.php" class="btn btn-warning" style="width: 150px; margin-right: 25px;">แก้ไขโปรไฟล์</a>
              </div>

              <div class="row justify-content-center mt-5 mb-4">
                <div class="btn text-white shadow" style="background-color: #412E2E;" onclick="window.location.href='package.php'">
                  แพ็คเกจและการชำระเงิน
                  <span class="arrow col">&#62;</span>
                </div>
              </div>
            </form>
    
          </div>
        </div>
        </div>
      </div>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <?php require('footer.php'); ?>

  </body>
  </html>
<?php } else {
  header("Location: index.php");
} ?>