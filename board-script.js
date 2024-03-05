const addBoardButton = document.getElementById('add-board');
const boardPanel = document.getElementById('board-panel');
const boardNameInput = document.getElementById('board-name');
const colorPicker = document.getElementById('color-picker');
const createBoardButton = document.getElementById('create-board');
const boardsContainer = document.getElementById('boards');

addBoardButton.addEventListener('click', () => {
    boardPanel.classList.remove('hidden');
});

createBoardButton.addEventListener('click', () => {
    const boardName = boardNameInput.value;
    const boardColor = colorPicker.value;

    if (boardName.trim() !== '') {
        createBoard(boardName, boardColor);
        boardNameInput.value = '';
        boardPanel.classList.add('hidden');
    }
});

function createBoard(name, color) {
    const board = document.createElement('div');
    board.classList.add('board');
    board.style.backgroundColor = color;
    board.textContent = name;

    boardsContainer.appendChild(board);
}
