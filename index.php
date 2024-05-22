<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
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

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 400px; /* Limit width */
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .background-selection {
            margin: 15px 0;
        }

        .background-options {
            display: flex;
            justify-content: space-between;
        }

        .bg-option {
            width: 50px;
            height: 50px;
            cursor: pointer;
            border-radius: 5px;
            border: 2px solid transparent;
        }

        .bg-option.selected {
            border: 2px solid #333;
        }

        .required {
            color: red;
        }

        #boardTitle {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Board and Task styles */
        .board {
            display: inline-block;
            vertical-align: top;
            background-color: #e2e4e6;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
            width: 300px;
        }

        .board h3 {
            margin-top: 0;
        }

        .task {
            background-color: #fff;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 0 rgba(9, 30, 66, 0.25);
        }

        .add-card {
            display: flex;
            align-items: center;
            color: #5e6c84;
            cursor: pointer;
            padding: 10px;
        }

        .add-card:hover {
            background-color: rgba(9, 30, 66, 0.08);
            border-radius: 5px;
        }

        .task .task-title {
            margin: 0;
        }
    </style>
    <title>WRELO</title>
</head>
<body>
    <header class="trello-header">
        <div class="left-header">
            <div class="logo">
                <a href="index.php">
                    <img src="images/Wrelo-removebg-preview.png" alt="Trello Logo" />
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

        <div class="right-header"></div>
        <div class="right-icons">
            <a href="Login/login.php" class="login-button">Log In</a>
            <form id="search-form">
                <button type="submit">Search</button>
                <input type="search" placeholder="Search..." />
            </form>
            <button class="notification-button"><i class="fa fa-bell"></i></button>
            <a href="account.php">
                <button class="account-button">
                    <i class="fa fa-user-circle-o"></i>
                </button>
            </a>
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
                        <i class="fa fa-plus" style="cursor: pointer; transition: background-color 0.3s, box-shadow 0.3s;"></i>
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
                            <i class="fa fa-th-list" style="font-size: 16px;"></i>
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

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p><b>Your Boards</b></p>
                <button class="create-board-button">
                    <i class="fa fa-plus" style="cursor: pointer; transition: background-color 0.3s, box-shadow 0.3s;"></i>
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
                <div class="board-container">
                    <!-- Boards will be added here -->
                </div>
            </section>
        </main>
    </div>

    <!-- Modal for creating board -->
    <div id="addBoardModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create board</h2>
            <div class="background-selection">
                <p>Background</p>
                <div class="background-options">
                    <div class="bg-option" style="background-color: #74b9ff;" data-bg="#74b9ff"></div>
                    <div class="bg-option" style="background-color: #55efc4;" data-bg="#55efc4"></div>
                    <div class="bg-option" style="background-color: #ffeaa7;" data-bg="#ffeaa7"></div>
                    <div class="bg-option" style="background-color: #fab1a0;" data-bg="#fab1a0"></div>
                </div>
            </div>
            <label for="boardTitle">Board title <span class="required">*</span></label>
            <input type="text" id="boardTitle" name="boardTitle" required>
            <button id="createBoardButton">Create Board</button>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Get the modal
            var modal = document.getElementById("addBoardModal");

            // Get the button that opens the modal
            var btn = document.querySelectorAll(".create-board-button");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // Get the create board button inside the modal
            var createBoardButton = document.getElementById("createBoardButton");

            // Variable to store selected background color
            var selectedBgColor = "";

            // When the user clicks the button, open the modal 
            btn.forEach(button => {
                button.onclick = function() {
                    modal.style.display = "block";
                }
            });

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Handle background color selection
            document.querySelectorAll(".bg-option").forEach(option => {
                option.onclick = function() {
                    document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected"));
                    this.classList.add("selected");
                    selectedBgColor = this.getAttribute("data-bg");
                }
            });

            // Handle board creation
            createBoardButton.onclick = function() {
                var boardTitle = document.getElementById("boardTitle").value.trim();
                if (!boardTitle) {
                    alert("Board title is required");
                    return;
                }

                var boardContainer = document.querySelector(".planning-section .board-container");
                var newBoard = document.createElement("div");
                newBoard.className = "board";
                newBoard.style.backgroundColor = selectedBgColor;
                newBoard.innerHTML = `<h3>${boardTitle}</h3><div class="tasks"></div><div class="add-card">+ Add a card</div>`;
                
                boardContainer.appendChild(newBoard);

                // Close the modal
                modal.style.display = "none";

                // Reset modal inputs
                document.getElementById("boardTitle").value = "";
                document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected"));
                selectedBgColor = "";
            }

            // Handle adding tasks
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-card')) {
                    var taskTitle = prompt("Enter task title:");
                    if (taskTitle) {
                        var task = document.createElement("div");
                        task.className = "task";
                        task.innerHTML = `<p class="task-title">${taskTitle}</p>`;
                        event.target.previousElementSibling.appendChild(task);
                    }
                }
            });
        });
    </script>
</body>
</html>


