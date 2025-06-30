<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spot</title>
  <link rel="stylesheet" href="css/spot.css">
  <link rel="stylesheet" href="css/profile.css">
  <script src="js/profile.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>



</head>
<?php include('loader.blade.php'); ?>
<!-- Display messages if they exist -->
<?php if (isset($message) && !empty($message)): ?>
  <div class="message <?php echo $messageType; ?>">
    <?php echo $message; ?>
  </div>
<?php endif; ?>

<section class="hero">
  <nav>
    <div class="nav__logo">
      <img src="/assets/la-turista.png" alt="La Turista Logo">
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

        <?php include 'components/logout.blade.php'; ?>


      </div>
    </div>
    <!-- Edit Profile Modal -->

    <div id="editProfileModal" class="modal">
      <!-- Modal Content / Form -->
      <form action="" id="edit-form" class="modal-content">
        <div class="edit-form-top">
          <button type="button" id="exit" aria-label="Close" class="close">
            <i class="fa-solid fa-circle-xmark custom-size"></i>
          </button>
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
              <input type="email" id="email" name="email" class="input-style"
                value="<?= htmlspecialchars($email ?? "") ?>" required>
            </div>

            <div class="form-actions">
              <button type="submit" class="popup-update">Update</button>
              <button type="submit" id="delete" class="popup-delete">Delete</button>
            </div>
          </form>
        </div>


  </nav>

  <div class="hero-overlay">
    <h1>Staycation</h1>
  </div>
</section>

<h2>Best Spot in Albay You Need to Know</h2>

<!-- Gallery items (same as before) -->
<div class="gallery">
  <div class="gallery-item">
    <img src="/assets/corangon.jpg" alt="Corangon Schoal"
      onclick="openModal('/assets/corangon.jpg', 'Corangon Island The egg yolk Island', 'A stunning beach with crystal clear water face in mayon.', 'Tiwi Albay', 'January-April', 'Swimming, Sunset Viewing', '/assets/corangon.png')">
    <p class="image-title">Corangon Schoal</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/pina.jpg" alt="Pinamuntugan Beach"
      onclick="openModal('/assets/pina.jpg', 'Pinamuntugan', 'A stunning beach with crystal clear water.', 'Bacacay,Albay', 'May-June', ' Swimming, Camping, Sunset view', '/assets/pinamap.png')">
    <p class="image-title">Pinamuntugan Beach</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/sky.jpg" alt="Mayon Skyline"
      onclick="openModal('/assets/sky.jpg', 'Mayon Skyline', 'A breathtaking mountain landscape', 'Tabaco Albay', 'March - May', 'Nightlife, Hiking, Photography', '/assets/mayon-map.png')">
    <p class="image-title">Mayon Skyline</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/cagsawa.jpg" alt="Cagsawa Ruins"
      onclick="openModal('/assets/cagsawa.jpg', 'Cagsawa ruins', 'Echoes of the past, framed by the perfect cone of the present.', 'Barangay Busay, Cagsawa,', 'March - May', 'Picnic, Photography', '/assets/cagsawamap.png')">
    <p class="image-title">Cagsawa Ruins</p>
  </div>
  <!-- Second Row-->
  <div class="gallery-item">
    <img src="/assets/lignon.jpg" alt="Lingon Hills"
      onclick="openModal('/assets/lignon.jpg', 'Lingon Hills', ' prehistoric cinder cone near the foot of Mayon,', 'Tabaco Albay', 'March - May', 'Nightlife, Hiking, Photography', '/assets/lignonhill.png')">
    <p class="image-title">Lingon Hills</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/Quintan.jpg" alt="Quintan Hills"
      onclick="openModal('/assets/Quintan.jpg', 'Quintan Hills', 'A breathtaking mountain landscape', 'Tinago ,Camalig Albay', 'March - May', 'Nightlife, Hiking, Photography', '/assets/Quintanhill.png')">
    <p class="image-title">Quintan Hills</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/wild.jpg" alt="Albay Park and Wildlife"
      onclick="openModal('/assets/wild.jpg', 'Albay Park and Wildlife', ' A vibrant sanctuary offering nature trails, exotic wildlife, and the stunning beauty.', 'Daraga-Legazpi Diversion', 'Febuary, March-June', ' picnicking, biking, boat rides, and exploring other nature and wildlife ', '/assets/wildlife.png')">
    <p class="image-title">Albay Park and Wildlife</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/sulong.jpg" alt="Sulong Eco Park"
      onclick="openModal('/assets/sulong.jpg', 'Sulong Eco Park', ' A picturesque eco-tourism destination that highlights the natural beauty and biodiversity of the Bicol Region.', 'Camalig,Albay', 'November-May', 'trekking, spelunking, and enjoying views of Mayon Volcano and the Quitinday Green Hills', '/assets/sulongeco.png')">
    <p class="image-title">Sulong Eco Park</p>
  </div>
  <!--Third Row-->
  <div class="gallery-item">
    <img src="/assets/verafalls.jpg" alt="Vera Falls"
      onclick="openModal('/assets/verafalls.jpg', 'Vera Falls', 'A paradise of forest and clear cascading water.', 'Malinao, Albay', 'March-May', 'Swimming,Photography,trekking', '/assets/veramap.png')">
    <p class="image-title">Vera Falls</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/Quitinday.jpg" alt="Quitinday Hills"
      onclick="openModal('/assets/Quitinday.jpg', 'Quitinday Hills', 'A hidden chocolate hills in albay.', 'Camalig Albay', 'December-Febuary', 'Photography,Hiking,Picnic', '/assets/Quitindaymap.png')">
    <p class="image-title">Quitinday Hills</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/Cagraray.jpg" alt="Cagraray Eco Energy Park"
      onclick="openModal('/assets/Cagraray.jpg', 'Cagraray Eco Energy Park', ' A dazzling  place with an overview of the beach and neighboring islands.', 'Cagraray Bacacay, Albay', 'May-June', 'trekking,Zipline,Swimming', '/assets/cagraray.png')">
    <p class="image-title">Cagraray Eco Energy Park</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/jovellar.jpg" alt="Jovellar Underground River"
      onclick="openModal('/assets/jovellar.jpg', 'Jovellar Underground River', 'A cave with a freely flowing water into a gorge and a cliff jumping spot.', 'Jovellar, Albay', 'March-June', 'Raft ride,Swimming,Waterfall climbing,Photography', '/assets/jovellarmap.png')">
    <p class="image-title">Jovellar Underground River</p>
  </div>

  <div class="gallery-item">
    <img src="/assets/4.jpg" alt="Pinamuntugan Beach"
      onclick="openModal('/assets/4.jpg', 'The Farmplate', 'A fresh and relaxing spot for people in town', 'Bacacay,Albay', 'May-June', ' Swimming, Camping, Sunset view', '/assets/pinamap.png')">
    <p class="image-title">The Farmplate</p>
  </div>
  <div class="gallery-item">
    <img src="/assets/3.jpg" alt="Pinamuntugan Beach"
      onclick="openModal('/assets/3.jpg', 'Daraga Church', 'A fresh and relaxing spot for people in town', 'Bacacay,Albay', 'May-June', ' Swimming, Camping, Sunset view', '/assets/pinamap.png')">
    <p class="image-title">Daraga Church</p>
  </div>
  <div class="gallery-item">
    <img src="/assets/2.jpg" alt="Pinamuntugan Beach"
      onclick="openModal('/assets/2.jpg', 'Jovellar Cave', 'A fresh and relaxing spot for people in town', 'Bacacay,Albay', 'May-June', ' Swimming, Camping, Sunset view', '/assets/pinamap.png')">
    <p class="image-title">Hoyop-hoyopan Cave</p>
  </div>
  <div class="gallery-item">
    <img src="/assets/Photo.jpg" alt="Pinamuntugan Beach"
      onclick="openModal('/assets/Photo.jpg', 'Sumlang Lake', 'A fresh and relaxing spot for people in town', 'Bacacay,Albay', 'May-June', ' Swimming, Camping, Sunset view', '/assets/pinamap.png')">
    <p class="image-title">Sumlang Lake</p>
  </div>
