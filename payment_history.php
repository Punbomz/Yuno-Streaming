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
  </head>
  <body class="dark-bg">

    <?php require('navbar.php'); ?>

    <div class="container justify-content-center text-center mt-5">
      <h1 style="margin-top: 100px;">ประวัติการชำระเงิน</h1>

        <div class="row mt-5">
            <h5>การชำระเงินรายเดือน</h5>
        </div>
        <?php
            $sql = "SELECT u.package_name, u.package_start, u.package_end, p.price FROM User_Package u INNER JOIN Package p ON p.package_name=u.package_name WHERE user_id='".$_SESSION['user_id']."'";
            $result = mysqli_query($dbcon, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>

        <div class="row">
            <?php if(is_null($row['package_name'])) { ?>
                <label class="mt-4">คุณยังไม่ได้สมัครแพ็คเกจ</label>
            <?php } else { ?>
                <div class="row justify-content-center">
                    <div class="position-relative rounded-3 shadow pr-4 pl-4 m-4" style="background-color: #412E2E; width: 500px; text-align: left;"> 
                            <div class="row text-center p-3" style="background-color: #2A1B1B;">
                                <h2>แพ็คเกจ <?php echo $row['package_name']; ?></h2>
                                <h4><?php echo $row['price'].'฿ / เดือน'; ?></h4>
                            </div>    

                            <div class="p-2 mb-2">
                            <label class="text-white m-2">วันเริ่มต้น: <?php echo (new DateTime($row['package_start']))->format('d/m/Y'); ?></label><br>
                            <label class="text-white m-2">วันสิ้นสุด: <?php echo (new DateTime($row['package_end']))->format('d/m/Y'); ?></label><br>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php
            $sql2 = "SELECT ph.*, p.number, p.payment_type FROM Payment_History ph LEFT JOIN Payment p ON ph.payment_id = p.payment_id WHERE ph.user_id='".$_SESSION['user_id']."'";
            $result2 = mysqli_query($dbcon, $sql2);
            $num2 = mysqli_num_rows($result2);
            $card = ['บัตรเครดิต', 'บัตรเดบิต'];
        ?>

        <div class="row mt-4">
            <h5>ประวัติการชำระเงิน</h5>
        </div>

        <?php if($num2==0) { ?>
            <label class="mt-4">ไม่มีข้อมูล</label>
        <?php } else { ?>
            <table class="table mt-4 table-dark table-hover table-borderless">
                <thead>
                    <tr>
                    <th style="background-color: #534A4A;" width="5%" scope="col">วันที่</th>
                    <th style="background-color: #534A4A;" width="20%" scope="col">รายการ</th>
                    <th style="background-color: #534A4A;" width="20%" scope="col">วิธีการชำระเงิน</th>
                    <th style="background-color: #534A4A;" width="10%" scope="col">รวมสุทธิ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result2 as $row2) {
                        $cnum = $row2['number'];
                        for($i=0; $i<strlen($cnum); $i++) {
                            if($i<=strlen($cnum)-5) {
                                $cnum[$i] = '*';
                            } else {
                                $cnum[$i] = $cnum[$i];
                            }
                        }    
                    ?>
                        <tr>
                        <td style="background-color: #412E2E;"><?php echo (new DateTime($row2['payment_datetime']))->format('d/m/Y'); ?></td>
                        <td style="background-color: #412E2E;"><?php echo 'สมัครแพ็คเกจ '.$row2['package_name']; ?></td>
                        <td style="background-color: #412E2E;"><?php echo $card[$row2['payment_id']-1].' '.$cnum; ?></td>
                        <td style="background-color: #412E2E;"><?php echo $row2['price'].'฿'; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <?php require('footer.php'); ?>
  </body>
  </html>
<?php } else {
  echo "<script>location.href='index.php';</script>";
  exit;
} ?>