document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("editBookForm");
    const updateBtn = document.getElementById("updateBookBtn");

    // Exit early if not on edit page
    if (!form || !updateBtn) return;

    // Get only user-editable fields (exclude hidden fields like _token, _method)
    const fields = Array.from(
        form.querySelectorAll(
            'input:not([type="hidden"])[name], textarea[name], select[name]'
        )
    );

    // Store original values
    const originalValues = {};
    fields.forEach((field) => {
        originalValues[field.name] = field.value;
    });

    // Check if any field has changed
    function checkForChanges() {
        let hasChanges = false;

        fields.forEach((field) => {
            const original = originalValues[field.name];
            const current = field.value;

            if (current !== original) {
                hasChanges = true;
            }
        });

        // Enable/disable button
        updateBtn.disabled = !hasChanges;

        if (hasChanges) {
            updateBtn.classList.remove("opacity-50", "cursor-not-allowed");
        } else {
            updateBtn.classList.add("opacity-50", "cursor-not-allowed");
        }
    }

    // Listen for changes
    fields.forEach((field) => {
        field.addEventListener("input", checkForChanges);
        field.addEventListener("change", checkForChanges);
    });

    // Initial check
    checkForChanges();
});
