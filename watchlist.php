<?php
require('connect.php');

// ไม่ต้องเช็ค session หรือ login
$media_items = [];

$dbcon->set_charset("utf8mb4");
$sql = "SELECT 
    m.media_id,
    m.media_title,
    m.media_desc,
    m.media_img
FROM 
    Watchlist w
JOIN 
    Media m ON w.media_id = m.media_id
WHERE 
    w.user_id = 1;

";
$result = $dbcon->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $media_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Watchlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mycss.css" rel="stylesheet">
    <style>


        .watchlist-header {
            position: fixed;
            top: 70px; /* ปรับตามความสูง navbar */
            left: 0;
            right: 0;
            z-index: 10;
            padding: 20px 15%;
        }

        .watchlist-header h1 {
            font-size: 48px;
            font-weight: bold;
            margin: 0;
            margin-bottom: 1px;
        }

        .watchlist-scroll {
            position: absolute;
            top: 150px; /* ต้องไม่ชน navbar + header */
            left: 0;
            right: 0;
            bottom: 0;
            overflow-y: auto;
            padding: 20px 15%;
            color: white;
        }

        .watchlist-item {
            display: flex;
            margin-bottom: 40px;
        }

        .watchlist-item img {
            width: 300px;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        .watchlist-info {
            margin-left: 30px;
        }

        .watchlist-info h2 {
            font-size: 24px;
            font-weight: bold;
        }

        .watchlist-info p {
            margin-top: 10px;
            color: #ccc;
        }
    </style>
</head>
<body class="dark-bg">
    <?php require('navbar.php') ?>

    <div class="watchlist-header dark-bg" >
        <h1>Watchlist</h1>
    </div>

    <div class="watchlist-scroll">
        <?php foreach ($media_items as $item): ?>
            <div class="watchlist-item">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($item['media_img']); ?>" alt="<?php echo htmlspecialchars($item['media_title']); ?>">
                <div class="watchlist-info">
                    <h2><?php echo htmlspecialchars($item['media_title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($item['media_desc'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($media_items)): ?>
            <p class="text-center">ไม่พบสื่อในระบบ</p>
        <?php endif; ?>
        <?php require('footer.php'); ?>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

</body>
</html>
