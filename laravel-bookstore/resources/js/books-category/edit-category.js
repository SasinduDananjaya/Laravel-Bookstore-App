document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("editBookCategoryForm");
    const updateBtn = document.getElementById("updateBookCategoryBtn");
    const nameInput = document.getElementById("name");

    // Exit early if not on edit category page
    if (!form || !updateBtn || !nameInput) return;

    // Store original value
    const originalValue = nameInput.value;

    function checkForChanges() {
        const currentValue = nameInput.value.trim();
        const hasChanged = currentValue !== originalValue;
        const hasValue = currentValue !== "";

        // Enable only if changed AND not empty
        const shouldEnable = hasChanged && hasValue;

        updateBtn.disabled = !shouldEnable;

        if (shouldEnable) {
            updateBtn.classList.remove("opacity-50", "cursor-not-allowed");
        } else {
            updateBtn.classList.add("opacity-50", "cursor-not-allowed");
        }
    }

    // Listen for input changes
    nameInput.addEventListener("input", checkForChanges);

    // Initial check
    checkForChanges();
});
