<?php require('connect.php') ?>

<?php if(isset($_SESSION['logined']) and $_SESSION['user_lv']==1) { ?>

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
        <?php require('admin_navbar.php') ?>

        <div class="container justify-content-center text-center mt-5">
            <h1 class="mb-5">จัดการแพ็คเกจ</h1>

            <?php
                $pk_sql = "SELECT * FROM Package ORDER BY price ASC";
                $pk_result = mysqli_query($dbcon, $pk_sql);
                $packages = [];
                foreach($pk_result as $pk) {
                    array_push($packages, $pk['package_name']);
                }
            ?>

            <div class="row justify-content-center mb-3">
                <?php foreach($pk_result as $pkk) { ?>
                    <div class="position-relative rounded-3 shadow pr-4 pl-4 m-4" style="background-color: #412E2E; width: 300px; text-align: left;">
                        <div class="row text-center p-2" style="background-color: #2A1B1B;">
                            <h2><?php echo $pkk['package_name']; ?></h2>
                        </div>

                        <div class="p-2 mb-2">
                            <label class="text-white m-2">ราคา: <?php echo $pkk['price']; ?>฿ / เดือน</label><br>
                            <label class="text-white m-2">ความละเอียดสูงสุด: <?php echo $pkk['resolution']; ?></label><br>
                            <label class="text-white m-2">จำนวนอุปกรณ์: <?php echo $pkk['screens']; ?></label><br>
                            <label class="text-white m-2">อุปกรณ์ที่รองรับ: <?php echo $pkk['devices']; ?></label>
                        </div>

                        <div class="d-flex justify-content-end mt-2 mb-3">
                            <a class="text-decoration-none me-3" href="edit_package.php?id=<?php echo $pkk['package_name']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="black" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                            </a>
                            <a class="text-decoration-none" href="delete_package.php?id=<?php echo $pkk['package_name']; ?>" onclick="return confirm('ยืนยันการลบ?');">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="row justify-content-center">
                <a href="add_package.php" class="btn btn-warning" style="width: 150px;"><b>+ แพ็คเกจ</b></a>
            </div>

            <?php
                $sql_income = "SELECT 
                                summary.user_id,
                                u.user_name,
                                summary.Basic,
                                summary.Standard,
                                summary.Premium,
                                summary.total_revenue
                            FROM (
                                SELECT ph.user_id,";
                
                foreach($packages as $package) {
                    $sql_income .= "SUM(CASE WHEN pk.package_name = '".$package."' THEN pk.price ELSE 0 END) AS '".$package."',";
                }
                
                $sql_income .= "SUM(pk.price) AS total_revenue
                    FROM Payment_History ph
                    JOIN Package pk ON ph.package_name = pk.package_name
                    JOIN User u ON u.user_id = ph.user_id
                    GROUP BY ph.user_id
                    ) AS summary
                    JOIN User u ON summary.user_id = u.user_id";
                $result_income = mysqli_query($dbcon, $sql_income);
                $num_pk = mysqli_num_rows($result_income);
            ?>

            <div class="row justify-content-center mt-5">
                <h3>รายได้</h3>
            </div>

            <?php if($num_pk==0) { ?>
                <label class="mt-3">ไม่มีข้อมูล</label>
            <?php } else { ?>
                <?php
                    if(isset($_GET['p']) and $_GET['p'] != "") {
                        $page = $_GET['p'];
                    } else {
                        $page = 1;
                    }

                    if(isset($_GET['ps']) and $_GET['ps'] != "") {
                        $j = $_GET['ps'];
                    } else {
                        $j = 1;
                    }

                    $amount = 15;
                    $start = ($page*$amount) - $amount + 1;
                    $end = $page*$amount;
                    $c = 1;
                ?>

                <table class="table mt-4 table-dark table-hover table-borderless">
                    <thead>
                        <tr>
                        <th style="background-color: #534A4A;" width="5%" scope="col">ลำดับ</th>
                        <th style="background-color: #534A4A;" width="20%" scope="col">ชื่อผู้ใช้</th>
                        <?php foreach($packages as $pk) { ?>
                            <th style="background-color: #534A4A;" width="20%" scope="col"><?php echo $pk; ?></th>
                        <?php } ?>
                        <th style="background-color: #534A4A;" width="10%" scope="col">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($result_income as $data) { ?>
                            <?php if($c >= $start and $c <= $end) { ?>
                                <tr>
                                <td style="background-color: #412E2E;"><?php echo $i; ?></td>
                                <td style="background-color: #412E2E;"><?php echo $data['user_name']; ?></td>
                                <?php foreach($packages as $pk) { ?>
                                    <?php
                                        $price = $data[$pk];
                                        if($price >= 1000000) {
                                            $price = round($price/1000000, 2).' M';
                                        } else if($price >= 1000) {
                                            $price = round($price/1000, 2).' K';
                                        }
                                        
                                        $total = $data['total_revenue'];
                                        if($total >= 1000000) {
                                            $total = round($total/1000000, 2).' M';
                                        } else if($total >= 1000) {
                                            $total = round($total/1000, 2).' K';
                                        }
                                    ?>
                                    <td style="background-color: #412E2E;"><?php echo $price; ?></td>
                                <?php } ?>
                                <td style="background-color: #412E2E;"><?php echo $total; ?></td>
                                </tr>
                            <?php } $c++; ?>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <?php if($num_pk != 0) { ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="">
                    <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_package.php?srch=<?php echo $_GET['srch']?>&t=<?php echo $_GET['t']?>&a=<?php echo $_GET['a']?>&st=<?php echo $_GET['st']?>&so=<?php echo $_GET['so']?>&p=<?php if($j!=1) echo (($j-1)*10)-9; ?>&ps=<?php echo ($_GET['ps'] > 1) ? ($_GET['ps'] - 1) : 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <?php 
                        $pp = ceil($num_pk / $amount);
                        for($k = ($j * 10) - 10 + 1; ($k <= $j*10 and $k <= $pp); $k++) { ?>
                            <li class=""><a style="background-color: <?php if($k==1 and (!isset($_GET['p']) or $_GET['p']=="")) echo '#DBC245'; else if($_GET['p']==$k) echo '#DBC245'; else echo '#262121'; ?>;" class="border-0 page-link text-<?php if($k==1 and (!isset($_GET['p']) or $_GET['p']=="")) echo 'black'; else if($_GET['p']==$k) echo 'black'; else echo 'white'; ?> rounded-3" href="admin_package.php?srch=<?php echo $_GET['srch']?>&t=<?php echo $_GET['t']?>&a=<?php echo $_GET['a']?>&st=<?php echo $_GET['st']?>&so=<?php echo $_GET['so']?>&p=<?php echo $k; ?>&ps=<?php echo ceil($k/10); ?>"><?php echo $k; ?></a></li>
                    <?php } ?>
                            <li class="">
                            <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_package.php?srch=<?php echo $_GET['srch']?>&t=<?php echo $_GET['t']?>&a=<?php echo $_GET['a']?>&st=<?php echo $_GET['st']?>&so=<?php echo $_GET['so']?>&p=<?php if($j!=ceil($pp/10)) echo (($j+1)*10)-9; else echo $pp; ?>&ps=<?php if($j+1 <= ceil($pp/10)) echo $j+1; else echo $j; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                            </li>
                </ul>
            </nav>
        <?php } ?>

        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap.bundle.js"></script>

    </body>
    </html>

<?php } else { echo "<script>location.href='index.php';</script>";
    exit; } ?>