import { showConfirmModal } from "../pop-ups/confirm-modal.js";

document.addEventListener("DOMContentLoaded", () => {
    // Handle Delete Borrowing
    const deleteForms = document.querySelectorAll(".delete-borrowing-form");
    deleteForms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const bookTitle =
                form.getAttribute("data-book-title") || "this borrowing";
            const memberName =
                form.getAttribute("data-member-name") || "member";

            showConfirmModal({
                title: "Delete Borrowing Record",
                message: `Are you sure you want to delete the borrowing record for "${bookTitle}" by ${memberName}? This action cannot be undone.`,
                confirmText: "Yes, Delete",
                cancelText: "Cancel",
                type: "danger",
                onConfirm: () => {
                    form.submit();
                },
            });
        });
    });

    // Handle Return Book
    const returnForms = document.querySelectorAll(".return-borrowing-form");
    returnForms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const bookTitle =
                form.getAttribute("data-book-title") || "this book";
            const memberName =
                form.getAttribute("data-member-name") || "member";
            const isOverdue = form.getAttribute("data-is-overdue") === "true";

            if (isOverdue) {
                // Overdue books - use warning (yellow) style
                showConfirmModal({
                    title: "Return Overdue Book",
                    message: `⚠️ This book is OVERDUE. Confirm return for "${bookTitle}" borrowed by ${memberName}?`,
                    confirmText: "Yes, Mark as Returned",
                    cancelText: "Cancel",
                    type: "warning",
                    onConfirm: () => {
                        form.submit();
                    },
                });
            } else {
                // Normal return - use success (green) style
                showConfirmModal({
                    title: "Confirm Book Return",
                    message: `Mark "${bookTitle}" borrowed by ${memberName} as returned?`,
                    confirmText: "Yes, Returned",
                    cancelText: "Cancel",
                    type: "success",
                    onConfirm: () => {
                        form.submit();
                    },
                });
            }
        });
    });
});
