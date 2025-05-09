<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/profile.css">
  <title>Home
  </title>
</head>

<body>

  <?php if (isset($message) && !empty($message)): ?>
    <div class="message <?php echo $messageType; ?>">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>
  <nav>
    <div class="container">
      <div class="nav__logo">
        <a href="/webfront">
          <img src="/assets/la-turista.png" alt="La Turista Logo">
        </a>
      </div>

      <div class="nav__right">
        <ul class="nav__links">
          <li><a href="/webfront">Home</a></li>
          <li><a href="/spot">Spots</a></li>
          <li><a href="/place">Rest place</a></li>
        </ul>
        <img src="/assets/user.png" class="user-pic" onclick="toggleMenu()">
      </div>
    </div>
    <div class="sub-menu-wrap" id="subMenu">
      <div class="sub-menu">
        <div class="user-info">
          <img src="assets/user.png">
          <h3><?= $user->username ?? "User Profile" ?></h3>
        </div>
        <hr>
        <a href="#" class="sub-menu-link" id="editProfileBtn">
          <img src="assets/profile.png">
          <p>Edit Profile</p>
          <span>></span>
        </a>
        <a href="#" class="sub-menu-link">
          <img src="assets/setting.png">
          <p>Setting & Privacy</p>
          <span>></span>
        </a>
        <a href="#" class="sub-menu-link">
          <img src="assets/help.png">
          <p>Help & support</p>
          <span>></span>
        </a>

        <?php include 'components/logout.blade.php' ?>

      </div>
    </div>
    <div id="editProfilePopup" class="popup-dialog">
      <!-- Popup Content / Form -->
      <form action="" id="edit-form" class="popup-dialog-content">
        <div class="edit-form-top">
          <button type="button" id="exit" aria-label="Close" class="popup-close">
            <i class="fa-solid fa-circle-xmark custom-size"></i>
          </button>
        </div>

        <div class="edit-form-header">
          <img src="assets/profile.png" class="user-pic" alt="Profile Picture">
          <h3 class="form-title"><?= $user->username ?? "User Profile" ?></h3>
        </div>

        <div class="form-group">
          <label for="username" class="input-text">Username</label>
          <input type="text" id="username" name="username" class="input-style"
            value="<?= htmlspecialchars($username ?? "") ?>" required>
        </div>

        <div class="form-group">
          <label for="email" class="input-text">Email</label>
          <input type="email" id="email" name="email" class="input-style" value="<?= htmlspecialchars($email ?? "") ?>"
            required>
        </div>

        <div class="form-actions">
          <button type="submit" class="popup-update">Update</button>
          <button type="submit" id="delete" class="popup-delete">Delete</button>
        </div>
      </form>
    </div>
  </nav>


  <header>
    <div class="section__container">
      <div class="header__content">
        <h1>Albay</h1>
        <p>
          Nestled in the embrace of nature’s grandeur,
          this captivating tourist spot invites every traveler to immerse in its vibrant beauty,
          where every moment feels like a masterpiece painted by the earth itself
        </p>

        <button onclick="scrollToSection()">Read more</button>


      </div>
    </div>
  </header>

  <section id="journey-section" class="journey__container">
    <div class="section__container">
      <h2 class="section__title">Start Your Journey</h2>
      <p class="section__subtitle">The most visited place in Albay</p>
      <div class="journey__grid">
        <div class="country__card">
          <img src="/assets/cagsawa.jpg" alt="country" />
          <div class="country__name">
            <i class="ri-map-pin-range-fill"></i>
            <span>Cagsawa Ruins</span>
          </div>
        </div>
        <div class="country__card">
          <img src="/assets/mayinsky.jpg" alt="country" />
          <div class="country__name">
            <i class="ri-map-pin-range-fill"></i>
            <span>Mayon Skyline</span>
          </div>
        </div>
        <div class="country__card">
          <img src="/assets/pina.jpg" alt="country" />
          <div class="country__name">
            <i class="ri-map-pin-range-fill"></i>
            <span>Pinamuntugan Beach</span>
          </div>
        </div>
        <div class="country__card">
          <img src="/assets/corangon.jpg" alt="country" />
          <div class="country__name">
            <i class="ri-map-pin-range-fill"></i>
            <span>Corangon Shoal</span>
          </div>
        </div>
        <div class="country__card">
          <img src="/assets/lignon.jpg" alt="country" />
          <div class="country__name">
            <i class="ri-map-pin-range-fill"></i>
            <span>Ligñon Hills</span>
          </div>
        </div>
        <div class="country__card">
          <img src="/assets/wild.jpg" alt="country" />
          <div class="country__name">
            <i class="ri-map-pin-range-fill"></i>
            <span>Albay Park & Wild life</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="banner__container">
    <div class="section__container">
      <div class="banner__content">
        <h2>Welcome to Albay</h2>
        <p>
          Albay is renowned for its iconic Mayon Volcano, offering scenic views and thrilling adventures.
          Tourists can also explore the historic Cagsawa Ruins, relax at the luxurious Misibis Bay,
          and indulge in spicy Bicolano dishes like Bicol Express. It’s a blend of nature,
          culture, and culinary delights!
        </p>

      </div>
    </div>
  </section>

  <section class="display__container">
    <div class="section__container">
      <h2 class="section__title">Why Choose Albay</h2>
      <p class="section__subtitle">
        The gladdest moment in life is embarking on a journey to Albay’s unknown treasures.
      </p>
      <div class="display__grid">
        <div class="display__card grid-1">
          <img src="/assets/beach.jpg" alt="grid" />
        </div>
        <div class="display__card">
          <i class="ri-earth-fill"></i>
          <h4>Passionate Travel</h4>
          <p>Ignite your spirit of adventure and embark on a journey to uncover breathtaking new horizons.</p>
        </div>
        <div class="display__card">
          <img src="/assets/beach4.jpg" alt="grid" />
        </div>
        <div class="display__card">
          <img src="/assets/beach3.jpg" alt="grid" />
        </div>
        <div class="display__card">
          <i class="ri-map-2-line"></i>
          <h4>Beautiful Places</h4>
          <p>Uncover the most breathtakingly beautiful places in bicol</p>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="section__container">
      <h4>La turista</h4>
      <div class="social__icons">
        <span><i class="ri-facebook-fill"></i></span>
        <span><i class="ri-twitter-fill"></i></span>
        <span><i class="ri-instagram-line"></i></span>
        <span><i class="ri-linkedin-fill"></i></span>
      </div>
      <p>
        "Discover, Experience, and Cherish the Wonders of Bicol – Your Journey Starts with La Turista."
      </p>
    </div>
  </footer>
</body>
<script src="js/webfront.js"></script>
<script src="js/profile.js"></script>


</html>