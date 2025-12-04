document.addEventListener("DOMContentLoaded", function () {
    const requiredFields = [
        document.getElementById("title"),
        document.getElementById("author"),
        document.getElementById("book_category_id"),
        document.getElementById("price"),
        document.getElementById("stock"),
    ];

    const createBtn = document.getElementById("createBookBtn");

    if (!createBtn) return;

    function checkForm() {
        const allFilled = requiredFields.every(
            (field) => field.value.trim() !== ""
        );
        createBtn.disabled = !allFilled;

        createBtn.classList.toggle("opacity-50", !allFilled);
        createBtn.classList.toggle("cursor-not-allowed", !allFilled);
    }

    requiredFields.forEach((field) => {
        field.addEventListener("input", checkForm);
        field.addEventListener("change", checkForm);
    });

    checkForm();
});
