function checkFilters() {
    const inputs = document.querySelectorAll(".filter-input");
    const filterBtn = document.getElementById("bookFilterBtn");
    const clearBtn = document.getElementById("clearBtn");

    if (!inputs || !filterBtn || !clearBtn) return;

    let hasValue = false;

    inputs.forEach((input) => {
        if (input.value.trim() !== "") {
            hasValue = true;
        }
    });

    // Filter Button
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
    document.querySelectorAll(".filter-input").forEach((input) => {
        input.addEventListener("input", checkFilters);
    });

    checkFilters();
});
