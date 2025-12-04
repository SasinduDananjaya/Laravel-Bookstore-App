import { showConfirmModal } from "../pop-ups/confirm-modal.js";

document.addEventListener("DOMContentLoaded", () => {
    const deleteForms = document.querySelectorAll(".delete-category-form");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const categoryName =
                form.getAttribute("data-category-name") || "this category";
            const booksCount = form.getAttribute("data-books-count") || "0";

            // Check if category has books
            if (parseInt(booksCount) > 0) {
                showConfirmModal({
                    title: "Cannot Delete Category",
                    message: `"${categoryName}" has ${booksCount} book(s) associated with it. Please reassign or delete those books first.`,
                    confirmText: "OK",
                    cancelText: "",
                    onConfirm: () => {
                        // Just close the modal, don't delete
                    },
                });
            } else {
                showConfirmModal({
                    title: "Delete Category",
                    message: `Are you sure you want to delete "${categoryName}"? This action cannot be undone.`,
                    confirmText: "Yes, Delete",
                    cancelText: "Cancel",
                    onConfirm: () => {
                        form.submit();
                    },
                });
            }
        });
    });
});
