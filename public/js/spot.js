// Lightweight script for ratings and comments

// Cache DOM elements and initialize data
let ratingsData = {};
const modal = document.getElementById("imageModal");
const stars = document.querySelectorAll(".star");
const starText = document.getElementById("starRatingText");
const ratingForm = document.getElementById("ratingForm");
const submitBtn = document.getElementById("submitRatingBtn");
const commentField = document.getElementById("ratingComment");

let currentDestination = '';
let userName = '';

// Server endpoint for ratings and comments
const API_ENDPOINT = ratingForm ? ratingForm.action : '/api/ratings';

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  // Get username if available
  const usernameEl = document.querySelector('.user-info h3');
  if (usernameEl && usernameEl.textContent.trim() !== "User Profile") {
    userName = usernameEl.textContent.trim();
    document.getElementById("name").value = userName;
  }
  
  // Setup star rating handlers
  stars.forEach((star, index) => {
    star.addEventListener("click", () => handleStarRating(index + 1));
  });
  
  // Form submission handler
  ratingForm.addEventListener("submit", handleRatingSubmit);
  
  // Load all ratings data from server on page load
  fetchAllRatingsData();
  
  // Add CSS for average rating display
  const style = document.createElement('style');
  style.textContent = `
    .avg-rating-display {
      text-align: center;
      margin: 10px 0;
      font-weight: bold;
      color: #f8b400;
      font-size: 1.2rem;
    }
  `;
  document.head.appendChild(style);
});

// Fetch all ratings data from server
function fetchAllRatingsData() {
  fetch(`${API_ENDPOINT}/all`)
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();
    })
    .then(data => {
      ratingsData = data;
      // Update any open modals
      if (modal.style.display === "flex" && currentDestination) {
        displayComments();
        updateAverageRating();
      }
    })
    .catch(error => {
      console.warn('Failed to load ratings from server:', error);
      // Fall back to local storage as a backup
      loadFromLocalStorage();
    });
}

// Load from localStorage as fallback
function loadFromLocalStorage() {
  try {
    const stored = localStorage.getItem('ratingsData');
    ratingsData = stored ? JSON.parse(stored) : {};
  } catch (e) {
    console.warn('Failed to load ratings data from localStorage', e);
    ratingsData = {};
  }
}

// Open modal with destination details
function openModal(imageSrc, title, description, location, bestTime, activities, mapSrc) {
  currentDestination = title;
  modal.style.display = "flex";
  
  // Set modal content
  document.getElementById("modalImg").src = imageSrc;
  document.getElementById("modalTitle").innerText = title;
  document.getElementById("modalDescription").innerText = description;
  document.getElementById("modalLocation").innerText = location;
  document.getElementById("modalBestTime").innerText = bestTime;
  document.getElementById("modalActivities").innerText = activities;
  document.getElementById("modalMap").src = mapSrc;

  // Reset rating form
  resetRatingForm();
  
  // Fetch the latest ratings for this destination from server
  fetchDestinationRatings(title);
  
  // Ensure comments section exists
  ensureCommentsSection();
}

// Fetch ratings for a specific destination
function fetchDestinationRatings(destinationName) {
  const encodedName = encodeURIComponent(destinationName);
  
  fetch(`${API_ENDPOINT}?destination=${encodedName}`)
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();
    })
    .then(data => {
      // Update ratings data for this destination
      ratingsData[destinationName] = data;
      
      // Update UI
      displayComments();
      updateAverageRating();
    })
    .catch(error => {
      console.warn(`Failed to load ratings for ${destinationName}:`, error);
      // Display whatever we have in the ratingsData object (which might be from localStorage)
      displayComments();
      updateAverageRating();
    });
}

// Update the average rating display
function updateAverageRating() {
  const destRatings = ratingsData[currentDestination] || [];
  
  // Calculate average rating
  let avgRatingText = "No ratings yet";
  
  if (destRatings.length > 0) {
    const avg = destRatings.reduce((sum, item) => sum + item.rating, 0) / destRatings.length;
    avgRatingText = `Average Rating: ${avg.toFixed(1)} ★`;
  }
  
  // Update the starText element
  starText.innerText = avgRatingText;
  
  // Also add a visible average rating near the top of the modal
  const modalTitle = document.getElementById("modalTitle");
  
  // Check if average rating display already exists, remove if it does
  const existingAvg = document.getElementById("avgRatingDisplay");
  if (existingAvg) {
    existingAvg.remove();
  }
  
  // Create new average rating display
  const avgDisplay = document.createElement("div");
  avgDisplay.id = "avgRatingDisplay";
  avgDisplay.className = "avg-rating-display";
  avgDisplay.innerHTML = avgRatingText;
  
  // Insert after the modal title
  if (modalTitle && modalTitle.parentNode) {
    modalTitle.parentNode.insertBefore(avgDisplay, modalTitle.nextSibling);
  }
}

// Close modal
function closeModal() {
  modal.style.display = "none";
}