</div>

<!-- Modal -->
<div class="modal" id="imageModal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <img id="modalImg" src="" alt="">
    <h2 id="modalTitle"></h2>
    <p id="modalDescription"></p>
    <p><strong>Best Time to Visit:</strong> <span id="modalBestTime"></span></p>
    <p><strong>Activities:</strong> <span id="modalActivities"></span></p>
    <p><strong>Location:</strong> <span id="modalLocation"></span></p>
    <img id="modalMap" class="map" src="" alt="Location Map">

    <!-- Rating system with comment inside modal -->
    <div class="star-rating-container">
      <h3>Rate this destination</h3>
      <!-- Stars -->
      <div class="stars-container">
        <div class="star" data-value="1">★</div>
        <div class="star" data-value="2">★</div>
        <div class="star" data-value="3">★</div>
        <div class="star" data-value="4">★</div>
        <div class="star" data-value="5">★</div>
      </div>

      <!-- Rating feedback text -->
      <div id="starRatingText">Not rated yet</div>

      <!-- Comment field -->
      <textarea id="ratingComment" class="comment-box" placeholder="Share your experience"></textarea>


      <!-- Form for submission -->
      <form id="ratingForm" method="POST" action="/rate/ratings">
        <input type="hidden" id="name" name="name" value="">
        <input type="hidden" id="ratingValue" name="rating" value="0">
        <input type="hidden" id="ratingMessage" name="message" value="">
        <button type="submit" id="submitRatingBtn" style="display: none;">Submit Rating</button>
      </form>
    </div>
  </div>
</div>


<script src="js/spot.js"></script>
</body>

</html>