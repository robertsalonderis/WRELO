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
    const addBoardCloseButton = document.getElementsByClassName("close")[1];
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

    addBoardCloseButton.onclick = function() {
        addBoardModal.style.display = "none";
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

        const formData = new FormData();
        formData.append('lietotajs_id', userId);
        formData.append('nosaukums', workspaceTitle);

        fetch('admin/izveidot_darbtelpu.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const newWorkspace = document.createElement("div");
                newWorkspace.className = "workspace";
                newWorkspace.textContent = workspaceTitle;
                newWorkspace.dataset.workspaceId = data.darbtelpa_id;
                newWorkspace.onclick = function() {
                    selectWorkspace(data.darbtelpa_id, workspaceTitle);
                };

                // Create the "Add Board" button immediately
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
            }
        });
    }

    function selectWorkspace(workspaceId, workspaceTitle) {
        selectedWorkspaceId = workspaceId;
        document.querySelector(".planning-section h2").textContent = workspaceTitle;
        document.querySelector(".board-container").innerHTML = ""; // Clear existing boards

        // Fetch and display boards for the selected workspace
        fetch(`admin/datu_atrasana.php?darbtelpa_id=${workspaceId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(board => {
                    const boardContainer = document.querySelector(".board-container");
                    const newBoard = document.createElement("div");
                    newBoard.className = "board";
                    newBoard.style.backgroundColor = board.bg_krasa;
                    newBoard.innerHTML = `<h3>${board.nosaukums}</h3><div class="tasks"></div><div class="add-card" data-board-id="${board.deli_id}">+ Add a card</div>`;
                    newBoard.dataset.workspaceId = workspaceId;

                    board.cards.forEach(card => {
                        const task = document.createElement("div");
                        task.className = "task";
                        task.dataset.cardId = card.kartis_id;
                        task.dataset.boardId = board.deli_id;
                        task.innerHTML = `
                            <p class="task-title">${card.apraksts}</p>
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

        const formData = new FormData();
        formData.append('darbtelpa_id', selectedWorkspaceId);
        formData.append('nosaukums', boardTitle);
        formData.append('bg_krasa', selectedBgColor);

        fetch('admin/izveidot_deli.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const boardContainer = document.querySelector(".board-container");
                const newBoard = document.createElement("div");
                newBoard.className = "board";
                newBoard.style.backgroundColor = selectedBgColor;
                newBoard.innerHTML = `<h3>${boardTitle}</h3><div class="tasks"></div><div class="add-card" data-board-id="${data.deli_id}">+ Add a card</div>`;
                newBoard.dataset.workspaceId = selectedWorkspaceId;

                boardContainer.appendChild(newBoard);
                addBoardModal.style.display = "none";
                document.getElementById("boardTitle").value = "";
                document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected"));
                selectedBgColor = "";
            } else {
                alert('Error creating board: ' + data.message);
            }
        });
    }

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-card')) {
            const boardId = event.target.dataset.boardId;
            const taskTitle = prompt("Enter task title:");
            if (taskTitle) {
                const cardData = new FormData();
                cardData.append('deli_id', boardId);
                cardData.append('apraksts', taskTitle);
                cardData.append('krasu_etikete', '');

                fetch('admin/izveidot_karti.php', {
                    method: 'POST',
                    body: cardData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const task = document.createElement("div");
                        task.className = "task";
                        task.dataset.cardId = data.kartis_id;
                        task.dataset.boardId = boardId;
                        task.innerHTML = `
                            <p class="task-title">${taskTitle}</p>
                            <button class="edit-card-button">Edit</button>`;
                        event.target.previousElementSibling.appendChild(task);
                    } else {
                        alert('Error creating card: ' + data.message);
                    }
                });
            }
        }

        // Open the non-editable card modal when a card is clicked
        if (event.target.classList.contains('task') && !event.target.classList.contains('edit-card-button')) {
            editCardModal.style.display = "block";
            editingCardElement = event.target;
            const cardDescription = editingCardElement.querySelector('.task-title').textContent;
            document.getElementById('cardDescription').value = cardDescription; // Populate description
            document.getElementById('fileAttachmentContainer').innerHTML = editingCardElement.querySelector('.task-file-attachment').textContent ? `<p>Attachment: ${editingCardElement.querySelector('.task-file-attachment').textContent}</p>` : ''; // Populate file attachment
            document.getElementById('commentsContainer').innerHTML = editingCardElement.querySelector('.task-comments').textContent ? `<p>Comments: ${editingCardElement.querySelector('.task-comments').textContent}</p>` : ''; // Populate comments
            document.getElementById('checklistItems').innerHTML = editingCardElement.querySelector('.task-checklist').innerHTML; // Populate checklist
            // Make fields read-only
            document.getElementById('cardDescription').readOnly = true;
            document.querySelectorAll('.color-option').forEach(option => option.style.pointerEvents = 'none');
            document.getElementById('cardFileAttachment').style.display = 'none';
            document.getElementById('cardComments').style.display = 'none';
            document.getElementById('addChecklistItem').style.display = 'none';
            document.querySelectorAll('#checklistItems li').forEach(item => item.style.pointerEvents = 'none');
            editModeButton.style.display = 'block';
            saveCardButton.style.display = 'none';
        }

        // Open the edit card modal when an edit button is clicked
        if (event.target.classList.contains('edit-card-button')) {
            editCardModal.style.display = "block";
            editingCardElement = event.target.closest('.task');
            const cardDescription = editingCardElement.querySelector('.task-title').textContent;
            document.getElementById('cardDescription').value = cardDescription; // Populate description
            document.getElementById('fileAttachmentContainer').innerHTML = editingCardElement.querySelector('.task-file-attachment').textContent ? `<p>Attachment: ${editingCardElement.querySelector('.task-file-attachment').textContent}</p>` : ''; // Populate file attachment
            document.getElementById('commentsContainer').innerHTML = editingCardElement.querySelector('.task-comments').textContent ? `<p>Comments: ${editingCardElement.querySelector('.task-comments').textContent}</p>` : ''; // Populate comments
            document.getElementById('checklistItems').innerHTML = editingCardElement.querySelector('.task-checklist').innerHTML; // Populate checklist
            // Make fields editable
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

    editCardCloseButton.onclick = function() {
        editCardModal.style.display = "none";
    }

    editModeButton.onclick = function() {
        // Switch to edit mode
        document.getElementById('cardDescription').readOnly = false;
        document.querySelectorAll('.color-option').forEach(option => option.style.pointerEvents = 'auto');
        document.getElementById('cardFileAttachment').style.display = 'block';
        document.getElementById('cardComments').style.display = 'block';
        document.getElementById('addChecklistItem').style.display = 'block';
        document.querySelectorAll('#checklistItems li').forEach(item => item.style.pointerEvents = 'auto');
        editModeButton.style.display = 'none';
        saveCardButton.style.display = 'block';
    };

    // JavaScript for handling the edit card modal interactions
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
        cardData.append('kartis_id', cardId);
        cardData.append('deli_id', boardId);
        cardData.append('apraksts', description);
        cardData.append('krasu_etikete', colorLabel);
        cardData.append('komentari', comments);
        cardData.append('faila_pievienojums', fileAttachment);
        cardData.append('checklist', JSON.stringify(checklistItems));
    
        fetch('admin/atjaunināt_karti.php', {
            method: 'POST',
            body: cardData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update the card element on the frontend
                if (editingCardElement) {
                    editingCardElement.querySelector('.task-title').textContent = description;
                    editingCardElement.style.borderTop = `4px solid ${colorLabel}`;
                    editingCardElement.dataset.colorLabel = colorLabel;
                    editingCardElement.dataset.comments = comments;
                    editingCardElement.dataset.checklist = JSON.stringify(checklistItems);
                    if (fileAttachment) {
                        editingCardElement.dataset.fileAttachment = fileAttachment.name;
                    }
                }
                editCardModal.style.display = "none";
            } else {
                alert('Error saving card details: ' + data.message);
            }
        });
    });
    

// Fetch workspaces and display them
function fetchWorkspaces() {
    fetch(`admin/datu_atrasana.php?lietotajs_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(darbtelpa => {
                const newWorkspace = document.createElement("div");
                newWorkspace.className = "workspace";
                newWorkspace.textContent = darbtelpa.nosaukums;
                newWorkspace.dataset.workspaceId = darbtelpa.darbtelpa_id;
                newWorkspace.onclick = function() {
                    selectWorkspace(darbtelpa.darbtelpa_id, darbtelpa.nosaukums);
                };

                // Create the "Add Board" button immediately
                const addBoardButton = document.createElement("button");
                addBoardButton.className = "create-board-button";
                addBoardButton.innerHTML = '<i class="fa fa-plus"></i>';
                addBoardButton.onclick = function() {
                    addBoardModal.style.display = "block";
                };
                newWorkspace.appendChild(addBoardButton);

                workspaceList.appendChild(newWorkspace);
            });
        });
}

// Initial fetch of workspaces when the page loads
fetchWorkspaces();

});







