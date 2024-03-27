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

    
    <style>
      body p {
        font-size: 14px;
      }

      ul {
        list-style-type: none;
      }

      ul li {
        justify-content: center;
        align-items: center;
      }

      /* Add a hover effect to the notification icon */
      .create-board-button:hover i.fa-plus::after {
        content: "Add board"; /* Add the text you want to display */
        display: block;
        background-color: #012941; /* Background color for the tooltip */
        color: #fff; /* Text color for the tooltip */
        padding: 5px; /* Adjust the padding as needed */
        border-radius: 5px; /* Add rounded corners to the tooltip */
        position: absolute;
        top: 100%; /* Position the tooltip below the icon */
        left: 50%; /* Center the tooltip horizontally */
        transform: translateX(-50%); /* Center the tooltip horizontally */
        font-size: 9px; /* Adjust the font size as needed */
        white-space: nowrap; /* Prevent text from wrapping */
        opacity: 0; /* Initially hide the tooltip */
        transition: opacity 0.3s; /* Add a smooth transition effect for visibility */
      }

      /* Show the tooltip when hovering over the notification icon */
      .create-board-button:hover i.fa-plus::after {
        opacity: 0.9; /* Make the tooltip visible on hover */
      }
    </style>
    <title>WRELO</title>
  </head>
  <body>
    <header class="trello-header">
      <div class="left-header">
        <div class="logo">
          <a href="index.php">
            <img
              src="images/Wrelo-removebg-preview.png"
              alt="Trello Logo"
            />
          </a>
          <h3>|</h3>
          <h4>Wrello</h4>
        </div>
        <button id="workspace-button" class="header-button">Workspace ˅</button>
        <button id="recent-button" class="header-button">Recent ˅</button>
        <button id="templates-button" class="header-button">Templates ˅</button>
        <button id="starred-button" class="header-button">Starred ˅</button>
        <button id="create-button" class="header-button">Create</button>
      </div>

      <div class="right-header">
        <!-- Remove the Create button from here -->
      </div>
      <div class="right-icons">
        <a href="Login/login.php" class="login-button">Log In</a>
        <form>
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
            <button class="create-board-button">
              <i
                class="fa fa-plus"
                style="
                  cursor: pointer;
                  transition: background-color 0.3s, box-shadow 0.3s;
                "
              ></i>
            </button>
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

      <main class="main-content">
        <section class="chat-section">
          <h2>WhatsApp-like Chat</h2>
          <div class="chat-messages">
            <!-- Chat messages go here -->
            <div class="message">
              <span class="user">User 1:</span>
              <p>Hello, how are you?</p>
            </div>
            <div class="message">
              <span class="user">User 2:</span>
              <p>I'm good, thanks!</p>
            </div>
          </div>
          <textarea placeholder="Type your message..."></textarea>
          <button>Send</button>
        </section>
        <section class="planning-section">
          <h2>Trello-like Planning System</h2>
          <!-- Trello planning content goes here -->
          <div class="board">
            <!-- Board content goes here -->
          </div>
        </section>
      </main>
    </div>
  </body>
  <script src="script.js"></script>
</html>
