import "./bootstrap";
import "./echo";
import "./editor";
import "./toast";

document.addEventListener("livewire:init", () => {
    Livewire.on("confirm-modal", (event) => {
        const modalData = Array.isArray(event) ? event[0] : event;
        console.log(modalData);
        if (confirm(modalData.message || "Are you sure?")) {
            Livewire.dispatch(modalData.action);
        }
    });
});
