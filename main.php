<?php
session_start();

// Check if user is logged in
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
        #checklistContainer {
            margin-top: 10px;
        }
        #checklistContainer ul {
            list-style-type: none;
            padding-left: 0;
        }
        #checklistContainer ul li {
            padding: 5px;
            background: #f4f4f4;
            border-radius: 3px;
            margin-bottom: 5px;
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
        #editCardModal .modal-content .color-label-options {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        #editCardModal .modal-content #checklistContainer ul {
            list-style-type: none;
            padding-left: 0;
        }
        #editCardModal .modal-content #checklistContainer ul li {
            padding: 5px;
            background: #f4f4f4;
            border-radius: 3px;
            margin-bottom: 5px;
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
        .delete-button {
            background-color: transparent;
            color: red;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
            transition: color 0.3s;
        }
        .delete-button:hover {
            color: darkred;
        }
    </style>
</head>
<body>
<?php
    require("Connect_db.php");
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
            <a href="Login/logout.php" class="login-button">Log Out</a>
            <form id="search-form">
                <button type="submit">Search</button>
                <input type="search" placeholder="Search..." />
            </form>
            <div class="right-btns">
                <button class="notification-button"><i class="fa fa-bell"></i></button>
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
                    <p>Boards</p>
                </section>
            </a>
            <a href="navigation/members.html" class="section-link">
                <section class="section">
                    <i class="fa fa-user-plus"></i>
                    <p>Members</p>
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
                <a href="navigation/calendar.html" class="section-link">
                    <section class="section">
                            <i class="fa fa-calendar"></i>
                            <p>Calendar</p>
                    </section>
                </a>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p><b>Your Workspaces</b></p>
                <button class="create-workspace-button" id="createWorkspaceBtn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div id="workspaceList">
                <!-- List of workspaces will be appended here -->
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
                    <!-- Boards will be added here -->
                </div>
            </section>
        </main>
    </div>
    <!-- Modal for creating workspace -->
    <div id="addWorkspaceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create Workspace</h2>
            <label for="workspaceTitle">Workspace title <span class="required">*</span></label>
            <input type="text" id="workspaceTitle" name="workspaceTitle" required>
            <button id="createWorkspaceButton">Create Workspace</button>
        </div>
    </div>
    <!-- Modal for creating board -->
    <div id="addBoardModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create Board</h2>
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
    <!-- Modal for editing card -->
    <div id="editCardModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Card</h2>
            <!-- Description Field -->
            <label for="cardDescription">Description</label>
            <textarea id="cardDescription" name="cardDescription"></textarea>
            <!-- Color Label Field -->
            <label for="cardColorLabel">Color Label</label>
            <div class="color-label-options">
                <div class="color-option" style="background-color: #74b9ff;" data-color="#74b9ff"></div>
                <div class="color-option" style="background-color: #55efc4;" data-color="#55efc4"></div>
                <div class="color-option" style="background-color: #ffeaa7;" data-color="#ffeaa7"></div>
                <div class="color-option" style="background-color: #fab1a0;" data-color="#fab1a0"></div>
            </div>
            <!-- File Attachment Field -->
            <label for="cardFileAttachment">File Attachment</label>
            <input type="file" id="cardFileAttachment" name="cardFileAttachment">
            <div id="fileAttachmentContainer"></div>
            <!-- Comments Field -->
            <label for="cardComments">Comments</label>
            <textarea id="cardComments" name="cardComments"></textarea>
            <div id="commentsContainer"></div>
            <!-- Checklist Field -->
            <label for="cardChecklist">Checklist</label>
            <div id="checklistContainer">
                <input type="text" id="newChecklistItem" placeholder="Add a checklist item">
                <button id="addChecklistItem">Add</button>
                <ul id="checklistItems">
                    <!-- Checklist items will be added here -->
                </ul>
            </div>
            <button id="saveCardButton">Save</button>
            <button id="editModeButton" style="display: none;">Edit</button>
        </div>
    </div>
    <script>
        const userId = <?php echo json_encode($user_id); ?>;
    </script>
    <script src="script.js"></script>
</body>
</html>



