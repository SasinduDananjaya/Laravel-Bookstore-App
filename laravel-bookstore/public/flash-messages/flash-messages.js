class FlashMessageHandler {
    constructor(duration = 2500) {
        this.duration = duration;
        this.messages = [
            "success-message",
            "error-message",
            "warning-message",
            "info-message",
        ];
    }

    init() {
        this.messages.forEach((messageId) => {
            this.autoDismiss(messageId);
        });
    }

    autoDismiss(elementId) {
        const element = document.getElementById(elementId);

        if (element) {
            // Add slide-in animation class
            element.classList.add("alert-slide-in");

            // Set timeout for auto-dismiss
            setTimeout(() => {
                this.dismiss(element);
            }, this.duration);
        }
    }

    dismiss(element) {
        element.classList.add("fade-out");
        setTimeout(() => {
            element.remove();
        }, 500);
    }

    static manualDismiss(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.classList.add("fade-out");
            setTimeout(() => {
                element.remove();
            }, 500);
        }
    }
}

// initialize
document.addEventListener("DOMContentLoaded", function () {
    const flashHandler = new FlashMessageHandler(2500);
    flashHandler.init();
});

// Make manualDismiss available globally for inline onclick handlers
window.dismissFlashMessage = function (elementId) {
    FlashMessageHandler.manualDismiss(elementId);
};
