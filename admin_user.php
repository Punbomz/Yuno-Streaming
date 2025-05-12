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
        <h1>จัดการผู้ใช้</h1>

        <form action="admin_user.php" method="get" class="mt-5">
            <div class="row justify-content-center">
                <input type="search" name="srch" class="form-control rounded-5" placeholder="ค้นหา" style="width: 400px;" value="<?php echo $_GET['srch']; ?>">
                <button type="submit" class="btn justify-content-center" style="width: 50px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
            </div>
        </form>

        <div class="container justify-content-center text-center mt-3">
            <?php
                $sql_user = "SELECT u.user_id, u.user_name, u.user_email, up.package_name FROM User u INNER JOIN User_Package up ON u.user_id=up.user_id WHERE u.user_lv=0";

                if(isset($_GET['srch']) and $_GET['srch']!='') {
                    $sql_user.=" AND u.user_name LIKE '%".$_GET['srch']."%' OR u.user_email LIKE '%".$_GET['srch']."%'";
                }

                if(isset($_GET['upa']) and $_GET['upa']!='') {
                    $sql_user.=" AND up.package_name='".$_GET['upa']."'";
                }

                if(isset($_GET['uso']) and $_GET['uso']!='') {
                    if($_GET['uso']==0) {
                        $sql_user.=" ORDER BY u.user_name ASC";
                    } else if($_GET['uso']==1) {
                        $sql_user.=" ORDER BY u.user_id DESC";
                    } else if($_GET['uso']==2) {
                        $sql_user.=" ORDER BY u.user_id ASC";
                    }
                }

                $result_user = mysqli_query($dbcon, $sql_user);
                $num_user = mysqli_num_rows($result_user);
            ?>

            <div class="row">
                <form action="admin_user.php" method="get">
                    <div class="row justify-content-center mt-5">
                        <h3>ผู้ใช้</h3>
                    </div>

                    <div class="row justify-content-center">
                        <select name="upa" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_user.php?srch=<?php echo $_GET['srch']; ?>&uso=<?php echo $_GET['uso']; ?>&up=<?php echo $_GET['up']; ?>&ups=<?php echo $_GET['ups']; ?>&aso=<?php echo $_GET['aso']; ?>&ap=<?php echo $_GET['ap']; ?>&aps=<?php echo $_GET['aps']; ?>&lv=<?php echo $_GET['lv']; ?>&upa=' + this.value;">
                            <option value=''>แพ็คเกจ</option>
                            <?php
                                $sql1 = "SELECT * FROM Package ORDER BY price";
                                $result1 = mysqli_query($dbcon, $sql1);
                                foreach($result1 as $row1) { ?>
                                    <option value="<?php echo $row1['package_name']; ?>" <?php if($row1['package_name']==$_GET['upa']) echo 'selected'; ?>><?php echo $row1['package_name']; ?></option>
                            <?php } ?>
                        </select>

                        <select name="uso" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_user.php?srch=<?php echo $_GET['srch']; ?>&upa=<?php echo $_GET['upa']; ?>&up=<?php echo $_GET['up']; ?>&ups=<?php echo $_GET['ups']; ?>&aso=<?php echo $_GET['aso']; ?>&ap=<?php echo $_GET['ap']; ?>&aps=<?php echo $_GET['aps']; ?>&lv=<?php echo $_GET['lv']; ?>&uso=' + this.value;">
                            <option value='0' <?php if('0'==$_GET['uso']) echo 'selected'; ?>>เรียงตามตัวอักษร</option>
                            <option value='1' <?php if('1'==$_GET['uso']) echo 'selected'; ?>>เรียงตามข้อมูลล่าสุด</option>
                            <option value='2' <?php if('2'==$_GET['uso']) echo 'selected'; ?>>เรียงตามข้อมูลเก่าสุด</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="row justify-content-center mt-3">
                <a href="register.php" class="btn btn-warning" style="width: 150px;"><b>+ เพิ่มผู้ใช้</b></a>
            </div>

            <?php if($num_user==0) { ?>
                <label class="mt-3">ไม่มีข้อมูล</label>
            <?php } else { ?>
                <?php
                    if(isset($_GET['up']) and $_GET['up'] != "") {
                        $upage = $_GET['up'];
                    } else {
                        $upage = 1;
                    }

                    if(isset($_GET['ups']) and $_GET['ups'] != "") {
                        $uj = $_GET['ups'];
                    } else {
                        $uj = 1;
                    }

                    $amount = 10;
                    $ustart = ($upage*$amount) - $amount + 1;
                    $uend = $upage*$amount;
                    $uc = 1;
                ?>
                <table class="table mt-3 table-dark table-hover table-borderless">
                    <thead>
                        <tr>
                        <th style="background-color: #534A4A;" width="5%" scope="col">ลำดับ</th>
                        <th style="background-color: #534A4A;" width="20%" scope="col">ชื่อผู้ใช้</th>
                        <th style="background-color: #534A4A;" width="20%" scope="col">อีเมล</th>
                        <th style="background-color: #534A4A;" width="10%" scope="col">แพ็คเกจ</th>
                        <th style="background-color: #534A4A;" width="10%" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($result_user as $row_user) { ?>
                            <?php if($uc >= $ustart and $uc <= $uend) { ?>
                                <tr>
                                <td style="background-color: #412E2E;"><?php echo $i; ?></td>
                                <td style="background-color: #412E2E;"><?php echo $row_user['user_name']; ?></td>
                                <td style="background-color: #412E2E;"><?php echo $row_user['user_email']; ?></td>
                                <td style="background-color: #412E2E;"><?php if($row_user['package_name']=="") echo '-'; else echo $row_user['package_name']; ?></td>
                                <td style="background-color: #412E2E;">
                                    <a class="text-decoration-none m-3" href="edit_user.php?id=<?php echo $row_user['user_id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                    </a>
                                    <a class="text-decoration-none m-3" href="delete_user.php?id=<?php echo $row_user['user_id']; ?>" onclick="return confirm('ยืนยันการลบ?');">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </a>
                                </td>
                                </tr>
                            <?php } $uc++; ?>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <?php if($num_user != 0) { ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="">
                    <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_user.php?srch=<?php echo $_GET['srch']?>&pa=<?php echo $_GET['pa']?>&so=<?php echo $_GET['so']?>&p=<?php if($uj!=1) echo (($uj-1)*10)-9; ?>&ps=<?php echo ($_GET['ps'] > 1) ? ($_GET['ps'] - 1) : 1; ?>&aso=<?php echo $_GET['aso']; ?>&ap=<?php echo $_GET['ap']; ?>&aps=<?php echo $_GET['aps']; ?>&lv=<?php echo $_GET['lv']; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <?php 
                        $upp = ceil($num_user / $amount);
                        for($k = ($uj * 10) - 10 + 1; ($k <= $uj*10 and $k <= $upp); $k++) { ?>
                            <li class=""><a style="background-color: <?php if($k==1 and (!isset($_GET['up']) or $_GET['up']=="")) echo '#DBC245'; else if($_GET['up']==$k) echo '#DBC245'; else echo '#262121'; ?>;" class="border-0 page-link text-<?php if($k==1 and (!isset($_GET['up']) or $_GET['up']=="")) echo 'black'; else if($_GET['up']==$k) echo 'black'; else echo 'white'; ?> rounded-3" href="admin_user.php?srch=<?php echo $_GET['srch']?>&upa=<?php echo $_GET['upa']?>&uso=<?php echo $_GET['uso']?>&up=<?php echo $k; ?>&ups=<?php echo ceil($k/10); ?>&aso=<?php echo $_GET['aso']; ?>&ap=<?php echo $_GET['ap']; ?>&aps=<?php echo $_GET['aps']; ?>&lv=<?php echo $_GET['lv']; ?>"><?php echo $k; ?></a></li>
                    <?php } ?>
                            <li class="">
                            <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_user.php?srch=<?php echo $_GET['srch']?>&upa=<?php echo $_GET['upa']?>&uso=<?php echo $_GET['uso']?>&up=<?php if($uj!=ceil($upp/10)) echo (($uj+1)*10)-9; else echo $upp; ?>&ups=<?php if($uj+1 <= ceil($upp/10)) echo $uj+1; else echo $uj; ?>&aso=<?php echo $_GET['aso']; ?>&ap=<?php echo $_GET['ap']; ?>&aps=<?php echo $_GET['aps']; ?>&lv=<?php echo $_GET['lv']; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                            </li>
                </ul>
            </nav>
        <?php } ?>

        <div class="row justify-content-center mt-5">
            <h3>แอดมิน</h3>
        </div>

        <?php
            $sql_admin = "SELECT user_id, user_name, user_email, user_lv FROM User WHERE user_lv!=0";

            if(isset($_GET['srch']) and $_GET['srch']!='') {
                $sql_admin.=" AND user_name LIKE '%".$_GET['srch']."%' OR user_email LIKE '%".$_GET['srch']."%'";
            }

            if(isset($_GET['lv']) and $_GET['lv']!='') {
                $sql_admin.=" AND user_lv='".$_GET['lv']."'";
            }

            if(isset($_GET['aso']) and $_GET['aso']!='') {
                if($_GET['aso']==0) {
                    $sql_admin.=" ORDER BY user_name ASC";
                } else if($_GET['aso']==1) {
                    $sql_admin.=" ORDER BY user_id DESC";
                } else if($_GET['aso']==2) {
                    $sql_admin.=" ORDER BY user_id ASC";
                }
            }

            $result_admin = mysqli_query($dbcon, $sql_admin);
            $num_admin = mysqli_num_rows($result_admin);
        ?>

        <div class="row">
            <form action="admin_user.php" method="get">
                <div class="row justify-content-center">
                    <select name="lv" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_user.php?srch=<?php echo $_GET['srch']; ?>&aso=<?php echo $_GET['aso']; ?>&ap=<?php echo $_GET['ap']; ?>&aps=<?php echo $_GET['aps']; ?>&uso=<?php echo $_GET['uso']; ?>&up=<?php echo $_GET['up']; ?>&ups=<?php echo $_GET['ups']; ?>&upa=<?php echo $_GET['upa'];?>&lv=' + this.value;">
                        <option value=''>ระดับ</option>
                        <option value="1" <?php if(1==$_GET['lv']) echo 'selected'; ?>>แอดมินระบบ</option>
                        <option value="2" <?php if(2==$_GET['lv']) echo 'selected'; ?>>แอดมินมีเดีย</option>
                    </select>

                    <select name="aso" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_user.php?srch=<?php echo $_GET['srch']; ?>&lv=<?php echo $_GET['lv']; ?>&ap=<?php echo $_GET['ap']; ?>&aps=<?php echo $_GET['aps']; ?>&uso=<?php echo $_GET['uso']; ?>&up=<?php echo $_GET['up']; ?>&ups=<?php echo $_GET['ups']; ?>&upa=<?php echo $_GET['upa'];?>&aso=' + this.value;">
                        <option value='0' <?php if('0'==$_GET['aso']) echo 'selected'; ?>>เรียงตามตัวอักษร</option>
                        <option value='1' <?php if('1'==$_GET['aso']) echo 'selected'; ?>>เรียงตามข้อมูลล่าสุด</option>
                        <option value='2' <?php if('2'==$_GET['aso']) echo 'selected'; ?>>เรียงตามข้อมูลเก่าสุด</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="row justify-content-center mt-3">
            <a href="add_admin.php" class="btn btn-warning" style="width: 150px;"><b>+ เพิ่มแอดมิน</b></a>
        </div>

        <?php if($num_admin==0) { ?>
            <label class="mt-3">ไม่มีข้อมูล</label>
        <?php } else { ?>
            <?php
                if(isset($_GET['ap']) and $_GET['ap'] != "") {
                    $apage = $_GET['ap'];
                } else {
                    $apage = 1;
                }

                if(isset($_GET['aps']) and $_GET['aps'] != "") {
                    $aj = $_GET['aps'];
                } else {
                    $aj = 1;
                }

                $amount = 10;
                $astart = ($apage*$amount) - $amount + 1;
                $aend = $apage*$amount;
                $ac = 1;
            ?>
            <table class="table mt-3 table-dark table-hover table-borderless">
                <thead>
                    <tr>
                    <th style="background-color: #534A4A;" width="5%" scope="col">ลำดับ</th>
                    <th style="background-color: #534A4A;" width="20%" scope="col">ชื่อผู้ใช้</th>
                    <th style="background-color: #534A4A;" width="20%" scope="col">อีเมล</th>
                    <th style="background-color: #534A4A;" width="10%" scope="col">ระดับ</th>
                    <th style="background-color: #534A4A;" width="10%" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($result_admin as $row_admin) { ?>
                        <?php if($ac >= $astart and $ac <= $aend) { ?>
                            <tr>
                            <td style="background-color: #412E2E;"><?php echo $i; ?></td>
                            <td style="background-color: #412E2E;"><?php echo $row_admin['user_name']; ?></td>
                            <td style="background-color: #412E2E;"><?php echo $row_admin['user_email']; ?></td>
                            <td style="background-color: #412E2E;"><?php if($row_admin['user_lv']==1) echo 'แอดมินระบบ'; else echo 'แอดมินมีเดีย'; ?></td>
                            <td style="background-color: #412E2E;">
                                <a class="text-decoration-none m-3" href="edit_admin.php?id=<?php echo $row_admin['user_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>
                                <a class="text-decoration-none m-3" href="delete_user.php?id=<?php echo $row_admin['user_id']; ?>" onclick="return confirm('ยืนยันการลบ?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </td>
                            </tr>
                        <?php } $ac++; ?>
                    <?php $i++; } ?>
                </tbody>
            </table>
        <?php } ?>
        
        <?php if($num_admin != 0) { ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="">
                    <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_user.php?srch=<?php echo $_GET['srch']?>&lv=<?php echo $_GET['lv']?>&aso=<?php echo $_GET['aso']?>&p=<?php if($aj!=1) echo (($aj-1)*10)-9; ?>&aps=<?php echo ($_GET['aps'] > 1) ? ($_GET['aps'] - 1) : 1; ?>&uso=<?php echo $_GET['uso']; ?>&up=<?php echo $_GET['up']; ?>&ups=<?php echo $_GET['ups']; ?>&upa=<?php echo $_GET['upa'];?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <?php 
                        $app = ceil($num_admin / $amount);
                        for($k = ($aj * 10) - 10 + 1; ($k <= $aj*10 and $k <= $app); $k++) { ?>
                            <li class=""><a style="background-color: <?php if($k==1 and (!isset($_GET['ap']) or $_GET['ap']=="")) echo '#DBC245'; else if($_GET['ap']==$k) echo '#DBC245'; else echo '#262121'; ?>;" class="border-0 page-link text-<?php if($k==1 and (!isset($_GET['ap']) or $_GET['ap']=="")) echo 'black'; else if($_GET['ap']==$k) echo 'black'; else echo 'white'; ?> rounded-3" href="admin_user.php?srch=<?php echo $_GET['srch']?>&lv=<?php echo $_GET['lv']?>&aso=<?php echo $_GET['aso']?>&ap=<?php echo $k; ?>&aps=<?php echo ceil($k/10); ?>&uso=<?php echo $_GET['uso']; ?>&up=<?php echo $_GET['up']; ?>&ups=<?php echo $_GET['ups']; ?>&upa=<?php echo $_GET['upa'];?>"><?php echo $k; ?></a></li>
                    <?php } ?>
                            <li class="">
                            <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_user.php?srch=<?php echo $_GET['srch']?>&lv=<?php echo $_GET['lv']?>&aso=<?php echo $_GET['aso']?>&ap=<?php if($aj!=ceil($app/10)) echo (($aj+1)*10)-9; else echo $app; ?>&ups=<?php if($aj+1 <= ceil($app/10)) echo $aj+1; else echo $aj; ?>&uso=<?php echo $_GET['uso']; ?>&up=<?php echo $_GET['up']; ?>&ups=<?php echo $_GET['ups']; ?>&upa=<?php echo $_GET['upa'];?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                            </li>
                </ul>
            </nav>
        <?php } ?>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>

<?php } else { echo "<script>location.href='index.php';</script>";
    exit; } ?>