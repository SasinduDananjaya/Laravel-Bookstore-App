export function showConfirmModal(options = {}) {
    const {
        modalId = "confirmModal",
        title = "Confirm Action",
        message = "Are you sure you want to proceed?",
        confirmText = "Confirm",
        cancelText = "Cancel",
        type = "danger",
        onConfirm = () => {},
        onCancel = () => {},
    } = options;

    const modal = document.getElementById(modalId);
    const titleEl = document.getElementById(`${modalId}Title`);
    const messageEl = document.getElementById(`${modalId}Message`);
    const confirmBtn = document.getElementById(`${modalId}Confirm`);
    const cancelBtn = document.getElementById(`${modalId}Cancel`);
    const iconContainer = document.getElementById(`${modalId}IconContainer`);
    const icon = document.getElementById(`${modalId}Icon`);

    if (!modal) return;

    //set content
    if (titleEl) titleEl.textContent = title;
    if (messageEl) messageEl.textContent = message;
    if (confirmBtn) confirmBtn.textContent = confirmText;

    // reset button classes
    if (confirmBtn) {
        confirmBtn.className = "flex-1 font-bold py-2 px-4 rounded text-white";
    }

    if (type === "success") {
        //green theme for return actions
        if (iconContainer) {
            iconContainer.className =
                "mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100";
        }
        if (icon) {
            icon.className = "h-6 w-6 text-green-600";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>`;
        }
        if (confirmBtn) {
            confirmBtn.classList.add("bg-green-600", "hover:bg-green-700");
        }
    } else if (type === "warning") {
        //yellow theme for warnings
        if (iconContainer) {
            iconContainer.className =
                "mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100";
        }
        if (icon) {
            icon.className = "h-6 w-6 text-yellow-600";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>`;
        }
        if (confirmBtn) {
            confirmBtn.classList.add("bg-yellow-600", "hover:bg-yellow-700");
        }
    } else {
        //red delete actions
        if (iconContainer) {
            iconContainer.className =
                "mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100";
        }
        if (icon) {
            icon.className = "h-6 w-6 text-red-600";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>`;
        }
        if (confirmBtn) {
            confirmBtn.classList.add("bg-red-600", "hover:bg-red-700");
        }
    }

    //handle cancel button visibility
    if (cancelText === "") {
        if (cancelBtn) cancelBtn.classList.add("hidden");
        if (confirmBtn) {
            confirmBtn.classList.remove("flex-1");
            confirmBtn.classList.add("w-full");
        }
    } else {
        if (cancelBtn) {
            cancelBtn.classList.remove("hidden");
            cancelBtn.textContent = cancelText;
        }
        if (confirmBtn) {
            confirmBtn.classList.add("flex-1");
            confirmBtn.classList.remove("w-full");
        }
    }

    //show popup
    modal.classList.remove("hidden");

    //Handle confirm
    const handleConfirm = () => {
        onConfirm();
        hideModal();
    };

    const handleCancel = () => {
        onCancel();
        hideModal();
    };

    //hide modal
    const hideModal = () => {
        modal.classList.add("hidden");
        confirmBtn.removeEventListener("click", handleConfirm);
        if (cancelBtn) cancelBtn.removeEventListener("click", handleCancel);
        modal.removeEventListener("click", handleOutsideClick);
    };

    //click outside to close popup
    const handleOutsideClick = (e) => {
        if (e.target === modal) {
            handleCancel();
        }
    };

    //event listeners
    confirmBtn.addEventListener("click", handleConfirm);
    if (cancelBtn && cancelText !== "") {
        cancelBtn.addEventListener("click", handleCancel);
    }
    modal.addEventListener("click", handleOutsideClick);

    //ESC key to close
    const handleEscape = (e) => {
        if (e.key === "Escape") {
            handleCancel();
            document.removeEventListener("keydown", handleEscape);
        }
    };
    document.addEventListener("keydown", handleEscape);
}
