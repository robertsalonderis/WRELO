<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="Styles/style-b.css" />
    <link rel="stylesheet" href="Styles/style-m.css" />

    <style></style>
    <title>Account</title>
    <style>
      body{
        background: #ddd;
      }

      h1{
        padding: 1rem 1rem 2.5rem 1rem;
      }

      .main-profile {
        margin: auto;
        width: 50%;
        padding: 10px;
      }

.p-cont {
  width: 100%;
  max-width: 500px; /* Adjust based on your preference */
  padding: 20px;
  box-sizing: border-box;
}

#profile-form {
  display: flex;
  flex-direction: column;
  gap: 10px; /* Adjust the space between form elements */
}

#profile-form label {
  font-weight: bold; /* Make labels bold */
}

#profile-form input[type="text"],
#profile-form input[type="email"],
#profile-form input[type="url"],
#profile-form textarea {
  padding: 8px;
  margin-bottom: 10px; /* Space below each input */
  border: 1px solid #ccc; /* Border color */
  border-radius: 5px; /* Rounded corners for the inputs */
}

#profile-form button {
  padding: 10px;
  background-color: #007bff; /* Button color */
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

#profile-form button:hover {
  background-color: #0056b3; /* Darker shade on hover */
}

    </style>
  </head>
  <body>
    <header class="trello-header">
      <div class="left-header">
        <div class="logo">
          <a href="main.php">
            <img
              src="images/Wrelo-removebg-preview.png"
              alt="Trello Logo"
            />
          </a>
          <h3>|</h3>
          <h4>Wrello</h4>
        </div>
        <button id="starred-button" class="header-button">Starred ˅</button>
      </div>
      
      <div class="right-icons">
        <a href="Login/login.html" class="login-button">Log In</a>
        <form id="search-form">
          <button type="submit">Search</button>
          <input type="search" placeholder="Search..." />
        </form>
        <button class="notification-button"><i class="fa fa-bell"></i></button>
        <button class="account-button">
          <i class="fa fa-user-circle-o"></i>
        </button>
      </div>
    </header>

    <div class="page">
      <aside class="side-panel">
        <button class="close-button">
          <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </button>
        <a href="navigation/boards.html" class="section-link">
          <section class="section">
            <i class="fa fa-tasks"></i>
            <p>Boards</p>
            <!-- List of boards goes here -->
          </section>
        </a>

        <a href="navigation/members.html" class="section-link">
          <section class="section">
            <i class="fa fa-user-plus"></i>
            <p>Members</p>
            <!-- List of members goes here -->
          </section>
        </a>
        <a href="navigation/workspace.html" class="section-link">
          <section class="section">
            <i class="fa fa-cog"></i>
            <p>Workspace Settings</p>
          </section>
        </a>

        <div>
          <div class="h1-Wv">
            <p><b>Workspace views</b></p>
          </div>
          <a href="navigation/table.html" class="section-link">
            <section class="section section-buttons">
              <button class="table-button">
                <i class="fa fa-th-list style=" styl="font-size: 16px"></i>
                <p>Table</p>
              </button>
            </section>
          </a>
          <a href="navigation/calendar.html" class="section-link">
            <section class="section section-buttons">
              <button class="calendar-button">
                <i class="fa fa-calendar"></i>
                <p>Calendar</p>
              </button>
            </section>
          </a>
        </div>

        <div
          style="
            display: flex;
            justify-content: space-between;
            align-items: center;
          "
        >
          <p><b>Your Boards</b></p>
          <button class="create-board-button">
            <i
              class="fa fa-plus"
              style="
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
              "
            ></i>
          </button>
        </div>
      </aside>



      <main class="main-profile">
  <div class="p-cont">
    <h1>Profile</h1>
    <form id="profile-form">
      <label for="name">NAME</label>
      <input type="text" id="name" placeholder="Your Name">

      <label for="username">SURNAME</label>
      <input type="text" id="name" placeholder="Your Surname">

      <label for="email">EMAIL</label>
      <input type="email" id="email" placeholder="Your Email">

      <label for="location">USERNAME</label>
      <input type="text" id="username" placeholder="Your Username">

      <label for="website">WEBSITE</label>
      <input type="url" id="website" placeholder="Your Website">

      <label for="bio">BIO</label>
      <textarea id="bio" placeholder="Your Bio" rows="4"></textarea>
    </form>
  </div>
</main>

  </body>
  <script src="script.js"></script>
</html>
