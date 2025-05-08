<?php require('connect.php') ?>

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
        <?php require('navbar.php') ?>

        <div class="container justify-content-center text-center mt-5">
            <h1>แพ็คเกจ</h1>

            <?php
                $sql = "SELECT package_name, package_start, package_end FROM User WHERE user_id='".$_SESSION['user_id']."'";
                $result = mysqli_query($dbcon, $sql);
                $row = mysqli_fetch_assoc($result);
            ?>

            <div class="row mt-5">
                <h2>แพ็คเกจปัจจุบัน</h2>
                <?php if(is_null($row['package_name'])) { ?>
                    <label class="mt-4">คุณยังไม่ได้สมัครแพ็คเกจ</label>
                <?php } else { ?>
                    <div class="row justify-content-center">
                        <div class="position-relative rounded-3 shadow pr-4 pl-4 m-4" style="background-color: #412E2E; width: 500px; text-align: left;"> 
                                <div class="row text-center p-3" style="background-color: #2A1B1B;">
                                    <h2>แพ็คเกจ <?php echo $row['package_name']; ?></h2>
                                </div>    

                                <div class="p-2 mb-2">
                                <label class="text-white m-2">วันเริ่มต้น: <?php echo $row['package_start']; ?></label><br>
                                <label class="text-white m-2">วันสิ้นสุด: <?php echo $row['package_end']; ?></label><br>
                            </div>

                                <div class="row justify-content-center mb-3">
                                    <a href="cancel.php" class="btn btn-warning w-50" onclick="return confirm('ยืนยันการยกเลิกการสมัครแพ็คเกจ?');">ยกเลิกการสมัครแพ็คเกจ</a>
                                </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php
                $sql_pk = "SELECT * FROM Package ORDER BY price ASC";
                $result_pk = mysqli_query($dbcon, $sql_pk);
                $num_pk = mysqli_num_rows($result_pk);
            ?>
            
            <div class="row mt-5">
                <h2>แพ็คเกจทั้งหมด</h2>
                <div class="row justify-content-center mb-3">
                    <?php foreach($result_pk as $pk) { ?>
                        <div class="position-relative rounded-3 shadow pr-4 pl-4 m-4" style="background-color: #412E2E; width: 300px; text-align: left;">
                            <div class="row text-center p-2" style="background-color: #2A1B1B;">
                                <h2><?php echo $pk['package_name']; ?></h2>
                            </div>
    
                            <div class="p-2 mb-2">
                                <label class="text-white m-2">ราคา: <?php echo $pk['price']; ?>฿ / เดือน</label><br>
                                <label class="text-white m-2">ความละเอียดสูงสุด: <?php echo $pk['resolution']; ?></label><br>
                                <label class="text-white m-2">จำนวนอุปกรณ์: <?php echo $pk['screens']; ?></label><br>
                                <label class="text-white m-2">อุปกรณ์ที่รองรับ: <?php echo $pk['devices']; ?></label>
                            </div>

                            <?php if($row['package_name']!=$pk['package_name']) { ?>
                                <div class="row justify-content-center mb-3">
                                    <button class="btn btn-warning w-50" data-bs-toggle="modal" data-bs-target="#paymentSelect" data-package-name="<?php echo $pk['package_name']; ?>" data-package-price="<?php echo $pk['price']; ?>">
                                        <?php if(is_null($row['package_name'])) echo 'สมัครแพ็คเกจ'; else echo 'เปลี่ยนแพ็คเกจ'; ?>
                                    </button>
                                </div>
                            <?php } else { ?>
                                <div class="row justify-content-center mb-3" style="height: 40px;"></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php
                $sql_pay = "SELECT * FROM Payment WHERE user_id='".$_SESSION['user_id']."'";
                $result_pay = mysqli_query($dbcon, $sql_pay);
                $num_pay = mysqli_num_rows($result_pay);

                $card = ['บัตรเครดิต', 'บัตรเดบิต'];
            ?>
            
            <div class="modal fade" id="paymentSelect" tabindex="-1" aria-labelledby="paymentSelectLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #412E2E; max-width: 650px;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="paymentSelectLabel">เลือกช่องทางการชำระเงิน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <h2 id="packageName"></h2>
                            <h4 id="packagePrice"></h4>
                            <form action="buy.php" method="post">
                                <input id="pName" type="hidden" name="package">
                            <div class="p-3 rounded-3 mx-auto" style="background-color: #412E2E; max-width: 650px;">
                                <div class="row justify-content-center">
                                    <?php if($num_pay==0) { ?>
                                        <label class="mb-4">คุณยังไม่มีช่องทางการชำระเงิน</label>
                                        <a href="payment.php" class="btn btn-warning w-auto px-5"><b>+ เพิ่มช่องทางการชำระเงิน</b></a>
                                    <?php } else { ?>
                                        <select style="background-color: #412E2E;" name="pay_id" class="form-select text-center text-white" required>
                                            <?php foreach($result_pay as $row_pay) {
                                                $cnum = $row_pay['number'];
                                                for($i=0; $i<strlen($cnum); $i++) {
                                                    if($i<=strlen($cnum)-5) {
                                                        $cnum[$i] = '*';
                                                    } else {
                                                        $cnum[$i] = $cnum[$i];
                                                    }
                                                }
                                            ?>
                                                <option value="<?php echo $row_pay['payment_id']; ?>"><?php echo $card[$row_pay['payment_type']-1]." ".$cnum; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>

                                <?php if($num_pay!=0) { ?>
                                    <div class="row justify-content-center mt-4">
                                        <input type="submit" class="btn btn-warning w-auto px-5" value="ยืนยัน">
                                    </div>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script>
            const paymentSelectModal = document.getElementById('paymentSelect');
            paymentSelectModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                const name = button.getAttribute('data-package-name');
                const price = button.getAttribute('data-package-price');

                document.getElementById('packageName').innerText = 'สมัครแพ็คเกจ ' + name;
                document.getElementById('packagePrice').innerText = 'ราคา ' + price + '฿ / เดือน';
                document.getElementById('pName').value = name;
            });
        </script>
        <?php require('footer.php'); ?>

    </body>
    </html>

<?php } else { header("Location: index.php"); } ?>