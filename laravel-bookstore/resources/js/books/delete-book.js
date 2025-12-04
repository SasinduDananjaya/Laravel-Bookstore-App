import { showConfirmModal } from "../pop-ups/confirm-modal.js";

document.addEventListener("DOMContentLoaded", () => {
    const deleteForms = document.querySelectorAll(".delete-book-form");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const bookTitle =
                form.getAttribute("data-book-title") || "this book";

            showConfirmModal({
                title: "Delete Book",
                message: `Are you sure you want to delete "${bookTitle}"? This action cannot be undone.`,
                confirmText: "Yes, Delete",
                cancelText: "Cancel",
                onConfirm: () => {
                    form.submit();
                },
            });
        });
    });
});
