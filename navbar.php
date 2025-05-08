<?php $pageName = basename($_SERVER['PHP_SELF']); ?>
<nav class="navbar fixed-top navbar-expand-lg black-bg" style="z-index: 9999;">       
  <div class="container-fluid">
  <?php if($pageName=='login.php' or $pageName=='register.php' or $pageName=='forgot_password.php') { ?>
    <div class="d-flex justify-content-between align-items-center w-100">
      <!-- ปุ่ม back -->
      <a href="#" class="nav-link m-2" onclick="history.back();">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
          class="bi bi-arrow-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd"
            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg>
      </a>

      <!-- ชื่อแบรนด์ตรงกลาง -->
      <div class="mx-auto">
        <a class="navbar-brand text-white" href="index.php"><img src="img/Logo.png" style="width: auto; height: 50px;"></a>
      </div>

      <!-- ช่องว่างขวาเพื่อบาลานซ์กับปุ่ม back -->
      <div style="width: 36px; margin: 0 1rem;"></div>
    </div>
    <?php } else { ?>
      <a class="navbar-brand text-white" href="index.php"><img src="img/Logo.png" style="width: auto; height: 50px;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a class="nav-link" style="color: <?php if($pageName=='index.php') echo 'yellow;'; else echo 'white'; ?>" aria-current="page" href="index.php">หน้าหลัก</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color: <?php if($pageName=='discover.php' and $_GET['t']=="") echo 'yellow;'; else echo 'white'; ?>" aria-current="page" href="discover.php">ค้นพบ</a>
          </li>
          <?php
            $sql2 = "SELECT * FROM Type ORDER BY type_name LIMIT 5";
            $result2 = mysqli_query($dbcon, $sql2);
          ?>
          <?php foreach($result2 as $row2) { ?>
            <li class="nav-item">
              <a class="nav-link" style="color: <?php if($pageName=='discover.php' and $_GET['t']==$row2['type_id']) echo 'yellow;'; else echo 'white'; ?>" aria-current="page" href="discover.php?t=<?php echo $row2['type_id']; ?>"><?php echo $row2['type_name']; ?></a>
            </li>
          <?php } ?>
      </ul>
          
      <form action="discover.php" class="d-flex" role="search" style="margin-right: 10px;">
          <div class="input-group">
              <input name="srch" class="form-control" type="search" placeholder="ค้นหา" aria-label="Search" value="<?php echo $_GET['srch']; ?>">
              <button class="input-group-text search-btn border-start-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
              </button>
          </div>
      </form>

      <?php if(!isset($_SESSION['logined'])) { ?>
          <a class="btn btn-outline-warning" href="login.php">
              เข้าสู่ระบบ
          </a>
      <?php } else { ?>
        <?php
          $sql = "SELECT user_img FROM User WHERE user_id='".$_SESSION['user_id']."'";
          $result = mysqli_query($dbcon, $sql);
          $row = mysqli_fetch_assoc($result);
        ?>
          <div style="margin-right: 10px;">
            <?php if($row['user_img']!='-') { ?>
              <img src="img/profile/<?php echo $row['user_img']; ?>" class="rounded-5" style="width: 40px; height: 40px; object-fit: cover;">
            <?php } else { ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
              </svg>
            <?php } ?>
          </div>
          <div class="dropdown" style="margin-right: 10px;">
              <a class="dropdown-toggle text-white" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
              <ul class="dropdown-menu dropdown-menu-end mt-4">
                  <li><a class="dropdown-item" href="profile.php">โปรไฟล์</a></li>
                  <li><a class="dropdown-item" href="watchlist.php">รายการของฉัน</a></li>
                  <li><a class="dropdown-item" href="history.php">ประวัติการรับชม</a></li>
                  <li><a class="dropdown-item" href="logout.php" onclick="return confirm('ยืนยันการออกจากระบบ?');">ออกจากระบบ</a></li>
              </ul>
          </div>
      <?php } ?>

      </div>
    <?php } ?>
  </div>
</nav>
<br>