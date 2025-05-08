<?php require('connect.php'); ?>

<?php if(isset($_SESSION['logined']) and $_SESSION['user_lv']==0) { ?>

  <!DOCTYPE html>
  <html lang="th">
  <head>
      <meta charset="utf-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo web_title ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo favicon; ?>">
      <!-- Bootstrap -->
      <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mycss.css" rel="stylesheet">
    <style>
      .back-arrow {
        font-size: 30px;
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
      }

      .section {
        background-color: #d9d9d9;
        color: black;
        margin-bottom: 25px;
        padding: 15px; /* ลด padding เพื่อให้กล่องเล็กลง */
        font-size: 18px; /* ขนาดตัวอักษรเล็กลง */
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 10px;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        min-height: 30px; /* ขนาดกล่องเล็กมาก */
      }

      /* กล่องที่มีความสูงสั้นกว่า */
      .section-narrow {
        width: 80%;
        min-height: 30px; /* ปรับให้เล็กลงมาก */
      }

      /* กล่องรายละเอียด Package ของฉันจะมีความสูงที่มากกว่า */
      .section-main {
        width: 80%;
        min-height: 50px; /* เพิ่มความสูงให้มากกว่ากล่องอื่น ๆ */
      }

      .section.disabled {
        color: #888;
      }

      .premium-badge {
        background-color: #d1b741;
        padding: 5px 10px; /* ลดขนาด padding ของ badge */
        border-radius: 5px;
        font-weight: bold;
        white-space: nowrap;
      }

      .arrow {
        font-size: 18px; /* ขนาดลูกศรเล็กลง */
      }
    </style>
  </head>
  <body class="dark-bg">

    <?php require('navbar.php'); ?>

    <div class="container justify-content-center text-center mt-5">
      <h1>แพ็คเกจและการชำระเงิน</h1>

      <?php
        $sql = "SELECT * FROM Package WHERE package_name = (SELECT package_name FROM User WHERE user_id='".$_SESSION['user_id']."')";
        $result = mysqli_query($dbcon, $sql);
        $row = mysqli_fetch_assoc($result);
      ?>

      <div class="container mt-5">
        <a href="package_detail.php" class="section section-main text-decoration-none">
          <span>รายละเอียด Package ของฉัน</span>
          <?php if(!is_null($row['package_name'])) { ?>
            <div class="premium-badge"><?php echo $row['package_name']; ?></div>
          <?php } else { ?>
            <div class="premium-badge">คุณยังไม่ได้สมัครแพ็คเกจ</div>
          <?php } ?>
        </a>

        <?php
            $sql_pay = "SELECT * FROM Payment WHERE user_id='".$_SESSION['user_id']."' AND payment_id = (SELECT payment_id FROM Payment_History WHERE user_id='".$_SESSION['user_id']."' ORDER BY payment_datetime DESC LIMIT 1)";
            $result_pay = mysqli_query($dbcon, $sql_pay);
            $row_pay = mysqli_fetch_assoc($result_pay);

            $card = ['บัตรเครดิต', 'บัตรเดบิต'];
        ?>

        <div class="section section-narrow <?php if(is_null($row_pay['payment_id'])) echo 'disabled'; ?>">
          <span>การชำระเงินหลัก</span>
          <?php if(!is_null($row_pay['payment_id'])) { ?>
            <?php
              $cnum = $row_pay['number'];
              for($i=0; $i<strlen($cnum); $i++) {
                  if($i<=strlen($cnum)-5) {
                      $cnum[$i] = '*';
                  } else {
                      $cnum[$i] = $cnum[$i];
                  }
              }
            ?>
            <span><?php echo $card[$row_pay['payment_type']-1]." ".$cnum; ?></span>
          <?php } ?>
        </div>

        <a class="section section-narrow" style="text-decoration: none;" href="payment.php">
          <span>จัดการวิธีการชำระเงิน</span>
          <span class="arrow">&#62;</span>
        </a>

        <a class="section section-narrow" style="text-decoration: none;" href="payment_history.php">
          <span>ประวัติการชำระเงิน</span>
          <span class="arrow">&#62;</span>
        </a>
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