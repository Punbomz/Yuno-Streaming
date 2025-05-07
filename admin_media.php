<?php require('connect.php') ?>

<?php if(isset($_SESSION['logined']) and ($_SESSION['user_lv']==1 or $_SESSION['user_lv']==2)) { ?>

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

    <?php
        $sql = "SELECT m.media_id, m.media_img, m.media_title, m.media_status, t.*, IFNULL(v.Views, 0) AS Views FROM Media m LEFT JOIN Type t ON m.type_id=t.type_id LEFT JOIN (SELECT h.media_id, COUNT(*) AS Views FROM History h GROUP BY h.media_id) v ON m.media_id = v.media_id WHERE 1";

        if(isset($_GET['srch']) and $_GET['srch']!='') {
            $sql.=" AND m.media_title LIKE '%".$_GET['srch']."%'";
        }

        if(isset($_GET['t']) and $_GET['t']!='') {
            $sql.=" AND m.type_id='".$_GET['t']."'";
        }

        if(isset($_GET['a']) and $_GET['a']!='' and $_GET['a']!=0) {
            $sql.=" AND m.media_rate='".$_GET['a']."'";
        }

        if(isset($_GET['st']) and $_GET['st']!='') {
            $sql.=" AND m.media_status='".$_GET['st']."'";
        }

        if(isset($_GET['so']) and $_GET['so']!='') {
            if($_GET['so']==0) {
                $sql.=" ORDER BY m.media_title ASC";
            } else if($_GET['so']==1) {
                $sql.=" ORDER BY m.media_id DESC";
            } else if($_GET['so']==2) {
                $sql.=" ORDER BY m.media_id ASC";
            } else if($_GET['so']==3) {
                $sql.=" ORDER BY v.Views ASC";
            } else if($_GET['so']==3) {
                $sql.=" ORDER BY v.Views DESC";
            }
        }

        $result = mysqli_query($dbcon, $sql);
        $num = mysqli_num_rows($result);
    ?>

    <div class="container justify-content-center text-center mt-5">
        <h2>จัดการมีเดีย</h2>

        <div class="row">
            <form action="admin_media.php" method="get">
                <div class="row justify-content-center mt-4">
                    <input type="search" name="srch" class="form-control rounded-5" placeholder="ค้นหา" style="width: 400px;" value="<?php echo $_GET['srch']; ?>">
                    <button type="submit" class="btn justify-content-center" style="width: 50px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                </div>

                <div class="row justify-content-center">
                    <select name="t" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_media.php?srch=<?php echo $_GET['srch']; ?>&a=<?php echo $_GET['a']; ?>&st=<?php echo $_GET['st']; ?>&so=<?php echo $_GET['so']; ?>&p=<?php echo $_GET['p']; ?>&ps=<?php echo $_GET['ps']; ?>&t=' + this.value;">
                        <option value=''>ประเภททั้งหมด</option>
                        <?php
                            $sql1 = "SELECT * FROM Type ORDER BY type_name";
                            $result1 = mysqli_query($dbcon, $sql1);
                            foreach($result1 as $row1) { ?>
                                <option value="<?php echo $row1['type_id']; ?>" <?php if($row1['type_id']==$_GET['t']) echo 'selected'; ?>><?php echo $row1['type_name']; ?></option>
                        <?php } ?>
                    </select>

                    <select name="a" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_media.php?srch=<?php echo $_GET['srch']; ?>&t=<?php echo $_GET['t']; ?>&st=<?php echo $_GET['st']; ?>&so=<?php echo $_GET['so']; ?>&p=<?php echo $_GET['p']; ?>&ps=<?php echo $_GET['ps']; ?>&a=' + this.value;">
                        <option value='' <?php if(''==$_GET['a']) echo 'selected'; ?>>ช่วงอายุทั้งหมด</option>
                        <option value='1' <?php if('1'==$_GET['a']) echo 'selected'; ?>>สำหรับเด็ก</option>
                        <option value='2' <?php if('2'==$_GET['a']) echo 'selected'; ?>>ทุกวัย</option>
                        <option value='3' <?php if('3'==$_GET['a']) echo 'selected'; ?>>13+</option>
                        <option value='4' <?php if('4'==$_GET['a']) echo 'selected'; ?>>18+</option>
                    </select>

                    <select name="st" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_media.php?srch=<?php echo $_GET['srch']; ?>&a=<?php echo $_GET['a']; ?>&t=<?php echo $_GET['t']; ?>&so=<?php echo $_GET['so']; ?>&p=<?php echo $_GET['p']; ?>&ps=<?php echo $_GET['ps']; ?>&st=' + this.value;">
                        <option value='' <?php if(''==$_GET['st']) echo 'selected'; ?>>สถานะทั้งหมด</option>
                        <option value='1' <?php if('1'==$_GET['st']) echo 'selected'; ?>>กำลังฉาย</option>
                        <option value='0' <?php if('0'==$_GET['st']) echo 'selected'; ?>>หยุดฉาย</option>
                    </select>

                    <select name="so" class="form-select text-center m-4" style="width: 200px;" onchange="window.location.href='admin_media.php?srch=<?php echo $_GET['srch']; ?>&a=<?php echo $_GET['a']; ?>&st=<?php echo $_GET['st']; ?>&t=<?php echo $_GET['t']; ?>&p=<?php echo $_GET['p']; ?>&ps=<?php echo $_GET['ps']; ?>&so=' + this.value;">
                        <option value='0' <?php if('0'==$_GET['so']) echo 'selected'; ?>>เรียงตามตัวอักษร</option>
                        <option value='1' <?php if('1'==$_GET['so']) echo 'selected'; ?>>เรียงตามข้อมูลล่าสุด</option>
                        <option value='2' <?php if('2'==$_GET['so']) echo 'selected'; ?>>เรียงตามข้อมูลเก่าสุด</option>
                        <option value='3' <?php if('3'==$_GET['so']) echo 'selected'; ?>>เรียงตามยอดรับชมน้อยที่สุด</option>
                        <option value='4' <?php if('4'==$_GET['so']) echo 'selected'; ?>>เรียงตามยอดรับชมมากที่สุด</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <a href="add_media.php" class="btn btn-warning" style="width: 150px;"><b>+ เพิ่มมีเดีย</b></a>
        </div>

        <?php if($num==0) { ?>
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
                    <th style="background-color: #534A4A;" width="20%" scope="col">โปสเตอร์</th>
                    <th style="background-color: #534A4A;" width="20%" scope="col">ชื่อ</th>
                    <th style="background-color: #534A4A;" width="10%" scope="col">ประเภท</th>
                    <th style="background-color: #534A4A;" width="10%" scope="col">ยอดรับชม</th>
                    <th style="background-color: #534A4A;" width="10%" scope="col">สถานะ</th>
                    <th style="background-color: #534A4A;" width="10%" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($result as $row) { ?>
                        <?php if($c >= $start and $c <= $end) { ?>
                            <tr>
                            <td style="background-color: #412E2E;"><?php echo $i; ?></td>
                            <td style="background-color: #412E2E;"><img class="rounded-3" src="img/media/posters/<?php echo $row['media_img']; ?>" style="width: 144px; height: 193px;"></td>
                            <td style="background-color: #412E2E;"><?php echo $row['media_title']; ?></td>
                            <td style="background-color: #412E2E;"><?php echo $row['type_name']; ?></td>
                            <td style="background-color: #412E2E;"><?php echo $row['Views']; ?></td>
                            <td style="background-color: #412E2E;"><?php if($row['media_status']==0) echo 'หยุดฉาย'; else echo 'กำลังฉาย'; ?></td>
                            <td style="background-color: #412E2E;">
                                <a class="text-decoration-none m-3" href="edit_media.php?id=<?php echo $row['media_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>
                                <a class="text-decoration-none m-3" href="delete_media.php?id=<?php echo $row['media_id']; ?>" onclick="return confirm('ยืนยันการลบ?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </td>
                            </tr>
                        <?php } $c++; ?>
                    <?php $i++; } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <?php if($num != 0) { ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="">
                <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_media.php?srch=<?php echo $_GET['srch']?>&t=<?php echo $_GET['t']?>&a=<?php echo $_GET['a']?>&st=<?php echo $_GET['st']?>&so=<?php echo $_GET['so']?>&p=<?php if($j!=1) echo (($j-1)*10)-9; ?>&ps=<?php echo ($_GET['ps'] > 1) ? ($_GET['ps'] - 1) : 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
                </li>
                <?php 
                    $pp = ceil($num / $amount);
                    for($k = ($j * 10) - 10 + 1; ($k <= $j*10 and $k <= $pp); $k++) { ?>
                        <li class=""><a style="background-color: <?php if($k==1 and (!isset($_GET['p']) or $_GET['p']=="")) echo '#DBC245'; else if($_GET['p']==$k) echo '#DBC245'; else echo '#262121'; ?>;" class="border-0 page-link text-<?php if($k==1 and (!isset($_GET['p']) or $_GET['p']=="")) echo 'black'; else if($_GET['p']==$k) echo 'black'; else echo 'white'; ?> rounded-3" href="admin_media.php?srch=<?php echo $_GET['srch']?>&t=<?php echo $_GET['t']?>&a=<?php echo $_GET['a']?>&st=<?php echo $_GET['st']?>&so=<?php echo $_GET['so']?>&p=<?php echo $k; ?>&ps=<?php echo ceil($k/10); ?>"><?php echo $k; ?></a></li>
                <?php } ?>
                        <li class="">
                        <a style="background-color: #262121;" class="page-link text-white border-0" href="admin_media.php?srch=<?php echo $_GET['srch']?>&t=<?php echo $_GET['t']?>&a=<?php echo $_GET['a']?>&st=<?php echo $_GET['st']?>&so=<?php echo $_GET['so']?>&p=<?php if($j!=ceil($pp/10)) echo (($j+1)*10)-9; else echo $pp; ?>&ps=<?php if($j+1 <= ceil($pp/10)) echo $j+1; else echo $j; ?>" aria-label="Next">
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

<?php } else { header("Location: index.php"); } ?>