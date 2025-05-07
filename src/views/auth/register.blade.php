<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link rel="stylesheet" href="/css/auth/register.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="wrapper">
    <form action="/auth/register" method="POST">
      <h1>Register</h1>

      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
        <i class='bx bxs-envelope'></i>
        <p><?= $errors['email'] ?? "" ?></p>
      </div>

      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
        <i class='bx bxs-user-circle'></i>
      </div>

      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class="fa-solid fa-eye-slash" id="togglePassword"
          style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #fff; cursor: pointer;"></i>
      </div>
      <p><?= $errors['password'] ?? "" ?></p>

      <div class="input-box">
        <input type="password" name="confirm" placeholder="Confirm Password" required>
        <i class="fa-solid fa-eye-slash" id="togglePassword"
          style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #fff; cursor: pointer;"></i>
      </div>
      <p><?= $errors['confirm'] ?? "" ?></p>

      <button type="submit" class="btn">Register</button>

      <div class="register-link">
        <p>Already have an account? <a href="/auth/login">Login</a></p>
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