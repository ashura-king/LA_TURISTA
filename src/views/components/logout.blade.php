<style>
#logout-form button {
  all: unset;
  /* resets most default styles */
  display: flex;
  align-items: center;
  text-decoration: none;
  color: #525252;
  margin: 12px 0;
}

#logout-form button img {
  width: 40px;
  background: #e5e5e5;
  border-radius: 50%;
  padding: 8px;
  margin-right: 15px;
}

#logout-form button p {
  width: 100%;
}

#logout-form button span {
  font-size: 32px;
  transition: transorm 0.5;
}

#logout-form button::hover span {
  transform: translateX(5px);
}
</style>

<form action="/auth/logout" method="post" id="logout-form">
  <button type="submit" class="sub-menu-link">
    <img src="assets/logout.png">
    <p>Logout</p>
    <span>></span>
  </button>
</form>