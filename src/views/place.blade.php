<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Best Rest Places</title>

  <link rel="stylesheet" href="css/rest.css">
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>

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
  <div class="search-container">
    <i class='bx bx-search search-icon'></i>
    <input type="text" id="searchInput" placeholder="Search rest places..." onkeyup="filterCards()">
  </div>
  <p id="noResultsMessage" style="display: none; text-align: center; margin-top: 20px;">No results found.</p>



  <div class="container">
    <!-- Cards with local images -->
    <div class="card" onclick="openModal(
      'Marison Hotel', 
      'Location: Imelda Roces Ave, Legazpi City, Albay', 
      'Experience the finest in hospitality at The Marison Hotel, recognized as the best luxury hotel in Legazpi City, Albay offering unparalleled comfort and world-class service.', 
      5, 
      ['/assets/marison1.jpg', '/assets/marison2.jpg', '/asstes/marison4.jpg','/assests/marison3.jpg'], 
     [
     'Special Offer: 10% off for a 3-night stay!',
     'Unparalleled comfort and world-class service.',
     
     'Book online and get up to 30% discount via Traveloka.',
     'Experience the finest in hospitality at The Marison Hotel.',
    'Recognized as the best luxury hotel in Legazpi City, Albay.',
     ]
      
    )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/marison1.jpg" class="slide-img" />
        <img src="/assets/marison2.jpg" class="slide-img" />
        <img src="/assets/marison3.jpg" class="slide-img" />
        <img src="/assets/marison4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Marison Hotel</div>
        <div class="location">Corner Imelda Roces Ave, Legazpi City, Albay</div>
      </div>
      <div class="desc">Experience the finest in hospitality at The Marison Hotel, recognized as the best luxury hotel
        in Legazpi City, Albay offering unparalleled comfort and world....</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bxs-star'></i>
        <p>(5.0)</p>
      </div>
    </div>


    <div class="card" onclick="openModal('The Oriental', 'Location: Niño Village, City, Albay, Legazpi Blvd, Legazpi City, 4500 Albay', 'A Filipino-centric hotel chain focusing on its unique heritage and hospitality..', 4,  ['/assets/Oriental1.jpg', '/assets/oriental2.jpg', '/assets/oriental3.jpg'], 
    ['Free Breakfast for 2 with a 2-night stay',
     'Early Check-in or Late Checkout for guests staying 3+ nights',
    '10% Discount for bookings made 1 month in advance',
    'Complimentary Welcome Drink upon arrival',
    'Free Shuttle Service to nearby tourist spots for guests staying 4+ nights',
   'Family Package Deal: Kids under 12 stay free with parents' 
  ]
   )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/Oriental1.jpg" class="slide-img" />
        <img src="/assets/oriental2.jpg" class="slide-img" />
        <img src="/assets/oriental3.jpg" class="slide-img" />
        <img src="/assets/oriental4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">The Oriental</div>
        <div class="location">Sto. Niño Village, City, Albay, Legazpi Blvd, Legazpi City, 4500 Albay</div>
      </div>
      <div class="desc">A Filipino-centric hotel chain focusing on its unique heritage and hospitality.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bx-star'></i>
        <p>(4.0)</p>
      </div>
    </div>

    <div class="card"
      onclick="openModal('Casa Basilica', 'Location: Diversion Rd, Guinobatan, 4503 Albay', 'Exclusive retreat nestled in the breathtaking landscapes in the heart of Guinobatan, Albay. Experience the lavish accommodations, lush surroundings, exquisite culinary delights and offers unforgettable escape for discerning travelers.', 4.2,  ['/assets/Casa1.jpg', '/assets/Casa2.jpg', '/assets/Casa3.jpg'],  'Exclusive: 15% off for early bird bookings.')">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/Casa1.jpg" class="slide-img" />
        <img src="/assets/Casa2.jpg" class="slide-img" />
        <img src="/assets/Casa3.jpg" class="slide-img" />
        <img src="/assets/Casa4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Casa Basilica</div>
        <div class="location">Diversion Rd, Guinobatan, 4503 Albay</div>
      </div>
      <div class="desc">Exclusive retreat nestled in the breathtaking landscapes in the heart of Guinobatan, Albay.
        Experience the lavish accommodations, lush...</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bxs-star-half'></i>
        <p>(4.2)</p>
      </div>
    </div>
    <div class="card" onclick="openModal('Casa Bicolandia Suites', 'Location: 880, Daraga, 4501 Albay', 'Casa Bicolandia Suites is located at the heart of Daraga, Albay where beautiful landmarks and popular tourist spots await you.', 4.1,  ['/assets/bicolandia2.jpg', '/assets/bicolandia1.jpg', '/assets/bicolandia3.jpg'],  [
      'Exclusive Deal: Get 15% off for bookings made at least 30 days in advance.',
      'Limited-Time Promo: Offer discounts for early bookings during peak seasons.',
       'Loyalty Rewards: Combine with a VIP membership—returning customers get extra perks'


    ])">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/bicolandia2.jpg" class="slide-img" />
        <img src="/assets/bicolandia1.jpg" class="slide-img" />
        <img src="/assets/bicolandia3.jpg" class="slide-img" />
        <img src="/assets/bicolandia4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Casa Bicolandia Suites</div>
        <div class="location">malvar st., Daraga, Albay</div>
      </div>
      <div class="desc">Casa Bicolandia Suites is located at the heart of Daraga, Albay where beautiful landmark....
      </div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bxs-star-half'></i>
        <p>(4.5)</p>
      </div>
    </div>
    <div class="card" onclick="openModal('InnBox', 'Location: Purok 3, Maroroy, Daraga,Albay, Daraga','Bicol’s premiere upcycled container van motel.Overnight & short stays available.', 3.9,  ['/assets/innbox1.jpg', '/assets/innbox2.jpg', '/assets/innbox3.jpg'],  
    [
    'Weekend Getaway Special: Stay Friday to Sunday and get 20% off your total bill.',
    'Stay More, Save More: Book for 5+ nights and enjoy a free extra night.',
 'Business Package: Includes complimentary airport transfer and workspace access for professionals.',
  'Adventure Bundle: Get discounted tickets for local tours when booking 3+ nights.',
 'Group Discount: 10% off for bookings of 4+ rooms—perfect for family reunions or work trips.'



    ])">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/innbox1.jpg" class="slide-img" />
        <img src="/assets/innbox2.jpg" class="slide-img" />
        <img src="/assets/innbox3.jpg" class="slide-img" />
        <img src="/assets/innbox4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">InnBox</div>
        <div class="location">Purok 3, Maroroy, Daraga,Albay, Daraga</div>
      </div>
      <div class="desc">Bicol’s premiere upcycled container van motel.Overnight & short stays available.</div>
      <div class="stars">
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star-half'></i>
        <i class='bx bx-star'></i>
        <p>(3.9)</p>
      </div>

    </div>
    <div class="card" onclick="openModal('Hotel Areca', 'Location: Rizal Avenue, Legazpi, Philippines','Hotel Areca is a luxurious and modern boutique hotel, located in the vibrant city of Legazpi, Albay.', 4.6,  ['/assets/areca1.jpg', '/assets/areca2.jpg', '/assets/areca3.jpg'],
     [ 'We Offer:','5% discount on bookings',
      'Minimum advance booking: 1 day',
      ' 6% deposit required to secure the reservation']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/areca1.jpg" class="slide-img" />
        <img src="/assets/areca2.jpg" class="slide-img" />
        <img src="/assets/areca3.jpg" class="slide-img" />
        <img src="/assets/areca4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Hotel Areca</div>
        <div class="location">Rizal Avenue, Legazpi, Philippines</div>
      </div>
      <div class="desc">Hotel Areca is a luxurious and modern boutique hotel, located in the vibrant city of Legazpi,
        Albay.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bx-star'></i>
        <p>(4.6)</p>
      </div>
    </div>
    <div class="card" onclick="openModal('Hotel St Ellis', 'Location:Rizal Street, Legazpi, Albay','Discover a sanctuary of sophistication nestled in the heart of Legazpi City. Your city escape begins here!', 4.0,  ['/assets/ellis1.jpg', '/assets/ellis2.jpg', '/assets/ellis3.jpg'],
     [ 'We Offer:','5% discount on bookings',
      'Minimum advance booking: 1 day',
      ' 6% deposit required to secure the reservation']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/ellis1.jpg" class="slide-img" />
        <img src="/assets/ellis2.jpg" class="slide-img" />
        <img src="/assets/ellis3.jpg" class="slide-img" />
        <img src="/assets/ellis4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Hotel St. ellis</div>
        <div class="location">Rizal Avenue, Legazpi, Philippines</div>
      </div>
      <div class="desc">Hotel Areca is a luxurious and modern boutique hotel, located in the vibrant city of Legazpi,
        Albay.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bx-star'></i>
        <p>(4.0)</p>
      </div>
    </div>

    <div class="card" onclick="openModal('Hotel Inigi', 'Location: Rizal Street, Legazpi, Philippines','Hotel /assets/inigo offers a cozy and modern stay in the heart of Legazpi.', 4.4, ['/assets/inigo1.jpg', '/assets/inigo2.jpg', '/assets/inigo3.jpg'],
     ['We Offer:', 'Free Wi-Fi', 'Complimentary breakfast', '24-hour front desk']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/inigo1.jpg" class="slide-img" />
        <img src="/assets/inigo2.jpg" class="slide-img" />
        <img src="/assets/inigo3.jpg" class="slide-img" />
        <img src="/assets/inigo4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Hotel Inigo</div>
        <div class="location">Rizal Street, Legazpi, Philippines</div>
      </div>
      <div class="desc">Hotel Inigo offers a cozy and modern stay in the heart of Legazpi.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bxs-star-half'></i>
        <p>(4.4)</p>
      </div>
    </div>

    <div class="card" onclick="openModal('The Apple Peach House', 'Location: Corner Rosario and Marquez Street, Legazpi, Philippines','A charming boutique hotel offering cozy accommodations and modern amenities.', 4.2, ['/assets/applepeach1.jpg', '/assets/applepeach2.jpg', '/assets/applepeach4.jpg'],
     ['We Offer:', 'Free Wi-Fi', 'Complimentary breakfast', '24-hour front desk']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/applepeach1.jpg" class="slide-img" />
        <img src="/assets/applepeach2.jpg" class="slide-img" />
        <img src="/assets/applepeach3.jpg" class="slide-img" />
        <img src="/assets/applepeach4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">The Apple Peach House</div>
        <div class="location">Corner Rosario and Marquez Street, Legazpi, Philippines</div>
      </div>
      <div class="desc">A charming boutique hotel offering cozy accommodations and modern amenities.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bx-star'></i>
        <p>(4.0)</p>
      </div>
    </div>

    <div class="card" onclick="openModal('Casa Blanca Suites', 'Location: Legazpi City, Philippines','A stylish and comfortable hotel with spacious suites and excellent service.', 3.8, ['/assets/casblanca1.jpg', '/assets/casablanca2.jpg', '/assets/casablanca3.jpg'],
     ['We Offer:', 'Free Wi-Fi', 'Complimentary breakfast', 'Swimming pool access']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/casblanca1.jpg" class="slide-img" />
        <img src="/assets/casablanca2.jpg" class="slide-img" />
        <img src="/assets/casablanca3.jpg" class="slide-img" />
        <img src="/assets/casablanca4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Casa Blanca Suites</div>
        <div class="location">Legazpi City, Philippines</div>
      </div>
      <div class="desc">A stylish and comfortable hotel with spacious suites and excellent service.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bx-star'></i>
        <p>(3.8)</p>
      </div>
    </div>

    <div class="card" onclick="openModal('Hotel Sentro Legazpi', 'Location: Legazpi City, Philippines','A centrally located hotel offering convenience and modern amenities.', 4.0, ['/assets/centro1.jpg', '/assets/centro2.jpg', '/assets/centro3.jpg'],
     ['We Offer:', 'Free Wi-Fi', 'Complimentary breakfast', 'Business facilities']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/centro1.jpg" class="slide-img" />
        <img src="/assets/centro2.jpg" class="slide-img" />
        <img src="/assets/centro3.jpg" class="slide-img" />
        <img src="/assets/centro4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Hotel Centro Legazpi</div>
        <div class="location">Legazpi City, Philippines</div>
      </div>
      <div class="desc">A centrally located hotel offering convenience and modern amenities.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bx-star'></i>
        <p>(4.6)</p>
      </div>
    </div>

    <div class="card" onclick="openModal('Emerald Boutique Hotel', 'Location: Legazpi City, Philippines','A boutique hotel with elegant interiors and personalized service.', 4.4, ['/assets/emerald1.jpg', '/assets/emerald2.jpg', '/assets/emerald3.jpg'],
     ['We Offer:', 'Free Wi-Fi', 'Complimentary breakfast', 'Luxury suites']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/emerald1.jpg" class="slide-img" />
        <img src="/assets/emerald2.jpg" class="slide-img" />
        <img src="/assets/emerald3.jpg" class="slide-img" />
        <img src="/assets/emerald4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Emerald Boutique Hotel</div>
        <div class="location">Legazpi City, Philippines</div>
      </div>
      <div class="desc">A boutique hotel with elegant interiors and personalized service.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bx-star'></i>
        <p>(4.2)</p>
      </div>
    </div>
    <div class="card" onclick="openModal('Lotus Blu Hotel', 'Location: Yashano Mall, F. Imperial St, Legazpi, Philippines','A modern hotel offering comfort and convenience near Legazpi’s top attractions.', 4.4, ['/assets/lotusblu1.jpg', '/assets/lotusblu2.jpg', '/assets/lotusblu3.jpg'],
     ['We Offer:', 'Free Wi-Fi', 'Complimentary breakfast', '24-hour front desk']
      )">
      <div class="image-hover-wrapper multi-image">
        <img src="/assets/lotusblu1.jpg" class="slide-img" />
        <img src="/assets/lotusblu2.jpg" class="slide-img" />
        <img src="/assets/lotusblu3.jpg" class="slide-img" />
        <img src="/assets/lotusblu4.jpg" class="slide-img" />
      </div>
      <div class="info">
        <div class="title">Lotus Blu Hotel</div>
        <div class="location">Yashano Mall, F. Imperial St, Legazpi, Philippines</div>
      </div>
      <div class="desc">A modern hotel offering comfort and convenience near Legazpi’s top attractions.</div>
      <div class="stars">
        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
          class='bx bxs-star-half'></i>
        <p>(4.4)</p>
      </div>
    </div>



  </div>




  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <img id="modal-img" src="" />
      <h2 id="modal-title"></h2>
      <p id="modal-location" style="color: #555;"></p>
      <p id="modal-desc"></p>
      <div id="modal-stars" class="stars"></div>
      <p id="modal-offer" class="offer"></p>
    </div>
  </div>

  <script src="js/place.js"></script>
  <script src="js/profile.js"></script>
</body>

</html>