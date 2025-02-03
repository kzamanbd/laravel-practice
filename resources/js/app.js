import './bootstrap';

document.addEventListener('livewire:init', () => {
    Livewire.on('confirm-modal', (event) => {
        const modalData = Array.isArray(event) ? event[0] : event;
        if (confirm(modalData.message || 'Are you sure?')) {
            Livewire.dispatch(modalData.action);
        }
    });
});

