<?php
session_start();

// Check if user is logged in // Pārbauda, vai lietotājs ir pieslēdzies
if (!isset($_SESSION['user_id'])) {
    header('Location: Login/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>WRELO</title>
    <style>
        /* Modal Styles */
        .modal-content label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .modal-content textarea,
        .modal-content input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .color-label-options {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .color-option.selected {
            border-color: #333;
        }
        /* Edit Card Modal Styles */
        #editCardModal .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            margin: auto;
            font-family: 'Montserrat', sans-serif;
        }
        #editCardModal .modal-content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        #editCardModal .modal-content button {
            background-color: #0079bf;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            transition: background-color 0.3s;
        }
        #editCardModal .modal-content button:hover {
            background-color: #005f91;
        }
        #editCardModal .modal-content .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }
        #editCardModal .modal-content .close:hover,
        #editCardModal .modal-content .close:focus {
            color: #000;
        }
        /* Edit Button Styles */
        .edit-card-button {
            background-color: #0079bf;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .edit-card-button:hover {
            background-color: #005f91;
        }
        /* Add Workspace Button Styles */
        .create-workspace-button {
            background-color: #0079bf;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .create-workspace-button:hover {
            background-color: #005f91;
        }
        .workspace {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        /* Styles for search results */
        #search-results {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            width: 100%;
            z-index: 1000;
            top: 60px; /* Adjust this value to position it below the search bar */
        }

        .search-result-item {
            padding: 10px;
            cursor: pointer;
        }

        .search-result-item:hover {
            background-color: #f1f1f1;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const userId = <?php echo json_encode($user_id); ?>;
    </script>
    <script src="script.js" defer></script>
</head>
<body>
<?php
    require("Connect_db.php"); // Iekļauj datubāzes pieslēguma failu
?>
    <header class="trello-header">
        <div class="left-header">
            <div class="logo">
                <a href="main.php">
                    <img src="images/Wrelo-removebg-preview.png" alt="Trello Logo" />
                </a>
                <h3>|</h3>
                <h4>WRELO</h4>
            </div>
            <button id="starred-button" class="header-button">Starred ˅</button>
        </div>
        <div class="right-icons">
            <a href="Login/logout.php" class="login-button">Log Out</a> <!-- Atslēgties -->
            <form id="search-form">
                <button type="submit">Search</button> <!-- Meklēt -->
                <input type="search" id="search-input" placeholder="Search..." /> <!-- Meklēšanas laukums -->
                <div id="search-results"></div> <!-- Container for search results -->
            </form>
            <div class="right-btns">
                <button class="notification-button"><i class="fa fa-bell"></i></button> <!-- Paziņojumu poga -->
                <a href="account.php">
                    <button class="account-button">
                    <i class="fa fa-user-circle-o"></i>
                    </button>
                </a>
            </div>
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
                    <p>Boards</p> <!-- Dēļi -->
                </section>
            </a>
            <a href="navigation/members.html" class="section-link">
                <section class="section">
                    <i class="fa fa-user-plus"></i>
                    <p>Members</p> <!-- Dalībnieki -->
                </section>
            </a>
            <a href="navigation/workspace.html" class="section-link">
                <section class="section">
                    <i class="fa fa-cog"></i>
                    <p>Workspace Settings</p> <!-- Darbvietas iestatījumi -->
                </section>
            </a>
            <div>
                <div class="h1-Wv">
                    <p><b>Workspace views</b></p> <!-- Darbvietas skati -->
                </div>
                <a href="navigation/calendar.html" class="section-link">
                    <section class="section">
                            <i class="fa fa-calendar"></i>
                            <p>Calendar</p> <!-- Kalendārs -->
                    </section>
                </a>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p><b>Your Workspaces</b></p> <!-- Jūsu darbvietas -->
                <button class="create-workspace-button" id="createWorkspaceBtn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div id="workspaceList">
                <!-- Darbvietu saraksts tiks pievienots šeit -->
            </div>
        </aside>

        <main class="main-content">
            <section class="chat-section">
                <h2>WhatsApp-like Chat</h2>
                <div class="chat-messages">
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
                <div class="board-container" id="boardContainer">
                    <!-- Dēļi tiks pievienoti šeit -->
                </div>
            </section>
        </main>
    </div>

    <!-- Modalais logs darbvietas izveidei -->
<div id="addWorkspaceModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Create Board</h2> <!-- Izveidot darbvietu -->
        <label for="workspaceTitle">Board title <span class="required">*</span></label>
        <input type="text" id="workspaceTitle" name="workspaceTitle" required>
        <button id="createWorkspaceButton">Create Board</button> <!-- Izveidot darbvietu -->
    </div>
</div>
<!-- Modalais logs dēļa izveidei -->
<div id="addBoardModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Create List</h2> <!-- Izveidot dēli -->
        <div class="background-selection">
            <p>Background</p> <!-- Fons -->
            <div class="background-options">
                <div class="bg-option" style="background-color: #74b9ff;" data-bg="#74b9ff"></div>
                <div class="bg-option" style="background-color: #55efc4;" data-bg="#55efc4"></div>
                <div class="bg-option" style="background-color: #ffeaa7;" data-bg="#ffeaa7"></div>
                <div class="bg-option" style="background-color: #fab1a0;" data-bg="#fab1a0"></div>
            </div>
        </div>
        <label for="boardTitle">List title <span class="required">*</span></label>
        <input type="text" id="boardTitle" name="boardTitle" required>
        <button id="createBoardButton">Create List</button> <!-- Izveidot dēli -->
    </div>
</div>

<!-- Modal for editing card // Modalais logs kartītes rediģēšanai -->
<div id="editCardModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Card</h2> <!-- Rediģēt kartīti -->
        <!-- Card Name Field // Kartītes nosaukuma lauks -->
        <label for="cardName">Card Name</label> <!-- Kartītes nosaukums -->
        <input type="text" id="cardName" name="cardName">
        <!-- Description Field // Apraksta lauks -->
        <label for="cardDescription">Description</label> <!-- Apraksts -->
        <textarea id="cardDescription" name="cardDescription"></textarea>
        <!-- Color Label Field // Krāsu etiķetes lauks -->
        <label for="cardColorLabel">Color Label</label> <!-- Krāsu etiķete -->
        <div class="color-label-options">
            <div class="color-option" style="background-color: #74b9ff;" data-color="#74b9ff"></div>
            <div class="color-option" style="background-color: #55efc4;" data-color="#55efc4"></div>
            <div class="color-option" style="background-color: #ffeaa7;" data-color="#ffeaa7"></div>
            <div class="color-option" style="background-color: #fab1a0;" data-color="#fab1a0"></div>
        </div>
        <!-- File Attachment Field // Faila pievienošanas lauks -->
        <label for="cardFileAttachment">File Attachment</label> <!-- Faila pievienošana -->
        <input type="file" id="cardFileAttachment" name="cardFileAttachment">
        <div id="fileAttachmentContainer"></div>
        <!-- Comments Field // Komentāru lauks -->
        <label for="cardComments">Comments</label> <!-- Komentāri -->
        <textarea id="cardComments" name="cardComments"></textarea>
        <div id="commentsContainer"></div>

        <button id="saveCardButton">Save</button> <!-- Saglabāt -->
        <button id="editModeButton" style="display: none;">Edit</button> <!-- Rediģēt -->
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const searchResults = document.getElementById("search-results");

    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();

        if (query.length > 0) {
            fetch(`search_workspaces.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = "";

                    if (data.length > 0) {
                        data.forEach(workspace => {
                            const item = document.createElement("div");
                            item.classList.add("search-result-item");
                            item.textContent = workspace.name;
                            item.addEventListener("click", function () {
                                loadWorkspace(workspace.id, workspace.name);
                            });
                            searchResults.appendChild(item);
                        });
                    } else {
                        searchResults.innerHTML = "<div class='search-result-item'>No results found</div>";
                    }
                })
                .catch(error => {
                    console.error("Error fetching search results:", error);
                });
        } else {
            searchResults.innerHTML = "";
        }
    });

    document.addEventListener("click", function (event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.innerHTML = "";
        }
    });

    function loadWorkspace(workspaceId, workspaceTitle) {
        document.querySelector(".planning-section h2").textContent = workspaceTitle;
        document.querySelector(".board-container").innerHTML = ""; // Clear existing boards

        fetch(`admin/planing/get_boards.php?workspace_id=${workspaceId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(board => {
                    const boardContainer = document.querySelector(".board-container");
                    const newBoard = document.createElement("div");
                    newBoard.className = "board";
                    newBoard.style.backgroundColor = board.background_color;
                    newBoard.innerHTML = `
                        <h3>${board.name}</h3>
                        <div class="tasks"></div>
                        <div class="add-card" data-board-id="${board.id}">+ Add a card</div>`;
                    newBoard.dataset.workspaceId = workspaceId;

                    board.cards.forEach(card => {
                        const task = document.createElement("div");
                        task.className = "task";
                        task.dataset.cardId = card.id;
                        task.dataset.boardId = board.id;
                        task.dataset.description = card.description || '';
                        task.dataset.colorLabel = card.color_label || '';
                        task.dataset.comments = card.comments || '';
                        task.dataset.fileAttachment = card.file_attachment || '';
                        task.innerHTML = `
                            <p class="task-title">${card.name}</p>
                            <button class="edit-card-button">Edit</button>`;
                        newBoard.querySelector('.tasks').appendChild(task);
                    });

                    boardContainer.appendChild(newBoard);
                });
            })
            .catch(error => {
                console.error('Error fetching boards:', error);
            });
    }
});
</script>
</body>
</html>



