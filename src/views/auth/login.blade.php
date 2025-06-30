<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/css/auth/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>



<body>

  <div class="wrapper">
    <form action="/auth/login" method="post">
      <h1>Login</h1>

      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required />
        <i class='bx bxs-user-circle'></i>
        <p class=" input-errors"><?= $errors['username'] ?? "" ?></p>

      </div>
      <div class="input-box">
        <div class="input-wrapper" style="position: relative;">
          <input id="password" type="password" name="password" placeholder="Password" required />
          <i class="fa-solid fa-eye-slash" id="togglePassword"
            style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #fff; cursor: pointer;"></i>
        </div>
        <p><?= $errors['password'] ?? "" ?></p>
      </div>

      <div class="remember-forgot">
        <label><input type="checkbox">Rember me</label>
        <a href="/auth/forgot">Forgot password?</a>
      </div>
      <button type="submit" class="btn">Login</button>
      <div class="register-link">
        <p>Don't have account? <a href="/auth/register">Register</a></p>
      </div>
    </form>
  </div>
</body>
<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', () => {
    const isVisible = passwordInput.type === 'text';
    passwordInput.type = isVisible ? 'password' : 'text';


    togglePassword.classList.toggle('fa-eye');
    togglePassword.classList.toggle('fa-eye-slash');
  });
</script>



</html>