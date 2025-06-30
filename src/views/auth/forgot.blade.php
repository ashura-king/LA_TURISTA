<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="/css/auth/forgot.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="wrapper">
    <form action="/auth/forgot" method="post">
      <h1>Forgot Password</h1>
      <p>Enter your email address to reset your password.</p>

      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
        <i class='bx bxs-envelope'></i>
        <p><?= $errors['username'] ?? "" ?></p>
      </div>
      <div class="input-box">
        <input type="password" name="newpass" placeholder="New Password" required>
        <i class='bx bxs-envelope'></i>
      </div>

      <button type="submit" class="btn">Reset Password</button>
    </form>
  </div>
</body>

</html>