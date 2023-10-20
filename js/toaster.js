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
    let msg = typeof(message) == "string" ? [message]:message;
    createToast(msg, "success", "✅");
}

function showWarningToast(message) {
    let msg = typeof(message) == "string" ? [message]:message;
    createToast(msg, "warning", "⚠️");
}

function showErrorToast(message) {
    let msg = typeof(message) == "string" ? [message]:message;
    createToast(msg, "error", "❌");
}

// Example with multiple messages
function showMultipleMessages() {
    createToast(["Message 1", "Message 2", "Message 3"], "success", "✅");
}
