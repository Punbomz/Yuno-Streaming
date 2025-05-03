<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #1d1919;
      color: white;
    }

    .header {
      background-color: black;
      padding: 15px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* ปรับขนาดลูกศรให้ใหญ่ขึ้น */
    .back-arrow {
      font-size: 36px;  /* เพิ่มขนาดลูกศร */
      position: absolute;
      left: 20px;
      cursor: pointer;
      color: white;
    }

    .header h1 {
      font-size: 28px;
      margin: 0;
    }

    .container {
      display: flex;
      padding: 40px;
      gap: 40px;
      min-height: 80vh;
    }

    .left {
      flex: 1;
      text-align: center;
    }

    .left img {
      width: 200px;
      height: auto;
      border-radius: 8px;
    }

    .left p {
      margin: 10px 0;
    }

    .right {
      flex: 2;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .form-section {
      display: flex;
      flex-direction: column;
      gap: 32px;
    }

    /* ปรับขนาดกล่องข้อความให้ใหญ่ขึ้น */
    .input-box {
      background-color: #d9d9d9;
      border: none;
      padding: 18px;  /* เพิ่มความสูงให้กล่องข้อความ */
      font-size: 18px;  /* เพิ่มขนาดฟอนต์ */
      width: 100%;
      box-sizing: border-box;
      border-radius: 5px;
    }

    /* ปรับให้ช่อง Package มีลูกศร */
    .input-box.package {
      background-color: #d9d9d9;
      border: none;
      padding: 18px;
      font-size: 18px;
      width: 100%;
      box-sizing: border-box;
      border-radius: 5px;
      position: relative;
    }

    .input-box.package::after {
      content: '▼';
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 24px;  /* ปรับขนาดลูกศรในช่อง Package */
      color: #333;
    }

    .buttons {
      display: flex;
      gap: 80px;
      margin-top: 40px;
    }

    .btn-cancel {
      padding: 10px 30px;
      font-size: 16px;
      background-color: #d9d9d9;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-save {
      padding: 10px 30px;
      font-size: 16px;
      background-color: #f1cc53;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      color: black;
    }
  </style>
</head>
<body>

  <div class="header">
    <div class="back-arrow">&#8592;</div>
    <h1>Edit Profile</h1>
  </div>

  <div class="container">
    <div class="left">
      <!-- เพิ่มรูปภาพสัตว์ (น้องหมา) -->
      <img src="https://place.dog/200/250" alt="Profile Photo">
      <p>บอมบ์ลูกน้องพี่วี</p>
      <p>Start Date : 9 April 2025</p>
      <p>End Date : 32 May 2099</p>
    </div>

    <div class="right">
      <div class="form-section">
        <input type="email" class="input-box" placeholder="Email">
        <input type="password" class="input-box" placeholder="Password">
        <input type="text" class="input-box" placeholder="Mobile Number">
        <!-- ช่องแพ็คเกจที่มีลูกศร -->
        <input type="text" class="input-box package" placeholder="Package" readonly>
      </div>

      <div class="buttons">
        <button class="btn-cancel">Cancel</button>
        <button class="btn-save">Save</button>
      </div>
    </div>
  </div>

</body>
</html>
