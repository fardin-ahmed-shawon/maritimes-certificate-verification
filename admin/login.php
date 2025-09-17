<?php
require '../dbConnection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check credentials
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php"); // redirect after login
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
    body{height:100vh;display:flex;justify-content:center;align-items:center;background:linear-gradient(135deg,#0a192f,#172a45);}
    .login-container{background:#fff;padding:40px 30px;border-radius:15px;box-shadow:0px 8px 25px rgba(0,0,0,0.3);width:100%;max-width:380px;text-align:center;}
    .login-container h2{margin-bottom:20px;font-weight:600;color:#0a192f;}
    .input-group{margin-bottom:20px;text-align:left;}
    .input-group label{display:block;font-size:14px;margin-bottom:8px;font-weight:500;color:#172a45;}
    .input-group input{width:100%;padding:12px;border:2px solid #e0e0e0;border-radius:10px;font-size:15px;outline:none;transition:all 0.3s ease;}
    .input-group input:focus{border-color:#ff6600;box-shadow:0 0 8px rgba(255,102,0,0.4);}
    .login-btn{width:100%;background:#ff6600;border:none;color:#fff;padding:14px;border-radius:10px;font-size:16px;font-weight:600;cursor:pointer;transition:0.3s ease;}
    .login-btn:hover{background:#e65c00;}
    .error{color:red;font-size:14px;margin-bottom:15px;}
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="input-group">
        <label for="username">username</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="login-btn">Sign In</button>
    </form>
  </div>
</body>
</html>