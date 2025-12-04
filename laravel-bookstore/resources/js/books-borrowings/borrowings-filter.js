function checkBorrowingFilters() {
    const inputs = document.querySelectorAll(".filter-input");
    const filterBtn = document.getElementById("borrowingsFilterBtn");
    const clearBtn = document.getElementById("clearBtn");

    if (!filterBtn) return;
    let hasValue = false;

    inputs.forEach((input) => {
        if (input.value.trim() !== "") {
            hasValue = true;
        }
    });

    if (hasValue) {
        filterBtn.disabled = false;
        filterBtn.classList.remove("opacity-50", "cursor-not-allowed");

        clearBtn.classList.remove(
            "opacity-50",
            "cursor-not-allowed",
            "pointer-events-none"
        );
    } else {
        filterBtn.disabled = true;
        filterBtn.classList.add("opacity-50", "cursor-not-allowed");

        clearBtn.classList.add(
            "opacity-50",
            "cursor-not-allowed",
            "pointer-events-none"
        );
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll(".filter-input");

    if (inputs.length > 0) {
        inputs.forEach((input) => {
            input.addEventListener("change", checkBorrowingFilters);
            input.addEventListener("input", checkBorrowingFilters);
        });
        checkBorrowingFilters();
    }
});
