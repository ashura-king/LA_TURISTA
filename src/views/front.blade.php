<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Front</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="css/front.css">
  <style>
  .Section_top {
    width: 100%;
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transition: background-image 1s ease-in-out;
  }
  </style>
</head>

<body>
  <?php include('loader.blade.php'); ?>
  <div class="Section_top">
    <div class="content">
      <h1>La <span>turista</span></h1>
      <form action="/auth/login">
        <button type="submit" class="btn">Welcome</button>
      </form>

    </div>
  </div>

  <script>
  const images = [
    "/assets/cagsawa.jpg",
    "/assets/mayinsky.jpg",
    "/assets/sulong.jpg",
    "/assets/wild.jpg",
    "/assets/pina.jpg",
    "/assets/corangon.jpg"
  ];

  let index = 0;
  const sectionTop = document.querySelector(".Section_top");

  function changeBackground() {
    sectionTop.style.backgroundImage = `url('${images[index]}')`;
    index = (index + 1) % images.length;
  }

  // Initial background set and interval
  changeBackground();
  setInterval(changeBackground, 3000);
  </script>
</body>

</html>