// Handle star rating selection
function handleStarRating(value) {
  // Reset all stars
  stars.forEach(s => s.classList.remove("selected"));
  
  // Highlight selected stars
  for (let i = 0; i < value; i++) {
    stars[i].classList.add("selected");
  }
  
  // Update UI
  starText.innerText = `You selected ${value} ★`;
  document.getElementById("ratingValue").value = value;
  submitBtn.style.display = "block";
}

// Reset rating form
function resetRatingForm() {
  stars.forEach(star => star.classList.remove("selected"));
  commentField.value = '';
  submitBtn.style.display = "none";
}

// Handle rating form submission
function handleRatingSubmit(e) {
  e.preventDefault();
  
  const ratingValue = parseInt(document.getElementById("ratingValue").value);
  const comment = commentField.value;
  document.getElementById("ratingMessage").value = comment;
  
  // Set username in form if available
  if (userName) {
    document.getElementById("name").value = userName;
  }

  // Get destination name
  const destinationName = currentDestination;
  
  // Create the rating data object
  const ratingData = {
    destination: destinationName,
    rating: ratingValue,
    comment: comment,
    name: userName || document.getElementById("name").value || "Anonymous",
    timestamp: new Date().toISOString()
  };

  // Submit via AJAX to server
  if (ratingForm.action && ratingForm.action.trim() !== '') {
    const formData = new FormData(ratingForm);
    
    fetch(ratingForm.action, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.includes("application/json")) {
        return response.json();
      }
      return { success: response.ok };
    })
    .then(() => {
      // After successful server submission, fetch the updated ratings
      fetchDestinationRatings(destinationName);
      
      // Also save locally as a backup
      saveRatingLocally(ratingValue, comment);
      
      // Show success message
      starText.innerText = "Thank you for your rating!";
      resetRatingForm();
    })
    .catch(error => {
      console.error('Error submitting rating:', error);
      // Fallback to local storage if server submission fails
      saveRatingLocally(ratingValue, comment);
    });
  } else {
    // Fallback to just local storage if no action URL
    saveRatingLocally(ratingValue, comment);
  }
}

// Save rating to local storage
function saveRatingLocally(rating, comment) {
  if (!ratingsData[currentDestination]) ratingsData[currentDestination] = [];
  
  ratingsData[currentDestination].push({
    rating,
    comment,
    name: userName || document.getElementById("name").value || "Anonymous",
    timestamp: new Date().toISOString()
  });
  
  try {
    localStorage.setItem('ratingsData', JSON.stringify(ratingsData));
  } catch (e) {
    console.warn('Failed to save ratings data', e);
  }
  
  // Update UI
  starText.innerText = "Thank you for your rating!";
  resetRatingForm();
  displayComments();
  updateAverageRating();
}

// Ensure comments section exists
function ensureCommentsSection() {
  const modalContent = document.querySelector(".modal-content");
  if (!modalContent) return;
  
  let commentsSection = document.getElementById("commentsSection");
  if (!commentsSection) {
    commentsSection = document.createElement("div");
    commentsSection.id = "commentsSection";
    commentsSection.className = "comments-section";
    commentsSection.style.textAlign = "left";
    
    const ratingForm = document.getElementById("ratingForm");
    if (ratingForm) {
      ratingForm.parentNode.insertBefore(commentsSection, ratingForm.nextSibling);
    } else {
      modalContent.appendChild(commentsSection);
    }
  }
}

// Display comments
function displayComments() {
  const commentsSection = document.getElementById("commentsSection");
  if (!commentsSection) return;
  
  commentsSection.innerHTML = "<h3>Recent Comments</h3>";

  const allRatings = ratingsData[currentDestination] || [];
  
  if (allRatings.length === 0) {
    commentsSection.innerHTML += `<p class="no-comments">No comments yet. Be the first to comment!</p>`;
    return;
  }
  
  
  const sortedRatings = allRatings
    .filter(item => item.comment?.trim())
    .sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
  
  
  const commentsContainer = document.createElement('div');
  commentsContainer.className = 'comments-container text-left';
  commentsContainer.style.textAlign = 'left';
  
  sortedRatings.forEach(item => {
    const stars = '<i class="bx bxs-star"></i>'.repeat(item.rating) + 
                 '<i class="bx bx-star"></i>'.repeat(5 - item.rating);
    
    const nameHtml = item.name ? `<div class="comment-name"s><strong>${item.name}</strong> says:</div>` : "";
    
    const commentEl = document.createElement('div');
    commentEl.className = 'comment-item';
    commentEl.style.textAlign = 'left';
    commentEl.style.margin = '10px 0';
    commentEl.innerHTML = `
      ${nameHtml}
      <div class="comment-rating" style="text-align: left;">${stars}</div>
      <div class="comment-text" style="text-align: left;">${item.comment}</div>
    `;
    
    commentsContainer.appendChild(commentEl);
  });
  
  commentsSection.appendChild(commentsContainer);
}


window.onclick = event => {
  if (event.target === modal) closeModal();
}