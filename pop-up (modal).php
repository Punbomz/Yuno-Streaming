<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    .nav-links a {
      color: white;
      text-decoration: none;
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
      border-radius: 8px;
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

    .gallery-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 4px;
    }

    .gallery-item p {
      margin-top: 10px;
      text-align: center;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      backdrop-filter: blur(4px);
      background-color: rgba(0, 0, 0, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .modal-content {
      background-color: #1e1e1e;
      width: 50%;
      height: 100%;
      color: white;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      position: relative;
      border-radius: 10px;
    }

    .modal-content img {
      width: 100%;
      height: 50%;
      object-fit: cover;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .modal-description {
      padding: 30px;
      flex: 1;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    .modal-description h2 {
      margin-top: 0;
    }

    .modal-buttons {
      display: flex;
      gap: 20px;
      margin-top: 20px;
    }

    .modal-buttons button {
      padding: 12px 20px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      border: none;
    }

    .play-btn {
      background-color: #f1c40f;
    }

    .download-btn {
      background-color: white;
      color: black;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 25px;
      font-size: 30px;
      cursor: pointer;
    }

    /* Responsive (optional) */
    @media screen and (max-width: 768px) {
      .modal-content {
        width: 90%;
        height: 100%;
      }
    }
  </style>
</head>
<body>

  <header>
    <div style="display: flex; align-items: center;">
      <h1>Yuno</h1>
      <div class="nav-links">
        <a href="#">หน้าหลัก</a>
        <a href="#">ภาพยนตร์</a>
      </div>
    </div>
    <div class="search-bar">
      <input type="text" placeholder="ค้นหา" />
      <button>🔍</button>
    </div>
  </header>

  <div class="main">
    <div class="highlight">
      <img src="C:\รูปหนัง data\download (4).jpg" alt="When Life Gives You Tangerines" />
      <div class="highlight-text">
        <h2>When Life Gives You Tangerines</h2>
        <p>Smile even on the days when tangerines are not sweet</p>
        <button onclick="openModal()">▶</button>
        <button class="secondary">รายการของฉัน</button>
      </div>
    </div>

    <div class="gallery">
      <div class="gallery-item">
        <img src="C:\รูปหนัง data\images.jpg" alt="Spider Man" />
        <p>Spider-Man</p>
      </div>
      <div class="gallery-item">
        <img src="C:\รูปหนัง data\download (5).jpg" alt="Moving" />
        <p>Moving</p>
      </div>
      <div class="gallery-item">
        <img src="C:\รูปหนัง data\download (2).jpg" alt="Avenger" />
        <p>Avenger</p>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="movieModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <img src="C:/รูปหนัง data/download (4).jpg" alt="โปสเตอร์หนัง" />
      <div class="modal-description">
        <h2>When Life Gives You Tangerines</h2>
        <p><strong>คำอธิบาย:</strong> ภาพยนตร์เล่าเรื่องของหญิงสาวที่ค้นหาความหวัง แม้ในวันที่ส้มเปรี้ยวที่สุดของชีวิต</p>
        <p><strong>นักแสดงนำ:</strong> คิม จีวอน, อี มินโฮ, พัค โซดัม</p>
        <div class="modal-buttons">
          <button class="play-btn">▶ เล่น</button>
          <button class="download-btn">⬇ ดาวน์โหลด</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById("movieModal").style.display = "flex";
    }

    function closeModal() {
      document.getElementById("movieModal").style.display = "none";
    }

    window.onclick = function (event) {
      const modal = document.getElementById("movieModal");
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };
  </script>

</body>
</html>
