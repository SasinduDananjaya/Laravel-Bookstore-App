document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("issueBorrowingBookForm");
    const issueBtn = document.getElementById("issueBookBtn");

    // Exit early if not on create borrowing page
    if (!form || !issueBtn) return;

    // Get required fields (excluding notes)
    const requiredFields = [
        document.getElementById("book_id"),
        document.getElementById("user_id"),
        document.getElementById("issue_date"),
        document.getElementById("due_date"),
    ];

    // Check if all required fields exist
    if (requiredFields.some((field) => !field)) return;

    function checkForm() {
        const allFilled = requiredFields.every(
            (field) => field.value.trim() !== ""
        );

        issueBtn.disabled = !allFilled;

        if (allFilled) {
            issueBtn.classList.remove("opacity-50", "cursor-not-allowed");
        } else {
            issueBtn.classList.add("opacity-50", "cursor-not-allowed");
        }
    }

    // Listen for changes on required fields
    requiredFields.forEach((field) => {
        field.addEventListener("input", checkForm);
        field.addEventListener("change", checkForm);
    });

    // Initial check
    checkForm();
});
