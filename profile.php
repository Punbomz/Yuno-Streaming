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
              <img src="img/profile/<?php echo $row['user_img']; ?>" class="rounded-3 img-thumbnail" alt="Profile" style="width: 250px; height: 250px; object-fit: cover;">
            </div>
            <div class="row justify-content-center mb-2">
              <h3 class="text-center"><?php echo $row['user_name']; ?></h3>
            </div>
            <div class="row text-center">
              <p>Start Date : <?php echo $row['register_date']; ?></p>
              <p>End Date : <?php if(is_null($row['package_start'])) echo '-'; else {
                $date = new DateTime($row['package_start']);
                $date->modify('+1 month');
                echo $date->format('Y-m-d'); } ?></p>
            </div>
          </div>
  
          <div class="col">
            <form action="#" enctype="multipart/form-data">
              <div class="row justify-content-center mt-3 mb-2">
                <div class="row mb-2" style="margin-left: 3px;">
                    <label>อีเมล</label>
                </div>
                <input name="email" type="email" class="form-control mb-3" placeholder="ระบุอีเมล" value="<?php echo $row['user_email']; ?>" readonly>
              </div>

              <div class="row justify-content-center mt-3 mb-2">
                <div class="row mb-2" style="margin-left: 3px;">
                    <label>วันเกิด</label>
                </div>
                <input name="dob" type="date" class="form-control mb-3" value="<?php echo $row['user_birthdate']; ?>" readonly>
              </div>

              <a href="package.php" class="form-control text-decoration-none mb-3">แพ็คเกจและการชำระเงิน</a>
            </form>
    
            <div class="buttons">
              <a href="profile_edit.php" class="btn btn-warning" style="width: 150px; margin-right: 25px;">แก้ไขโปรไฟล์</a>
            </div>
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