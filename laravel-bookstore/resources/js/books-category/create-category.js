document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("addBookCategoryForm");
    const createBtn = document.getElementById("createBookCategoryBtn");
    const nameInput = document.getElementById("name");

    // Exit early if not on create category page
    if (!form || !createBtn || !nameInput) return;

    function checkForm() {
        const hasValue = nameInput.value.trim() !== "";

        createBtn.disabled = !hasValue;

        if (hasValue) {
            createBtn.classList.remove("opacity-50", "cursor-not-allowed");
        } else {
            createBtn.classList.add("opacity-50", "cursor-not-allowed");
        }
    }

    // Listen for input changes
    nameInput.addEventListener("input", checkForm);

    // Initial check
    checkForm();
});
