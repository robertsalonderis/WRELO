document.addEventListener("DOMContentLoaded", function () {
    const sidePanel = document.querySelector(".side-panel");
    const mainContent = document.querySelector(".main-content");
    const closeButton = document.querySelector(".close-button");
    const searchInput = document.querySelector("input[type='search']");
    const searchButton = document.querySelector("button[type='submit']");

    // Modal functionality for creating a workspace
    const addWorkspaceModal = document.getElementById("addWorkspaceModal");
    const createWorkspaceButton = document.getElementById("createWorkspaceButton");
    const createWorkspaceButtons = document.querySelectorAll(".create-workspace-button");
    const workspaceList = document.getElementById("workspaceList");
    let selectedWorkspaceId = null;

    // Modal functionality for creating a board
    const addBoardModal = document.getElementById("addBoardModal");
    const createBoardButton = document.getElementById("createBoardButton");
    let selectedBgColor = "";

    // Modal functionality for editing a card
    const editCardModal = document.getElementById("editCardModal");
    const editCardCloseButton = document.getElementsByClassName("close")[2];
    const editModeButton = document.getElementById("editModeButton");
    const saveCardButton = document.getElementById("saveCardButton");
    let editingCardElement = null; // To keep track of the card being edited

    // Toggle side panel visibility
    closeButton.addEventListener("click", function () {
        if (sidePanel.style.left === "-255px" || sidePanel.style.left === "") {
            sidePanel.style.left = "0";
            mainContent.classList.add("shifted");
        } else {
            sidePanel.style.left = "-255px";
            mainContent.classList.remove("shifted");
        }
    });

    // Toggle search bar expansion
    searchButton.addEventListener("click", function (event) {
        event.preventDefault();
        searchInput.classList.toggle("expanded");
    });

    createWorkspaceButtons.forEach(button => {
        button.onclick = function() {
            addWorkspaceModal.style.display = "block";
        }
    });

    addWorkspaceModal.querySelector('.close').onclick = function() {
        addWorkspaceModal.style.display = "none";
    }

    addBoardModal.querySelector('.close').onclick = function() {
        addBoardModal.style.display = "none";
    }

    editCardCloseButton.onclick = function() {
        editCardModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == addWorkspaceModal) {
            addWorkspaceModal.style.display = "none";
        }
        if (event.target == addBoardModal) {
            addBoardModal.style.display = "none";
        }
        if (event.target == editCardModal) {
            editCardModal.style.display = "none";
        }
    }

    document.querySelectorAll(".bg-option").forEach(option => {
        option.onclick = function() {
            document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected"));
            this.classList.add("selected");
            selectedBgColor = this.getAttribute("data-bg");
        }
    });

    createWorkspaceButton.onclick = function() {
        const workspaceTitle = document.getElementById("workspaceTitle").value.trim();
        if (!workspaceTitle) {
            alert("Workspace title is required");
            return;
        }

        const data = {
            user_id: userId,
            name: workspaceTitle
        };

        fetch('admin/planing/create_workspace.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newWorkspace = document.createElement("div");
                newWorkspace.className = "workspace";
                newWorkspace.innerHTML = `<p>${workspaceTitle}</p>`;
                newWorkspace.dataset.workspaceId = data.workspace_id;
                newWorkspace.onclick = function() {
                    selectWorkspace(data.workspace_id, workspaceTitle);
                };

                const addBoardButton = document.createElement("button");
                addBoardButton.className = "create-board-button";
                addBoardButton.innerHTML = '<i class="fa fa-plus"></i>';
                addBoardButton.onclick = function() {
                    addBoardModal.style.display = "block";
                };
                newWorkspace.appendChild(addBoardButton);

                workspaceList.appendChild(newWorkspace);
                addWorkspaceModal.style.display = "none";
                document.getElementById("workspaceTitle").value = "";
            } else {
                alert('Error creating workspace: ' + data.message);
                console.error('Error creating workspace:', data.message);
            }
        })
        .catch(error => {
            alert('Error creating workspace: ' + error.message);
            console.error('Error creating workspace:', error);
        });
    }

    function selectWorkspace(workspaceId, workspaceTitle) {
        selectedWorkspaceId = workspaceId;
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

    createBoardButton.onclick = function() {
        const boardTitle = document.getElementById("boardTitle").value.trim();
        if (!boardTitle) {
            alert("Board title is required");
            return;
        }

        const data = {
            workspace_id: selectedWorkspaceId,
            name: boardTitle,
            background_color: selectedBgColor
        };

        fetch('admin/planing/create_board.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const boardContainer = document.querySelector(".board-container");
                const newBoard = document.createElement("div");
                newBoard.className = "board";
                newBoard.style.backgroundColor = selectedBgColor;
                newBoard.innerHTML = `
                    <h3>${boardTitle}</h3>
                    <div class="tasks"></div>
                    <div class="add-card" data-board-id="${data.board_id}">+ Add a card</div>`;
                newBoard.dataset.workspaceId = selectedWorkspaceId;

                boardContainer.appendChild(newBoard);
                addBoardModal.style.display = "none";
                document.getElementById("boardTitle").value = "";
                document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected"));
                selectedBgColor = "";
            } else {
                alert('Error creating board: ' + data.message);
                console.error('Error creating board:', data.message);
            }
        })
        .catch(error => {
            alert('Error creating board: ' + error.message);
            console.error('Error creating board:', error);
        });
    }

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-card')) {
            const boardId = event.target.dataset.boardId;
            const taskTitle = prompt("Enter task title:");
            if (taskTitle) {
                const cardData = {
                    board_id: boardId,
                    name: taskTitle,
                    description: ''
                };

                fetch('admin/planing/create_card.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(cardData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const task = document.createElement("div");
                        task.className = "task";
                        task.dataset.cardId = data.card_id;
                        task.dataset.boardId = boardId;
                        task.innerHTML = `
                            <p class="task-title">${taskTitle}</p>
                            <button class="edit-card-button">Edit</button>`;
                        event.target.previousElementSibling.appendChild(task);
                    } else {
                        alert('Error creating card: ' + data.message);
                        console.error('Error creating card:', data.message);
                    }
                })
                .catch(error => {
                    alert('Error creating card: ' + error.message);
                    console.error('Error creating card:', error);
                });
            }
        }

        if (event.target.classList.contains('edit-card-button')) {
            editCardModal.style.display = "block";
            editingCardElement = event.target.closest('.task');
            const cardDescription = editingCardElement.querySelector('.task-title').textContent;
            document.getElementById('cardDescription').value = cardDescription; // Populate description

            document.getElementById('fileAttachmentContainer').innerHTML = ''; // Populate file attachment
            document.getElementById('commentsContainer').innerHTML = ''; // Populate comments
            document.getElementById('checklistItems').innerHTML = ''; // Populate checklist

            document.getElementById('cardDescription').readOnly = false;
            document.querySelectorAll('.color-option').forEach(option => option.style.pointerEvents = 'auto');
            document.getElementById('cardFileAttachment').style.display = 'block';
            document.getElementById('cardComments').style.display = 'block';
            document.getElementById('addChecklistItem').style.display = 'block';
            document.querySelectorAll('#checklistItems li').forEach(item => item.style.pointerEvents = 'auto');
            editModeButton.style.display = 'none';
            saveCardButton.style.display = 'block';
        }
    });

    var colorOptions = document.querySelectorAll('.color-option');
    var selectedColor = ''; // Variable to hold the selected color
    colorOptions.forEach(function(option) {
        option.addEventListener('click', function() {
            colorOptions.forEach(function(opt) {
                opt.classList.remove('selected');
            });
            this.classList.add('selected');
            selectedColor = this.dataset.color;
        });
    });

    var addChecklistItemButton = document.getElementById('addChecklistItem');
    var checklistContainer = document.getElementById('checklistItems');
    addChecklistItemButton.addEventListener('click', function() {
        var newItemText = document.getElementById('newChecklistItem').value;
        if (newItemText) {
            var newItem = document.createElement('li');
            newItem.innerHTML = `<span>${newItemText}</span><input type="checkbox" class="checklist-item-checkbox">`;
            checklistContainer.appendChild(newItem);
            document.getElementById('newChecklistItem').value = '';
        }
    });

    checklistContainer.addEventListener('change', function(event) {
        if (event.target.classList.contains('checklist-item-checkbox')) {
            if (event.target.checked) {
                event.target.closest('li').classList.add('completed');
            } else {
                event.target.closest('li').classList.remove('completed');
            }
        }
    });

    saveCardButton.addEventListener('click', function() {
        var description = document.getElementById('cardDescription').value;
        var cardId = editingCardElement ? editingCardElement.dataset.cardId : null;
        var boardId = editingCardElement ? editingCardElement.dataset.boardId : null;
        var colorLabel = selectedColor;
        var comments = document.getElementById('cardComments').value;
        var fileAttachment = document.getElementById('cardFileAttachment').files[0];
        var checklistItems = [];
        checklistContainer.querySelectorAll('li').forEach(function(item) {
            checklistItems.push({ text: item.querySelector('span').textContent, is_checked: item.querySelector('input[type="checkbox"]').checked });
        });

        var cardData = new FormData();
        cardData.append('id', cardId);
        cardData.append('board_id', boardId);
        cardData.append('description', description);
        cardData.append('color_label', colorLabel);
        cardData.append('comments', comments);
        if (fileAttachment) {
            cardData.append('file_attachment', fileAttachment);
        }
        cardData.append('checklist', JSON.stringify(checklistItems));

        fetch('admin/planing/update_card.php', {
            method: 'POST',
            body: cardData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (editingCardElement) {
                    editingCardElement.querySelector('.task-title').textContent = description;
                }
                editCardModal.style.display = "none";
            } else {
                alert('Error saving card details: ' + data.message);
                console.error('Error saving card details:', data.message);
            }
        })
        .catch(error => {
            alert('Error saving card details: ' + error.message);
            console.error('Error saving card details:', error);
        });
    });

    function fetchWorkspaces() {
        fetch(`admin/planing/get_workspaces.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(workspace => {
                    const newWorkspace = document.createElement("div");
                    newWorkspace.className = "workspace";
                    newWorkspace.textContent = workspace.name;
                    newWorkspace.dataset.workspaceId = workspace.id;
                    newWorkspace.onclick = function() {
                        selectWorkspace(workspace.id, workspace.name);
                    };

                    const addBoardButton = document.createElement("button");
                    addBoardButton.className = "create-board-button";
                    addBoardButton.innerHTML = '<i class="fa fa-plus"></i>';
                    addBoardButton.onclick = function() {
                        addBoardModal.style.display = "block";
                    };
                    newWorkspace.appendChild(addBoardButton);

                    workspaceList.appendChild(newWorkspace);
                });
            })
            .catch(error => {
                console.error('Error fetching workspaces:', error);
            });
    }

    fetchWorkspaces();
});




