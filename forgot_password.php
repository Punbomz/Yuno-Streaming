<?php require('connect.php'); ?>
<?php if(isset($_SESSION['logined'])) {
  echo "<script>location.href='index.php';</script>";
  exit;
} ?>
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
    <?php require('navbar.php') ?>
    <div class="container d-flex justify-content-center align-items-center flex-column" style="min-height: 80vh;">
    
      <h4 class="mb-4">ลืมรหัสผ่าน</h4>

      <form action="reset_password.php" method="post">
        <div class="row justify-content-center">
          <input name="email" type="email" class="form-control mb-3" style="width: 428px; background-color: #A8A0A0;" placeholder="ระบุอีเมล" required>
        </div>
      
        <div class="row justify-content-center">
          <div class="input-group" style="width: 450px;">
            <input name="password" id="password" class="form-control mb-3" style="background-color: #A8A0A0;" type="password" placeholder="ระบุรหัสผ่านใหม่" required>
            <i class="bi bi-eye-slash input-group-text mb-3" id="togglePassword"></i>
          </div>
        </div>
      
        <div class="row justify-content-center">
          <button class="btn btn-warning" style="width: 428px;">รีเซ็ตรหัสผ่าน</button>
        </div>
      </form>

      <div class="row justify-content-center mt-4">
        <div class="d-flex justify-content-between align-items-center" style="width: 450px;">
          <a class="m-2 text-decoration-none text-white">รู้รหัสผ่านแล้ว?</a>
          <a href="login.php" class="btn btn-secondary m-2 text-black" style="width: 150px; background-color: white;">เข้าสู่ระบบ</a>
        </div>
      </div>

    </div>

    <?php require('footer.php'); ?>
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
</body>

</html>
