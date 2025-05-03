<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Series and Movies</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background-color: #1e1e1e;
      color: white;
    }

    .search-bar {
      display: flex;
      align-items: center;
      background-color: #111;
      padding: 10px 20px;
      gap: 10px;
    }

    .search-bar input {
      flex: 1;
      padding: 8px;
      font-size: 16px;
      border-radius: 4px;
      border: none;
    }

    .icon {
      font-size: 18px;
      color: gray;
    }

    .back-button {
      background: none;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
    }



    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    h2 {
      font-size: 24px;
      margin-bottom: 15px;
    }

    .movie-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: flex-start;
    }

    .movie {
      width: calc(25% - 20px);
      min-width: 200px;
    }

    .movie img {
      width: 100%;
      height: 130px;
      object-fit: cover;
      border-radius: 4px;
    }

    .movie-title {
      margin-top: 8px;
      font-size: 16px;
    }

    .recommended-series {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-top: 20px;
    }

    .series-info {
      max-width: 300px;
    }

    .play-button {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: white;
      color: black;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 18px;
    }

    @media (max-width: 1024px) {
      .movie {
        width: calc(33.33% - 20px);
      }
    }

    @media (max-width: 768px) {
      .movie {
        width: calc(50% - 20px);
      }

      .recommended-series {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <div class="search-bar">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<button class="back-button" onclick="history.back()">
    <i class="fa-solid fa-arrow-left"></i>
  </button>
    <input type="text" placeholder="Search movies or series">
    <span class="icon">🔍</span>
  </div>

  <div class="container">
    <h2>Movies</h2>
    <div class="movie-list">
      <div class="movie">
        <img src="C:\รูปหนัง data\download.jpg" alt="The Marvels">
        <div class="movie-title">The Marvels</div>
      </div>
      <div class="movie">
        <img src="C:\รูปหนัง data\maxresdefault.jpg" alt="A Minecraft Movie">
        <div class="movie-title">A Minecraft Movie</div>
      </div>
      <div class="movie">
        <img src="C:\รูปหนัง data\download (2).jpg" alt="Avengers: Doomsday">
        <div class="movie-title">Avengers: Doomsday</div>
      </div>
      <div class="movie">
        <img src="C:\รูปหนัง data\download (3).jpg" alt="Inception">
        <div class="movie-title">Inception</div>
      </div>
      <div class="movie">
        <img src="C:\รูปหนัง data\images.jpg" alt="Spider-Man: No Way Home">
        <div class="movie-title">Spider-Man: No Way Home</div>
      </div>
      <div class="movie">
        <img src="C:\รูปหนัง data\download (1).jpg" alt="Interstellar">
        <div class="movie-title">Interstellar</div>
      </div>
    </div>

    <h2>Recommended Series</h2>
    <div class="recommended-series">
      <img src="C:\รูปหนัง data\download (4).jpg" alt="When Life Gives You Tangerines" width="200" style="border-radius: 4px;">
      <div class="series-info">
        <strong>When Life Gives You Tangerines</strong><br>
        Smile even on the days when tangerines are not sweet
      </div>
      <div class="play-button">▶</div>
    </div>
    <div class="recommended-series">
        <img src="C:\รูปหนัง data\download (5).jpg" alt="When Life Gives You Tangerines" width="200" style="border-radius: 4px;">
        <div class="series-info">
          <strong>Moving</strong><br>
          Kim Bong Seok, Jang Hui Su, and Lee Gang Hun, seemingly typical high school students, bear extraordinary inherited powers. 
        </div>
        <div class="play-button">▶</div>
  </div>
</body>
</html>
