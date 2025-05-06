<?php $pageName = basename($_SERVER['PHP_SELF']); ?>

<div class="black-bg d-flex flex-column justify-content-between" style="width: 180px; height: 100vh; position: fixed; top: 0; left: 0;">
    <div>
        <div class="mt-3" style="margin-left: 20px;">
            <h1 style="font-size: 40px; color: white;">Yuno</h1>
        </div>

        <div class="nav flex-column mt-4 text-start" style="margin-left: 20px;">
            <a class="link mt-2" href="admin_index.php" style="<?php if($pageName=='admin_index.php') echo 'color: yellow;'; ?>">แดชบอร์ด</a>
            <a class="link mt-2" href="admin_media.php" style="<?php if($pageName=='admin_media.php' or $pageName=='add_media.php' or $pageName=='edit_media.php') echo 'color: yellow;'; ?>">มีเดีย</a>
            <?php if($_SESSION['user_lv'] == 1) { ?>
                <a class="link mt-2" href="admin_package.php" style="<?php if($pageName=='admin_package.php' or $pageName=='add_package.php' or $pageName=='edit_package.php') echo 'color: yellow;'; ?>">แพ็คเกจ</a>
                <a class="link mt-2" href="admin_user.php" style="<?php if($pageName=='admin_user.php' or $pageName=='register.php' or $pageName=='edit_user.php' or $pageName=='add_admin.php' or $pageName=='edit_admin.php') echo 'color: yellow;'; ?>">ผู้ใช้</a>
            <?php } ?>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between px-3 mb-3 text-white">
        <span>Admin</span>
        <a href="logout.php" onclick="return confirm('ยืนยันการออกจากระบบ?');">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="red" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
            </svg>
        </a>
    </div>
</div>