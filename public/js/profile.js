function toggleMenu() {
  const subMenu = document.getElementById("subMenu");
  if (subMenu) {
    subMenu.classList.toggle("open-menu");
    console.log("Toggle menu clicked", subMenu.classList.contains("open-menu"));
  } else {
    console.error("subMenu element not found");
  }
}

document.addEventListener('DOMContentLoaded', function() {

  const editProfileBtn = document.getElementById('editProfileBtn');
  const editProfilePopup = document.getElementById('editProfilePopup');
  const exitBtn = document.getElementById('exit');
  const editForm = document.getElementById('edit-form');
  
  
  editProfileBtn.addEventListener('click', function(e) {
    e.preventDefault();
    editProfilePopup.style.display = 'flex';  
  });
  
  
  exitBtn.addEventListener('click', function() {
    editProfilePopup.style.display = 'none';
  });
  
  
  window.addEventListener('click', function(e) {
    if (e.target === editProfilePopup) {
      editProfilePopup.style.display = 'none';
    }
  });
  
  
  function showNotification(message, isSuccess) {
   
    if (!document.getElementById('notification')) {
      const notification = document.createElement('div');
      notification.id = 'notification';
      notification.style.position = 'fixed';
      notification.style.top = '20px';
      notification.style.right = '20px';
      notification.style.padding = '10px 20px';
      notification.style.borderRadius = '5px';
      notification.style.color = 'white';
      notification.style.display = 'none';
      notification.style.zIndex = '1000';
      document.body.appendChild(notification);
    }
    
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336';
    notification.style.display = 'block';
    
   
    setTimeout(() => {
      notification.style.display = 'none';
    }, 3000);
  }
  
 
  function callApi(url, method, data = null) {
    const options = {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      credentials: 'same-origin'
    };
    
    if (data) {
      options.body = JSON.stringify(data);
    }
  
    return fetch(url, options)
      .then(response => {
        if (!response.ok) {
          return response.json()
            .then(errorData => {
              throw new Error(errorData.message || `Error: ${response.status}`);
            })
            .catch(() => {
              // If JSON parsing fails, throw a generic error
              throw new Error(`Request failed with status: ${response.status}`);
            });
        }
        
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          return response.json();
        } else {
          return response.text().then(text => ({ message: text }));
        }
      });
    
  }

  editForm.addEventListener('submit', function(e) {
    e.preventDefault();
    

    const submitButton = document.activeElement;
    if (submitButton && submitButton.id === 'delete') {
      
      return;
    }
  
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    
   
    if (!username || !email) {
      showNotification('Username and email are required', false);
      return;
    }
    
    if (!isValidEmail(email)) {
      showNotification('Please enter a valid email address', false);
      return;
    }
    
    // Update button state
    const updateBtn = editForm.querySelector('.popup-update');  // Updated class name
    const originalBtnText = updateBtn.textContent;
    updateBtn.textContent = 'Updating...';
    updateBtn.disabled = true;
    
    // Make API call
    callApi('/edit/updateProfile', 'POST', { username, email })
      .then(data => {
        
        const usernameDisplay = document.querySelector('.user-info h3');
        if (usernameDisplay) {
          usernameDisplay.textContent = username;
        }
        
        
        
          showNotification(data.message||'Profile updated successfully!', true);
        
        
       
        editProfilePopup.style.display = 'none';  // Updated variable name
      })
      .catch(error => {
        showNotification(error.message || 'An error occurred. Please try again.', false);
        console.log(error);
      })
      .finally(() => {
       
        updateBtn.textContent = originalBtnText;
        updateBtn.disabled = false;
      });
  });
  
  function isValidEmail(email) {
    const atIndex = email.indexOf('@');
    if (atIndex < 1) return false; 
    
    const domainPart = email.slice(atIndex + 1);
 
    const dotIndex = domainPart.indexOf('.');
    if (dotIndex < 1) return false; 
    
    const extension = domainPart.slice(dotIndex + 1);
    if (extension.length < 1) return false;
    
    if (email.indexOf(' ') !== -1) return false;
    
    return true;
  }
 
  // Delete Account Handler
  const deleteBtn = document.getElementById('delete');
if (deleteBtn) {
  deleteBtn.addEventListener('click', function(e) {
    e.preventDefault();
    
    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
      // Update UI
      deleteBtn.textContent = 'Deleting...';
      deleteBtn.disabled = true;
      
      // Make the API call
      fetch('/edit/deleteUser', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Request failed with status: ${response.status}`);
        }
        
        // Handle successful deletion regardless of response content
        showNotification('Account deleted successfully. Redirecting to homepage...', true);
        
        // Redirect after successful deletion
        setTimeout(() => {
          window.location.href = '/';
        }, 2000);
      })
      .catch(error => {
        console.error('Delete account error:', error);
        showNotification('Failed to delete account. Please try again.', false);
      })
      .finally(() => {
        // Always reset button state
        deleteBtn.textContent = 'Delete Account';
        deleteBtn.disabled = false;
      });
    }
  });
}
  
 
  document.addEventListener('click', function(event) {
    const subMenu = document.getElementById("subMenu");
    const userImg = document.querySelector('.user-pic'); 
    
    if (subMenu && subMenu.classList.contains('open-menu') && 
        !subMenu.contains(event.target) && 
        event.target !== userImg) {
      subMenu.classList.remove('open-menu');
    }
  });
});