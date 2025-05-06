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

    <div class="container justify-content-center text-center mt-5">
        <h1>แดชบอร์ด</h1>

        <div class="row">
            <form action="admin_index.php" method="get">
                <div class="row justify-content-center">
                    <select name="m" class="form-select text-center m-4" style="width: 200px;">
                        <?php
                        $month = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
                        for($i=1; $i<=12; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $month[$i-1]; ?></option>
                        <?php } ?>
                    </select>

                    <select name="y" class="form-select text-center m-4" style="width: 200px;">
                        <?php
                        $sql2 = "SELECT MIN(year) AS min_year
                            FROM (
                                SELECT YEAR(register_date) AS year FROM User
                                UNION
                                SELECT YEAR(watch_date) AS year FROM History
                                UNION
                                SELECT YEAR(payment_datetime) AS year FROM Payment_History
                            ) AS all_years";
                        $result2 = mysqli_query($dbcon, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);

                        if(!is_null($row2['min_year'])) {
                            $myear = $row2['min_year'];
                        } else {
                            $myear = date("Y");
                        }

                        for($i=$myear; $i<=date("Y"); $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <div class="position-relative rounded-3 p-4 m-4" style="background-color: #412E2E; width: 300px; text-align: left;">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16" style="top: 10px; left: 10px;">
                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"/>
                </svg>

                <div class="mt-3 pt-3">
                    <label class="text-white">รายได้</label>
                    <h3 class="mt-2 text-white">$2.5M</h3>
                </div>
            </div>

            <div class="position-relative rounded-3 p-4 m-4" style="background-color: #412E2E; width: 300px; text-align: left;">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16" style="top: 10px; left: 10px;">
                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                </svg>

                <div class="mt-3 pt-3">
                    <label class="text-white">ยอดการรับชม</label>
                    <h3 class="mt-2 text-white">2.78M</h3>
                </div>
            </div>

            <div class="position-relative rounded-3 p-4 m-4" style="background-color: #412E2E; width: 300px; text-align: left;">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16" style="top: 10px; left: 10px;">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                </svg>

                <div class="mt-3 pt-3">
                    <label class="text-white">ผู้ใช้ใหม่</label>
                    <h3 class="mt-2 text-white">693K</h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="position-relative rounded-3 p-4 m-4" style="background-color: #412E2E; width: 650px; text-align: left;">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16" style="top: 10px; left: 10px;">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                </svg>

                <div class="mt-3 pt-3">
                    <label class="text-white">ผู้ใช้ / แพ็คเกจ</label>
                    <div id="myChart" style="max-width:700px; height:300px"></div>
                </div>
            </div>

            <div class="position-relative m-4" style="width: 300px; text-align: center;">
                <div class="row">
                    <a href="admin_media.php" class="btn btn-warning mb-5 mt-5" style="width: 300px;"><b>จัดการมีเดีย</b></a>
                    <a href="admin_package.php" class="btn btn-warning mb-5" style="width: 300px;"><b>จัดการแพ็คเกจ</b></a>
                    <a href="manage_users.php" class="btn btn-warning mb-5" style="width: 300px;"><b>จัดการผู้ใช้</b></a>
                    <a href="manage_admin.php" class="btn btn-warning mb-5" style="width: 300px;"><b>จัดการแอดมิน</b></a>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current',{packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            const data = google.visualization.arrayToDataTable([
            ['Contry', 'Mhl'],
            ['Italy', 55],
            ['France', 49],
            ['Spain', 44],
            ['USA', 24],
            ['Argentina', 15]
            ]);

            const options = {
                backgroundColor: 'transparent',
                legend: {
                    textStyle: { color: 'white', fontSize: 14 },
                    alignment: 'center', 
                    position: 'right'
                },
                pieSliceTextStyle: {
                    color: 'white'
                },
                chartArea: {
                    left: 20,
                    top: 20,
                    width: '100%',
                    height: '80%'
                }
            };

            const chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);
        }
    </script>

</body>
</html>

<?php } else { header("Location: index.php"); } ?>