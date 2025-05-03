<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Package</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background-color: #221d1d;
      color: white;
    }

    .header {
      background-color: black;
      color: white;
      padding: 20px;
      position: relative;
      text-align: center;
    }

    .back-arrow {
      font-size: 30px;
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .title {
      font-size: 32px;
      font-weight: 500;
    }

    .container {
      padding: 20px;
      padding-top: 40px;
    }

    .section {
      background-color: #d9d9d9;
      color: black;
      margin-bottom: 25px;
      padding: 15px; /* ลด padding เพื่อให้กล่องเล็กลง */
      font-size: 18px; /* ขนาดตัวอักษรเล็กลง */
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 10px;
      width: 80%;
      margin-left: auto;
      margin-right: auto;
      min-height: 30px; /* ขนาดกล่องเล็กมาก */
    }

    /* กล่องที่มีความสูงสั้นกว่า */
    .section-narrow {
      width: 80%;
      min-height: 30px; /* ปรับให้เล็กลงมาก */
    }

    /* กล่องรายละเอียด Package ของฉันจะมีความสูงที่มากกว่า */
    .section-main {
      width: 80%;
      min-height: 50px; /* เพิ่มความสูงให้มากกว่ากล่องอื่น ๆ */
    }

    .section.disabled {
      color: #888;
    }

    .premium-badge {
      background-color: #d1b741;
      padding: 5px 10px; /* ลดขนาด padding ของ badge */
      border-radius: 5px;
      font-weight: bold;
      white-space: nowrap;
    }

    .arrow {
      font-size: 18px; /* ขนาดลูกศรเล็กลง */
    }
  </style>
</head>
<body>

  <div class="header">
    <div class="back-arrow">&#8592;</div>
    <div class="title">Package</div>
  </div>

  <div class="container">
    <div class="section section-main">
      <span>รายละเอียด Package ของฉัน</span>
      <div class="premium-badge">Premium</div>
    </div>

    <div class="section section-narrow">
      <span>จัดการอุปกรณ์และการเข้าถึง</span>
      <span class="arrow">&#62;</span>
    </div>

    <div class="section section-narrow disabled">
      <span>การชำระเงิน</span>
    </div>

    <div class="section section-narrow">
      <span>เลือกวิธีชำระเงิน</span>
      <span class="arrow">&#62;</span>
    </div>

    <div class="section section-narrow">
      <span>ประวัติการชำระเงิน</span>
      <span class="arrow">&#62;</span>
    </div>
  </div>

</body>
</html>
