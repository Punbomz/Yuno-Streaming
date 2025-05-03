<?php
require('connect.php');
$dbcon->set_charset("utf8mb4");

// มาใหม่
$sql_latest = "SELECT media_id, media_title, media_img FROM media ORDER BY media_release DESC LIMIT 7";
$result_latest = $dbcon->query($sql_latest);
$media_latest = $result_latest ? $result_latest->fetch_all(MYSQLI_ASSOC) : [];

// หมวดหมู่ตาม genre
$sql_genres = "SELECT genre.genre_id, genre.genre_name FROM genre";
$result_genres = $dbcon->query($sql_genres);
$genres = $result_genres ? $result_genres->fetch_all(MYSQLI_ASSOC) : [];

$genre_media = [];
foreach ($genres as $genre) {
    $stmt = $dbcon->prepare("
        SELECT m.media_id, m.media_title, m.media_img 
        FROM media m
        JOIN movies_genre mg ON m.media_id = mg.media_id
        WHERE mg.genre_id = ?
        ORDER BY m.media_release DESC LIMIT 10
    ");
    $stmt->bind_param("i", $genre['genre_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $genre_media[$genre['genre_id']] = $res->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Discover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mycss.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1a1a;
            color: white;
        }
        .discover-section {
            padding: 50px 5%;
            position: relative;
        }
        h1, h2 {
            font-weight: bold;
            margin-left: 20px;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 30px;
        }
        h2 {
            font-size: 34px;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .media-row {
            position: relative;
        }
        .scroll-container {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 10px;

        }
        .scroll-container::-webkit-scrollbar {
            display: none;
        }
        .media-card {
            flex: 0 0 auto;
            margin-right: 20px;
            text-align: center;
        }
        .media-card img {
            width: 250px;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }
        .scroll-btn {
            position: absolute;
            top: 40%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            width: 30px;
            height: 30px;
            cursor: pointer;
            z-index: 10;
            padding: 0;
        }
        .scroll-btn img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .scroll-btn:hover img {
            opacity: 1;
        }
        .scroll-left {
            left: 10px;
        }
        .scroll-right {
            right: 10px;
        }
        .arrow-icon {
            opacity: 0.9;
        }
        .rotate-left {
            transform: rotate(270deg);
        }
        .rotate-right {
            transform: rotate(90deg);
        }
    </style>
</head>
<body class="dark-bg">
<?php require('navbar.php') ?>
<div class="discover-section">
    <h1>Discover</h1>


    <h2>มาใหม่</h2>
    <div class="media-row">
        <button class="scroll-btn scroll-left">
            <img src="images/arrow.png" class="arrow-icon rotate-left" alt="เลื่อนซ้าย">
        </button>

        <div class="scroll-container">
            <?php foreach ($media_latest as $item): ?>
                <div class="media-card">
                    <img src="data:image/jpeg;base64,<?= base64_encode($item['media_img']); ?>" alt="<?= htmlspecialchars($item['media_title']); ?>">
                    <p class="mt-2"><?= htmlspecialchars($item['media_title']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="scroll-btn scroll-right">
            <img src="images/arrow.png" class="arrow-icon rotate-right" alt="เลื่อนขวา">
        </button>
    </div>


    <?php foreach ($genres as $genre): ?>
        <?php if (!empty($genre_media[$genre['genre_id']])): ?>
            <h2><?= htmlspecialchars($genre['genre_name']) ?></h2>
            <div class="media-row">
                <button class="scroll-btn scroll-left">
                    <img src="images/arrow.png" class="arrow-icon rotate-left" alt="เลื่อนซ้าย">
                </button>
                <button class="scroll-btn scroll-right">
                    <img src="images/arrow.png" class="arrow-icon rotate-right" alt="เลื่อนขวา">
                </button>
                <div class="scroll-container">
                    <?php foreach ($genre_media[$genre['genre_id']] as $item): ?>
                        <div class="media-card">
                            <img src="data:image/jpeg;base64,<?= base64_encode($item['media_img']); ?>" alt="<?= htmlspecialchars($item['media_title']); ?>">
                            <p class="mt-2"><?= htmlspecialchars($item['media_title']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>

<script>
document.querySelectorAll('.media-row').forEach(row => {
    const container = row.querySelector('.scroll-container');
    const btnLeft = row.querySelector('.scroll-left');
    const btnRight = row.querySelector('.scroll-right');

    function updateButtons() {
        btnLeft.style.display = container.scrollLeft > 0 ? 'block' : 'none';
        btnRight.style.display = container.scrollLeft + container.clientWidth < container.scrollWidth - 5 ? 'block' : 'none';
    }

    btnLeft.addEventListener('click', () => {
        container.scrollBy({ left: -300, behavior: 'smooth' });
    });

    btnRight.addEventListener('click', () => {
        container.scrollBy({ left: 300, behavior: 'smooth' });
    });

    container.addEventListener('scroll', updateButtons);
    window.addEventListener('load', updateButtons);
});
</script>

<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<?php require('footer.php'); ?>
</body>
</html>
