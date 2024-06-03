document.addEventListener("DOMContentLoaded", function () {
    const sidePanel = document.querySelector(".side-panel");
    const mainContent = document.querySelector(".main-content");
    const closeButton = document.querySelector(".close-button");
    const searchInput = document.querySelector("input[type='search']");
    const searchButton = document.querySelector("button[type='submit']");
    const userId = 1; // Replace with the logged-in user ID

    // Modal functionality for creating a board
    const addBoardModal = document.getElementById("addBoardModal");
    const createBoardButtons = document.querySelectorAll(".create-board-button");
    const addBoardCloseButton = document.getElementsByClassName("close")[0];
    const createBoardButton = document.getElementById("createBoardButton");
    let selectedBgColor = "";

    // Modal functionality for editing a card
    const editCardModal = document.getElementById("editCardModal");
    const editCardCloseButton = document.getElementsByClassName("close")[1];
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

    createBoardButtons.forEach(button => {
        button.onclick = function() {
            addBoardModal.style.display = "block";
        }
    });

    addBoardCloseButton.onclick = function() {
        addBoardModal.style.display = "none";
    }

    window.onclick = function(event) {
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

    createBoardButton.onclick = function() {
        const boardTitle = document.getElementById("boardTitle").value.trim();
        if (!boardTitle) {
            alert("Board title is required");
            return;
        }

        const boardData = new FormData();
        boardData.append('lietotajs_id', userId);
        boardData.append('nosaukums', boardTitle);
        boardData.append('bg_krasa', selectedBgColor);

        fetch('deli.php', {
            method: 'POST',
            body: boardData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const boardContainer = document.querySelector(".planning-section .board-container");
                const newBoard = document.createElement("div");
                newBoard.className = "board";
                newBoard.style.backgroundColor = selectedBgColor;
                newBoard.innerHTML = `<h3>${boardTitle}</h3><div class="tasks"></div><div class="add-card" data-board-id="${data.board_id}">+ Add a card</div>`;
                
                boardContainer.appendChild(newBoard);
            } else {
                alert('Error creating board: ' + data.message);
            }
            addBoardModal.style.display = "none";
            document.getElementById("boardTitle").value = "";
            document.querySelectorAll(".bg-option").forEach(opt => opt.classList.remove("selected"));
            selectedBgColor = "";
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

                fetch('kartis.php', {
                    method: 'POST',
                    body: cardData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
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
                    }
                });
            }
        }

        // Open the edit card modal when an edit button is clicked
        if (event.target.classList.contains('edit-card-button')) {
            editCardModal.style.display = "block";
            // Prepopulate the modal fields with existing card data if necessary
            editingCardElement = event.target.closest('.task');
            const cardTitle = editingCardElement.querySelector('.task-title').textContent;
            document.getElementById('cardDescription').value = cardTitle; // Example, you can add more fields as needed
            // Reset color options
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
        }
    });

    editCardCloseButton.onclick = function() {
        editCardModal.style.display = "none";
    }

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
            newItem.textContent = newItemText;
            checklistContainer.appendChild(newItem);
            document.getElementById('newChecklistItem').value = '';
        }
    });

    document.getElementById('saveCardButton').addEventListener('click', function() {
        var description = document.getElementById('cardDescription').value;
        var cardId = editingCardElement ? editingCardElement.dataset.cardId : null;
        var boardId = editingCardElement ? editingCardElement.dataset.boardId : null;
        var checklistItems = [];
        checklistContainer.querySelectorAll('li').forEach(function(item) {
            checklistItems.push({ text: item.textContent, is_checked: false });
        });

        // Save card details
        var cardData = new FormData();
        cardData.append('apraksts', description);
        cardData.append('krasu_etikete', selectedColor);
        cardData.append('kartis_id', cardId);
        cardData.append('deli_id', boardId);

        fetch('kartis.php', {
            method: 'POST',
            body: cardData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update the card element on the frontend
                if (editingCardElement) {
                    editingCardElement.querySelector('.task-title').textContent = description;
                    editingCardElement.style.borderTop = `4px solid ${selectedColor}`;
                }
            } else {
                alert('Error saving card details: ' + data.message);
            }
        });

        // Save checklist items
        checklistItems.forEach(item => {
            var checklistData = new FormData();
            checklistData.append('kartis_id', cardId);
            checklistData.append('sar_teksts', item.text);
            checklistData.append('ir_atzimets', item.is_checked ? 1 : 0);

            fetch('saraksts.php', {
                method: 'POST',
                body: checklistData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'success') {
                    alert('Error saving checklist items: ' + data.message);
                }
            });
        });

        // Close the modal after saving
        editCardModal.style.display = "none";
    });
});







