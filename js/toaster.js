// toaster.js
function createToast(messages, className, icon) {
    const toastContainer = document.createElement("div");
    toastContainer.className = "toaster-container";
    document.body.appendChild(toastContainer);

    for (let message of messages) {
        const toast = document.createElement("div");
        toast.className = `toaster ${className}`;
        toast.innerHTML = `<span class="icon">${icon}</span>${message}`;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = "1";
        }, 10);

        setTimeout(() => {
            toast.style.opacity = "0";
        }, 4000);

        setTimeout(() => {
            toast.remove();
        }, 4300);
    }
}

function showSuccessToast(message) {
    createToast(message, "success", "✅");
}

function showWarningToast(message) {
    createToast(message, "warning", "⚠️");
}

function showErrorToast(message) {
    createToast(message, "error", "❌");
}

// Example with multiple messages
function showMultipleMessages() {
    createToast(["Message 1", "Message 2", "Message 3"], "success", "✅");
}
