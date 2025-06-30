let modalInterval;

    function openModal(title, location, desc, rating, imgUrls, offer) {

      document.getElementById("modal-title").textContent = title;
      document.getElementById("modal-location").textContent = location;
      document.getElementById("modal-desc").textContent = desc;

      let currentIndex = 0;
      const modalImg = document.getElementById("modal-img");
      modalImg.src = imgUrls[currentIndex];


      modalImg.classList.add("show");


      clearInterval(modalInterval);
      modalInterval = setInterval(() => {
        modalImg.classList.remove("show");
        setTimeout(() => {
          currentIndex = (currentIndex + 1) % imgUrls.length;
          modalImg.src = imgUrls[currentIndex];
          modalImg.classList.add("show");
        }, 1000);
      }, 1500);

      //offer-Section
      const offerContainer = document.getElementById("modal-offer");
      offerContainer.innerHTML = "";

      if (Array.isArray(offer)) {
        const ul = document.createElement("ul");

        offer.forEach(item => {
          const li = document.createElement("li");
          li.textContent = item;
          ul.appendChild(li);
        });

        offerContainer.appendChild(ul);
      } else {
        offerContainer.textContent = offer;
      }



      //Star Rate 

      let starsHTML = "";
      const fullStars = Math.floor(rating);
      const halfStar = rating % 1 >= 0.5;
      const totalStars = 5;


      for (let i = 0; i < fullStars; i++) {
        starsHTML += "<i class='bx bxs-star'></i>";
      }


      if (halfStar) {
        starsHTML += "<i class='bx bxs-star-half'></i>";
      }


      for (let i = fullStars + (halfStar ? 1 : 0); i < totalStars; i++) {
        starsHTML += "<i class='bx bx-star'></i>";
      }

      console.log(starsHTML);


      document.getElementById("modal-stars").innerHTML = starsHTML;




      const modal = document.getElementById("modal");
      modal.style.display = "flex";


      document.body.style.overflow = 'hidden';
    }

    function closeModal() {

      document.getElementById("modal").style.display = "none";
      clearInterval(modalInterval);


      document.body.style.overflow = 'scroll';
    }




    window.onclick = function(event) {
      const modal = document.getElementById("modal");
      if (event.target == modal) {
        closeModal();
      }
    };

    window.addEventListener("DOMContentLoaded", () => {
      document.getElementById("modal").style.display = "none";
    });

    //Image styling
    document.querySelectorAll('.multi-image').forEach(wrapper => {
      const images = wrapper.querySelectorAll('.slide-img');
      let index = 0;
      let interval;

      wrapper.addEventListener('mouseenter', () => {
        images.forEach(img => img.classList.remove('active'));
        images[0].classList.add('active');
        index = 1;

        interval = setInterval(() => {
          images.forEach(img => img.classList.remove('active'));
          images[index % images.length].classList.add('active');
          index++;
        }, 1000);
      });

      wrapper.addEventListener('mouseleave', () => {
        clearInterval(interval);
        images.forEach(img => img.classList.remove('active'));
        images[0].classList.add('active');
      });
    });

    //Search Bar

    function filterCards() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const cards = document.querySelectorAll('.card');
      const noResultsMessage = document.getElementById('noResultsMessage');
      let anyVisible = false;

      cards.forEach(card => {
        const title = card.querySelector('.title').innerText.toLowerCase();
        const location = card.querySelector('.location').innerText.toLowerCase();

        if (title.includes(input) || location.includes(input)) {
          card.style.display = '';
          anyVisible = true;
        } else {
          card.style.display = 'none';
        }
      });

      // Toggle the "no results" message based on visibility
      noResultsMessage.style.display = anyVisible ? 'none' : 'block';
    }
