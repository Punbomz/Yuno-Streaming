<!-- admin_index.php -->
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Manage Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #111;
      color: white;
    }

    .sidebar {
      width: 150px;
      height: 100vh;
      background-color: #000;
      padding: 20px;
      float: left;
    }

    .sidebar h2 {
      margin-top: 0;
      color: white;
    }

    .sidebar a {
      display: block;
      margin: 15px 0;
      color: white;
      text-decoration: none;
    }

    .sidebar a.active {
      color: yellow;
      font-weight: bold;
    }

    .main {
      margin-left: 150px;
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      color: black;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    .btn-add {
      background-color: yellow;
      border: none;
      padding: 8px 15px;
      font-weight: bold;
      margin-bottom: 10px;
      float: right;
      cursor: pointer;
    }

    .icon {
      cursor: pointer;
    }

    .logout {
      position: absolute;
      bottom: 10px;
      left: 20px;
    }

    .logout a {
      color: red;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Yuno</h2>
    <a href="#">แดชบอร์ด</a>
    <a href="#">มีเดีย</a>
    <a href="#">แพ็คเกจ</a>
    <a href="#" class="active">ผู้ใช้</a>
    <div class="logout"><a href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i> Admin</a></div>
  </div>

  <div class="main">
    <button class="btn-add">+ เพิ่ม Admin</button>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>ชื่อ Admin</th>
          <th>Email</th>
          <th>สิทธิ์การเข้าถึง</th>
          <th>แก้ไข</th>
          <th>ลบ</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>สุดหล่อภาคคอม</td>
          <td><u>peter@gmail.com</u></td>
          <td>ทั้งหมด</td>
          <td><i class="fa-solid fa-pencil icon" style="color: orange;"></i></td>
          <td><i class="fa-solid fa-trash-can icon" style="color: gray;"></i></td>
        </tr>
        <tr>
          <td>2</td>
          <td>น้องเหนียวที่ไก่ๆ</td>
          <td><u>kaineo@gmail.com</u></td>
          <td>ดูแล Users</td>
          <td><i class="fa-solid fa-pencil icon" style="color: orange;"></i></td>
          <td><i class="fa-solid fa-trash-can icon" style="color: gray;"></i></td>
        </tr>
        <!-- สามารถเพิ่มแถวอื่นๆ ได้ -->
        <tr><td>3</td><td>...</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>4</td><td>...</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>5</td><td>...</td><td></td><td></td><td></td><td></td></tr>
      </tbody>
    </table>
  </div>

</body>
</html>
