<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yuno</title>

  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: sans-serif;
      background-color: #1f1a1a;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 90vh;
    }

    header {
      position: absolute;
      top: 0;
      width: 100%;
      background-color: black;
      color: white;
      padding: 16px;
      text-align: center;
      font-size: 26px;
      font-weight: bold;
    }

    .back-button {
      position: absolute;
      top: 16px;
      left: 16px;
      background-color: transparent;
      color: white;
      border: none;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .back-button:hover {
      text-decoration: underline;
    }

    .container {
      width: 100%;
      max-width: 450px;
      padding: 30px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    input[type="text"], input[type="password"], input[type="email"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      background-color: #b4a9a9;
      color: black;
      font-size: 16px;
      border-radius: 4px;
    }

    .password-container {
      width: 100%;
      position: relative;
    }

    .password-container input {
      width: 100%;
      padding-right: 40px;
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 12px;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #333;
    }

    .signup-btn {
      background-color: #e5c342;
      color: black;
      font-weight: bold;
      border: none;
      padding: 12px;
      margin-top: 20px;
      width: 100%;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
    }

    .links {
      margin-top: 20px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      font-size: 14px;
    }

  </style>
</head>
<body>

  <!-- Header -->
  <header>Yuno</header>

  <!-- ปุ่มย้อนกลับ -->
  <button class="back-button" onclick="history.back()">
    <i class="fa-solid fa-arrow-left"></i>
  </button>

  <!-- เนื้อหาหลัก -->
  <div class="container">
    <input type="text" placeholder="อีเมลและหมายเลขโทรศัพท์">

    <!-- รหัสผ่าน -->
<div class="password-container">
    <input id="password1" type="password" placeholder="รหัสผ่าน">
    <i class="fa-solid fa-eye toggle-password" id="togglePassword1"></i>
  </div>
  
  <!-- ยืนยันรหัสผ่าน -->
  <div class="password-container">
    <input id="password2" type="password" placeholder="ยืนยันรหัสผ่าน">
    <i class="fa-solid fa-eye toggle-password" id="togglePassword2"></i>
  </div>


    <div class="links">
      <button class="signup-btn">สมัครสมาชิก</button>
    </div>
  </div>

  <!-- JavaScript -->

  <script>
    const togglePassword1 = document.getElementById("togglePassword1");
    const togglePassword2 = document.getElementById("togglePassword2");
    const passwordInput1 = document.getElementById("password1");
    const passwordInput2 = document.getElementById("password2");
  
    togglePassword1.addEventListener("click", () => {
      const type = passwordInput1.getAttribute("type") === "password" ? "text" : "password";
      passwordInput1.setAttribute("type", type);
      togglePassword1.classList.toggle("fa-eye");
      togglePassword1.classList.toggle("fa-eye-slash");
    });
  
    togglePassword2.addEventListener("click", () => {
      const type = passwordInput2.getAttribute("type") === "password" ? "text" : "password";
      passwordInput2.setAttribute("type", type);
      togglePassword2.classList.toggle("fa-eye");
      togglePassword2.classList.toggle("fa-eye-slash");
    });
  </script>
  
  
      


</body>
</html>
