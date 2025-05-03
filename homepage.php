<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yuno</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background-color: #2c2b2b;
      color: white;
    }

    header {
      background-color: black;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
    }

    header h1 {
      margin: 0;
    }

    .nav-links {
      margin-left: 20px;
      display: flex;
      gap: 20px;
    }

    .search-bar {
      display: flex;
      align-items: center;
    }

    .search-bar input {
      padding: 5px;
      font-size: 16px;
    }

    .search-bar button {
      padding: 5px;
      background: yellow;
      border: none;
      cursor: pointer;
    }

    .main {
      max-width: 1200px;
      margin: auto;
      padding: 20px;
    }

    .highlight {
      display: flex;
      gap: 20px;
      margin-bottom: 40px;
    }

    .highlight img {
      width: 400px;
    }

    .highlight-text {
      max-width: 600px;
    }

    .highlight-text h2 {
      margin-top: 0;
    }

    .highlight-text button {
      margin-right: 10px;
      padding: 10px 20px;
      background: yellow;
      border: none;
      font-weight: bold;
      cursor: pointer;
    }

    .highlight-text .secondary {
      background: white;
      color: black;
    }

    .gallery {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 30px;
    }

    .gallery-item {
      width: 30%;
    }

    .gallery-item img  {
        width: 110%;
        height: 200px;
        object-fit: cover;
        border-radius: 4px;
    }

    .gallery-item p {
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>

  <header>
    <div style="display: flex; align-items: center;">
      <h1>Yuno</h1>
      <div class="nav-links">
        <a href="#" style="color: white;">หน้าหลัก</a>
        <a href="#" style="color: white;">ภาพยนตร์</a>
      </div>
    </div>
    <div class="search-bar">
      <input type="text" placeholder="ค้นหา">
      <button>🔍</button>
    </div>
  </header>

  <div class="main">
    <div class="highlight">
      <img src="C:\รูปหนัง data\download (4).jpg" alt="When Life Gives You Tangerines">
      <div class="highlight-text">
        <h2>When Life Gives You Tangerines</h2>
        <p>Smile even on the days when tangerines are not sweet</p>
        <button>▶</button>
        <button class="secondary">รายการของฉัน</button>
      </div>
    </div>

    <div class="gallery">
      <div class="gallery-item">
        <img src="C:\รูปหนัง data\images.jpg"alt="Spider Man">
        <p>Spider-Man</p>
      </div>
      <div class="gallery-item">
        <img src="C:\รูปหนัง data\download (5).jpg" alt="Moving">
        <p>Moving</p>
      </div>
      <div class="gallery-item">
        <img src="C:\รูปหนัง data\download (2).jpg" alt="Avenger">
        <p>Avenger</p>
      </div>
    </div>
  </div>

</body>
</html>
