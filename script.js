document.addEventListener("DOMContentLoaded", function () {
    const sidePanel = document.querySelector(".side-panel");
    const mainContent = document.querySelector(".main-content");
    const closeButton = document.querySelector(".close-button");
    const searchInput = document.querySelector("input[type='search']");
    const searchButton = document.querySelector("button[type='submit']");

    // Modal loga funkcionalitāte darbvietas izveidei
    const addWorkspaceModal = document.getElementById("addWorkspaceModal");
    const createWorkspaceButton = document.getElementById("createWorkspaceButton");
    const createWorkspaceButtons = document.querySelectorAll(".create-workspace-button");
    const workspaceList = document.getElementById("workspaceList");
    let selectedWorkspaceId = null;

    // Modal loga funkcionalitāte dēļa izveidei
    const addBoardModal = document.getElementById("addBoardModal");
    const createBoardButton = document.getElementById("createBoardButton");
    let selectedBgColor = "";

    // Modal loga funkcionalitāte kartītes rediģēšanai
    const editCardModal = document.getElementById("editCardModal");
    const editCardCloseButton = document.getElementsByClassName("close")[2];
    const saveCardButton = document.getElementById("saveCardButton");
    let editingCardElement = null; // Lai izsekotu rediģēto kartīti

    // Sānu paneļa redzamības pārslēgšana
    closeButton.addEventListener("click", function () {
        if (sidePanel.style.left === "-255px" || sidePanel.style.left === "") {
            sidePanel.style.left = "0"; // Rāda sānu paneli
            mainContent.classList.add("shifted"); // Pārbīda galveno saturu
        } else {
            sidePanel.style.left = "-255px"; // Slēpj sānu paneli
            mainContent.classList.remove("shifted"); // Atgriež galveno saturu sākotnējā vietā
        }
    });

    // Darbvietas izveides pogas klikšķa apstrāde
    createWorkspaceButtons.forEach(button => {
        button.onclick = function() {
            addWorkspaceModal.style.display = "block"; // Parāda darbvietas izveides modalu
        }
    });

    // Modal loga aizvēršana
    addWorkspaceModal.querySelector('.close').onclick = function() {
        addWorkspaceModal.style.display = "none"; // Aizver darbvietas izveides modalu
    }

    // Modal loga aizvēršana
    addBoardModal.querySelector('.close').onclick = function() {
        addBoardModal.style.display = "none"; // Aizver dēļa izveides modalu
    }

    // Kartītes rediģēšanas modal loga aizvēršana
    editCardCloseButton.onclick = function() {
        editCardModal.style.display = "none"; // Aizver kartītes rediģēšanas modalu
    }

    // Modal logu aizvēršana, klikšķinot ārpus tiem
    window.onclick = function(event) {
        if (event.target == addWorkspaceModal) {
            addWorkspaceModal.style.display = "none"; // Aizver darbvietas izveides modalu
        }
        if (event.target == addBoardModal) {
            addBoardModal.style.display = "none"; // Aizver dēļa izveides modalu
        }
        if (event.target == editCardModal) {
            editCardModal.style.display = "none"; // Aizver kartītes rediģēšanas modalu
        }
    }

    // Fona izvēles iespēju apstrāde
    document.querySelectorAll(".bg-option").forEach(option => {
        option.onclick = function() {
            document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected")); // Noņem izvēli no visām opcijām
            this.classList.add("selected"); // Pievieno izvēli pašreizējai opcijai
            selectedBgColor = this.getAttribute("data-bg"); // Saglabā izvēlēto krāsu
        }
    });

    // Darbvietas izveides apstrāde
    createWorkspaceButton.onclick = function() {
        const workspaceTitle = document.getElementById("workspaceTitle").value.trim();
        if (!workspaceTitle) {
            alert("Workspace title is required"); // Brīdina, ja nav ievadīts nosaukums
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
                    selectWorkspace(data.workspace_id, workspaceTitle); // Izvēlas jaunizveidoto darbvietu
                };

                const addBoardButton = document.createElement("button");
                addBoardButton.className = "create-board-button";
                addBoardButton.innerHTML = '<i class="fa fa-plus"></i>';
                addBoardButton.onclick = function() {
                    addBoardModal.style.display = "block"; // Parāda dēļa izveides modalu
                };
                newWorkspace.appendChild(addBoardButton);

                workspaceList.appendChild(newWorkspace); // Pievieno jauno darbvietu sarakstam
                addWorkspaceModal.style.display = "none"; // Aizver darbvietas izveides modalu
                document.getElementById("workspaceTitle").value = "";
            } else {
                alert('Error creating workspace: ' + data.message); // Kļūdas paziņojums
                console.error('Error creating workspace:', data.message);
            }
        })
        .catch(error => {
            alert('Error creating workspace: ' + error.message); // Kļūdas paziņojums
            console.error('Error creating workspace:', error);
        });
    }

    // Darbvietas izvēles funkcija
    function selectWorkspace(workspaceId, workspaceTitle) {
        selectedWorkspaceId = workspaceId;
        document.querySelector(".planning-section h2").textContent = workspaceTitle;
        document.querySelector(".board-container").innerHTML = ""; // Notīra esošos dēļus

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

                    // Pievieno kartītes jaunajam dēlim
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

                    boardContainer.appendChild(newBoard); // Pievieno jauno dēli dēļu konteineram
                });
            })
            .catch(error => {
                console.error('Error fetching boards:', error); // Kļūdas paziņojums
            });
    }

    // Dēļa izveides apstrāde
    createBoardButton.onclick = function() {
        const boardTitle = document.getElementById("boardTitle").value.trim();
        if (!boardTitle) {
            alert("Board title is required"); // Brīdina, ja nav ievadīts dēļa nosaukums
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

                boardContainer.appendChild(newBoard); // Pievieno jauno dēli dēļu konteineram
                addBoardModal.style.display = "none"; // Aizver dēļa izveides modalu
                document.getElementById("boardTitle").value = "";
                document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected"));
                selectedBgColor = "";
            } else {
                alert('Error creating board: ' + data.message); // Kļūdas paziņojums
                console.error('Error creating board:', data.message);
            }
        })
        .catch(error => {
            alert('Error creating board: ' + error.message); // Kļūdas paziņojums
            console.error('Error creating board:', error);
        });
    }

    // Dokumenta klikšķu notikumu apstrāde
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
                        task.dataset.description = '';
                        task.dataset.colorLabel = '';
                        task.dataset.comments = '';
                        task.dataset.fileAttachment = '';
                        task.innerHTML = `
                            <p class="task-title">${taskTitle}</p>
                            <button class="edit-card-button">Edit</button>`;
                        event.target.previousElementSibling.appendChild(task); // Pievieno jauno uzdevumu dēlim
                    } else {
                        alert('Error creating card: ' + data.message); // Kļūdas paziņojums
                        console.error('Error creating card:', data.message);
                    }
                })
                .catch(error => {
                    alert('Error creating card: ' + error.message); // Kļūdas paziņojums
                    console.error('Error creating card:', error);
                });
            }
        }

        if (event.target.classList.contains('edit-card-button')) {
            editCardModal.style.display = "block";
            editingCardElement = event.target.closest('.task');
            const cardId = editingCardElement.dataset.cardId;
            const cardName = editingCardElement.querySelector('.task-title').textContent;
            const cardDescription = editingCardElement.dataset.description || '';
            const cardColorLabel = editingCardElement.dataset.colorLabel || '';
            const cardComments = editingCardElement.dataset.comments || '';
            const cardFileAttachment = editingCardElement.dataset.fileAttachment || '';

            document.getElementById('cardName').value = cardName;
            document.getElementById('cardDescription').value = cardDescription;
            document.getElementById('cardComments').value = cardComments;

            // Reset color options and select the appropriate one
            document.querySelectorAll('.color-option').forEach(option => {
                option.classList.remove('selected');
                if (option.dataset.color === cardColorLabel) {
                    option.classList.add('selected');
                }
            });

            // Clear file input field
            document.getElementById('cardFileAttachment').value = '';
            document.getElementById('fileAttachmentContainer').innerHTML = cardFileAttachment ? `<a href="${cardFileAttachment}" download>Download Attachment</a>` : '';
        }
    });

    // Kartītes saglabāšanas apstrāde
    saveCardButton.addEventListener('click', function() {
        var cardId = editingCardElement ? editingCardElement.dataset.cardId : null;
        var boardId = editingCardElement ? editingCardElement.dataset.boardId : null;
        var cardName = document.getElementById('cardName').value.trim();
        var description = document.getElementById('cardDescription').value.trim();
        var colorLabel = document.querySelector('.color-option.selected') ? document.querySelector('.color-option.selected').dataset.color : '';
        var comments = document.getElementById('cardComments').value.trim();
        var fileAttachment = document.getElementById('cardFileAttachment').files[0];

        if (!cardName) {
            alert('Card name is required');
            return;
        }

        var formData = new FormData();
        formData.append('id', cardId);
        formData.append('board_id', boardId);
        formData.append('name', cardName);
        formData.append('description', description);
        formData.append('color_label', colorLabel);
        formData.append('comments', comments);
        if (fileAttachment) {
            formData.append('file_attachment', fileAttachment);
        }

        fetch('admin/planing/cardSave.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the response data
            if (data.success) {
                if (editingCardElement) {
                    editingCardElement.querySelector('.task-title').textContent = cardName;
                    editingCardElement.dataset.description = description;
                    editingCardElement.dataset.colorLabel = colorLabel;
                    editingCardElement.dataset.comments = comments;
                    if (colorLabel) {
                        editingCardElement.style.backgroundColor = colorLabel;
                    }
                    if (data.file_attachment) {
                        editingCardElement.dataset.fileAttachment = data.file_attachment;
                    }
                }
                editCardModal.style.display = "none"; // Close the modal
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

    // Darbvietu datu iegūšana
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
                        selectWorkspace(workspace.id, workspace.name); // Izvēlas darbvietu
                    };

                    const addBoardButton = document.createElement("button");
                    addBoardButton.className = "create-board-button";
                    addBoardButton.innerHTML = '<i class="fa fa-plus"></i>';
                    addBoardButton.onclick = function() {
                        addBoardModal.style.display = "block"; // Parāda dēļa izveides modalu
                    };
                    newWorkspace.appendChild(addBoardButton);

                    workspaceList.appendChild(newWorkspace); // Pievieno jauno darbvietu sarakstam
                });
            })
            .catch(error => {
                console.error('Error fetching workspaces:', error); // Kļūdas paziņojums
            });
    }

    fetchWorkspaces(); // Izsauc darbvietu iegūšanas funkciju
});



