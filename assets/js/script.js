function supplierPopUp() {
    const editButtons = document.querySelectorAll(".button-edit");
    const addButton = document.querySelector(".button-add");
    const addPopup = document.querySelector(".popup-add");
    const editPopup = document.querySelector(".popup-edit");
    const closeButtons = document.querySelectorAll(".btn-close");

    // Event listener for "Add Supplier" button
    addButton.addEventListener("click", function () {
        addPopup.style.display = "flex"; // Show add pop-up
        editPopup.style.display = "none"; // Hide edit pop-up if open
    });

    // Event listener for "Edit" buttons
    editButtons.forEach(function (editButton) {
        editButton.addEventListener("click", function () {
            const id = editButton.getAttribute("data-id");
            const name = editButton.getAttribute("data-name");
            const email = editButton.getAttribute("data-email");
            const contact = editButton.getAttribute("data-contact");
            const address = editButton.getAttribute("data-address");

            document.getElementById("edit-id-input").value = id;
            document.getElementById("edit-name-input").value = name;
            document.getElementById("edit-email-input").value = email;
            document.getElementById("edit-contact-input").value = contact;
            document.getElementById("edit-address-input").value = address;

            editPopup.style.display = "flex"; // Show edit pop-up
            addPopup.style.display = "none"; // Hide add pop-up if open
        });
    });

    // Event listeners for close buttons
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener("click", function () {
            addPopup.style.display = "none"; // Hide add pop-up
            editPopup.style.display = "none"; // Hide edit pop-up
        });
    });

    // Close pop-up if clicked outside content area
    window.addEventListener("click", function (event) {
        if (event.target === addPopup) addPopup.style.display = "none";
        if (event.target === editPopup) editPopup.style.display = "none";
    });
}

// item
function itemPopUp() {
    const editButtons = document.querySelectorAll(".button-edit");
    const addButton = document.querySelector(".button-add");
    const addPopup = document.querySelector(".popup-add");
    const editPopup = document.querySelector(".popup-edit");
    const closeButtons = document.querySelectorAll(".btn-close");

    // Add Supplier
    addButton.addEventListener("click", function () {
        addPopup.style.display = "flex"; // Show add pop-up
        editPopup.style.display = "none"; // Hide edit pop-up if open
    });

    // Edit Supplier
    editButtons.forEach(function (editButton) {
        editButton.addEventListener("click", function () {
            const id = editButton.getAttribute("data-id");
            const name = editButton.getAttribute("data-name");
            const price = editButton.getAttribute("data-price");
            const stock = editButton.getAttribute("data-stock");
            const size = editButton.getAttribute("data-size");
            const category = editButton.getAttribute("data-category");

            document.getElementById("edit-id-input").value = id;
            document.getElementById("edit-name-input").value = name;
            document.getElementById("edit-price-input").value = price;
            document.getElementById("edit-stock-input").value = stock;
            document.getElementById("edit-size-input").value = size;
            document.getElementById("edit-category-input").value = category;
            editPopup.style.display = "flex";
        });
    });

    // Close
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener("click", function () {
            addPopup.style.display = "none";
            editPopup.style.display = "none";
        });
    });

    window.addEventListener("click", function (event) {
        if (event.target === addPopup || event.target === editPopup) {
            addPopup.style.display = "none";
            editPopup.style.display = "none";
        }
    });
}
