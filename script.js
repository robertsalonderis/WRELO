document.addEventListener("DOMContentLoaded", function () {
    const sidePanel = document.querySelector(".side-panel");
    const mainContent = document.querySelector(".main-content");
    const closeButton = document.querySelector(".close-button");
    const searchInput = document.querySelector("input[type='search']");
    const searchButton = document.querySelector("button[type='submit']");
    const loginForm = document.getElementById("login-form");
    const createAccountForm = document.getElementById("create-account-form");
    const loginLink = document.getElementById("login-link");
    const createAccountLink = document.getElementById("create-account-link");

    // Event listener for the side panel close button
    closeButton.addEventListener("click", function () {
        if (sidePanel.style.left === "-255px" || sidePanel.style.left === "") {
            sidePanel.style.left = "0";
            mainContent.classList.add("shifted"); // Add class for moving sections
        } else {
            sidePanel.style.left = "-255px";
            mainContent.classList.remove("shifted"); // Remove class to reset position
        }
    });

    // Event listener for the search button to expand the search bar
    searchButton.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent form submission
        searchInput.classList.toggle("expanded");
    });



    // Show the login form by default and hide the create account form
    loginForm.style.display = "block";
    createAccountForm.style.display = "none";

    // Add click event listeners to toggle forms
    loginLink.addEventListener("click", function (event) {
        event.preventDefault();
        loginForm.style.display = "block";
        createAccountForm.style.display = "none";
    });

    createAccountLink.addEventListener("click", function (event) {
        event.preventDefault();
        createAccountForm.style.display = "block";
        loginForm.style.display = "none";
    });   
    
    //test commit
      
});
