<?php require('connect.php'); ?>

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
        <?php require('admin_navbar.php') ?>
        <div class="container d-flex justify-content-center align-items-center flex-column" style="min-height: 80vh;">

        <h1 class="mb-4">เพิ่มแพ็คเกจ</h1>

        <form action="package_save.php" id="packageForm" onsubmit="return validateDeviceSelection()" method="post">
            <div class="row p-3 rounded-3 justify-content-center" style="background-color: #412E2E; width: 550px;">

                <div class="row justify-content-center mt-4">
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label>ชื่อ</label>
                        </div>
                        <input name="name" type="text" class="form-control mb-3" style="background-color: #A8A0A0;" placeholder="ระบุชื่อแพ็คเกจ" required>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label>ราคา / เดือน</label>
                        </div>
                        <input name="price" type="number" step="0.01" min="0" class="form-control mb-3" style="background-color: #A8A0A0;" placeholder="ระบุราคา" required>
                    </div>
                </div>

                <div class="row justify-content-center mt-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label>ความละเอียด</label>
                        </div>
                        <select name="res" class="form-select mb-3 text-center" style="background-color: #A8A0A0;" required>
                            <option value="SD">SD</option>
                            <option value="HD">HD</option>
                            <option value="FHD">FHD</option>
                            <option value="2K">2K</option>
                            <option value="4K">4K</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label>จำนวนอุปกรณ์</label>
                        </div>
                        <input name="screen" type="number" class="form-control mb-3 text-center" min="1" step="1" style="background-color: #A8A0A0;" placeholder="ระบุจำนวนอุปกรณ์" required>
                    </div>
                </div>

                <div class="row justify-content-center mt-3">
                    <div class="mb-2">
                        <label>อุปกรณ์ที่รองรับ</label>
                    </div>
                    <div class="d-flex flex-column" style="gap: 10px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="device[]" value="มือถือ" id="mobile">
                            <label class="form-check-label" for="mobile">มือถือ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="device[]" value="แท็บเล็ต" id="tablet">
                            <label class="form-check-label" for="tablet">แท็บเล็ต</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="device[]" value="คอมพิวเตอร์" id="computer">
                            <label class="form-check-label" for="computer">คอมพิวเตอร์</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="device[]" value="ทีวี" id="tv">
                            <label class="form-check-label" for="tv">ทีวี</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <button class="btn btn-warning" style="width: 150px; margin-right: 25px;" onclick="return confirm('ยืนยันการบันทึก?');">บันทึก</button>
                <button type="button" class="btn btn-danger text-black" style="width: 150px; margin-left: 25px;"onclick="if (confirm('ยืนยันการยกเลิก?')) history.back();">ยกเลิก</button>
            </div>
        </form>
    </div>

        <?php if(!(isset($_SESSION['logined']) and $_SESSION['user_lv']!=0)) require('footer.php'); ?>
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
    <script>
        function validateDeviceSelection() {
            const checkboxes = document.querySelectorAll('input[name="device[]"]');
            const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            if (!isChecked) {
                alert("กรุณาเลือกอุปกรณ์อย่างน้อย 1 รายการ");
                return false;
            }
            return true;
        }
    </script>
    </body>

    </html>
 <?php } else {
    echo "<script>location.href='index.php';</script>";
    exit;
 } ?>