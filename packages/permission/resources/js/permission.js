import "./bootstrap";
import Toastify from "toastify-js";

window.Toastify = Toastify;

document.addEventListener("livewire:init", () => {
    window.Livewire.on("confirm-modal", (event) => {
        const modalData = Array.isArray(event) ? event[0] : event;
        if (confirm(modalData.message || "Are you sure?")) {
            window.Livewire.dispatch(modalData.action);
        }
    });
});

const toast = (message, type = "success") => {
    const types = {
        success: "#10B981", error: "#EF4444", warning: "#F59E0B", info: "#3B82F6",
    };

    Toastify({
        text: message || "An error occurred",
        duration: 3000,
        newWindow: true,
        className: `toast-${type}`,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: types[type],
        },
    }).showToast();
};

const getMessage = (event) => {
    return event.detail.message || event.detail[0] || "An error occurred";
};
document.addEventListener("success", function (event) {
    toast(getMessage(event), "success");
});

document.addEventListener("warning", function (event) {
    toast(getMessage(event), "warning");
});

document.addEventListener("info", function (event) {
    toast(getMessage(event), "info");
});

document.addEventListener("error", function (event) {
    toast(getMessage(event), "error");
});
