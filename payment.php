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
      <h1>การชำระเงิน</h1>

      <?php
        $sql = "SELECT * FROM Package WHERE package_name = (SELECT package_name FROM User WHERE user_id='".$_SESSION['user_id']."')";
        $result = mysqli_query($dbcon, $sql);
        $row = mysqli_fetch_assoc($result);

        $sql2 = "SELECT * FROM Payment WHERE user_id = '".$_SESSION['user_id']."'";
        $result2 = mysqli_query($dbcon, $sql2);
        $num2 = mysqli_num_rows($result2);
      ?>

        <div class="container mt-5">

            <div class="row justify-content-center mt-3">
                <button class="btn btn-warning w-25" data-bs-toggle="modal" data-bs-target="#paymentBox"><b>+ เพิ่มช่องทางการชำระเงิน</b></button>
            </div>

            <div class="row justify-content-center">
                <?php if($num2==0) { ?>
                    <label class="mt-5">คุณยังไม่มีช่องทางการชำระเงิน</label>
                <?php } else { ?>
                    <?php
                        $card = ['บัตรเครดิต', 'บัตรเดบิต'];
                        foreach($result2 as $row2) { ?>
                        <div class="row justify-content-center">
                            <div class="row rounded-3 mt-5 p-4 w-50" style="background-color: #412E2E; text-align: left;">
                                <h3 class="m-2"><?php echo $card[$row2['payment_type']-1]; ?></h3>
                                <h5 class="m-2">ชื่อ: <?php echo $row2['name']; ?></h5>
                                <h5 class="m-2">หมายเลขบัตร: <?php echo $row2['number']; ?></h5>
                                <h5 class="m-2">วันหมดอายุ: <?php echo $row2['expired']; ?>&nbsp;&nbsp;&nbsp;&nbsp;CVV: <?php echo $row2['cvv']; ?></h5>
                                
                                <div class="d-flex justify-content-end mt-2">
                                    <a class="text-decoration-none me-4" href="" data-bs-toggle="modal" data-bs-target="#paymentEdit" data-payment-id="<?php echo $row2['payment_id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="black" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>
                                    </a>
                                    <a class="text-decoration-none" href="delete_payment.php?id=<?php echo $row2['payment_id']; ?>" onclick="return confirm('ยืนยันการลบ?');">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="modal fade" id="paymentBox" tabindex="-1" aria-labelledby="paymentBoxLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #412E2E; max-width: 650px;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="paymentBoxLabel">เพิ่มช่องทางการชำระเงิน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <form action="payment_save.php" method="post">
                            <div class="p-3 rounded-3 mx-auto" style="background-color: #412E2E; max-width: 650px;">
                            <div class="mb-4 d-flex gap-3 justify-content-center">
                                <select style="background-color: #412E2E;" name="type" class="form-select text-center w-auto text-white" required>
                                    <option value="1" selected>บัตรเครดิต</option>
                                    <option value="2">บัตรเดบิต</option>
                                </select>

                                <div class="form-floating w-100">
                                    <input id="floatingNum" type="text" class="form-control text-white" style="background-color: #412E2E;" maxlength="16" pattern="[0-9]{16}" name="card_number" placeholder="หมายเลขบัตร" required>
                                    <label for="floatingNum">หมายเลขบัตร</label>
                                </div>
                            </div>

                            <div class="mb-4 d-flex gap-3 justify-content-center">
                                <div class="form-floating w-50">
                                    <input id="floatingExpired" type="text" maxlength="5" style="background-color: #412E2E;" class="form-control text-white" pattern="[0-9]{2}/[0-9]{2}" name="expired" placeholder="ดด/ปป" required>
                                    <label for="floatingExpired">วันหมดอายุ (ดด/ปป)</label>
                                </div>
                                <div class="form-floating w-50">
                                    <input id="floatingCVV" type="text" maxlength="3" style="background-color: #412E2E;" class="form-control text-white" pattern="[0-9]{3}" name="cvv" placeholder="CVV" required>
                                    <label for="floatingCVV">CVV</label>
                                </div>
                                
                            </div>

                            <div class="mb-3 text-center">
                                <div class="form-floating">
                                    <input id="floatingName" maxlength="200" type="text" style="background-color: #412E2E;" class="form-control text-white" name="card_name" placeholder="ชื่อบนบัตร" required>
                                    <label for="floatingName">ชื่อบนบัตร</label>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4">
                                <input type="submit" class="btn btn-warning w-auto px-5" value="บันทึก">
                            </div>

                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="paymentEdit" tabindex="-1" aria-labelledby="paymentEditLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #412E2E; max-width: 650px;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="paymentEditLabel">แก้ไขช่องทางการชำระเงิน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <form action="payment_edit_save.php" method="post">
                            <div class="p-3 rounded-3 mx-auto" style="background-color: #412E2E; max-width: 650px;">
                            <div class="mb-4 d-flex gap-3 justify-content-center">
                                <select id="editType" style="background-color: #412E2E;" name="type" class="form-select text-center w-auto text-white" required>
                                    <option value="1" selected>บัตรเครดิต</option>
                                    <option value="2">บัตรเดบิต</option>
                                </select>

                                <div class="form-floating w-100">
                                    <input id="editCardNumber" id="floatingNum" type="text" class="form-control text-white" style="background-color: #412E2E;" maxlength="16" pattern="[0-9]{16}" name="card_number" placeholder="หมายเลขบัตร" required>
                                    <label for="floatingNum">หมายเลขบัตร</label>
                                </div>
                            </div>

                            <div class="mb-4 d-flex gap-3 justify-content-center">
                                <div class="form-floating w-50">
                                    <input id="editExpired" id="floatingExpired" type="text" maxlength="5" style="background-color: #412E2E;" class="form-control text-white" pattern="[0-9]{2}/[0-9]{2}" name="expired" placeholder="ดด/ปป" required>
                                    <label for="floatingExpired">วันหมดอายุ (ดด/ปป)</label>
                                </div>
                                <div class="form-floating w-50">
                                    <input id="editCVV" id="floatingCVV" type="text" maxlength="3" style="background-color: #412E2E;" class="form-control text-white" pattern="[0-9]{3}" name="cvv" placeholder="CVV" required>
                                    <label for="floatingCVV">CVV</label>
                                </div>
                                
                            </div>

                            <div class="mb-3 text-center">
                                <div class="form-floating">
                                    <input id="editCardName" id="floatingName" maxlength="200" type="text" style="background-color: #412E2E;" class="form-control text-white" name="card_name" placeholder="ชื่อบนบัตร" required>
                                    <label for="floatingName">ชื่อบนบัตร</label>
                                </div>
                            </div>

                            <input type="hidden" name="payment_id" id="editPaymentId">

                            <div class="row justify-content-center mt-4">
                                <input type="submit" class="btn btn-warning w-auto px-5" value="บันทึก">
                            </div>

                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const paymentEditModal = document.getElementById('paymentEdit');
        
        paymentEditModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const paymentId = button.getAttribute('data-payment-id');

            fetch('get_payment.php?payment_id=' + paymentId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editPaymentId').value = data.payment_id;
                document.getElementById('editType').value = data.payment_type;
                document.getElementById('editCardNumber').value = data.number;
                document.getElementById('editExpired').value = data.expired;
                document.getElementById('editCVV').value = data.cvv;
                document.getElementById('editCardName').value = data.name;
            });
        });
        });
        </script>
    <?php require('footer.php'); ?>
  </body>
  </html>
<?php } else {
  echo "<script>location.href='index.php';</script>";
  exit;
} ?>