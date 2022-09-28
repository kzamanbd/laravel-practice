<script src="{{ asset('plugins/snackbar/snackbar.min.js') }}"></script>
<script type="text/javascript">
    window.addEventListener('alert', ({
        detail: {
            type,
            message
        }
    }) => {
        const options = {
            text: message,
            pos: 'bottom-right',
            showAction: true,
            actionText: 'Dismiss',
            actionTextColor: '#fff',
            textColor: '#fff',
            duration: 3000,
            onActionClick: function(element) {
                element.style.opacity = 0;
            }
        }
        if (type == 'success') {
            options.backgroundColor = '#28AB55'
        } else if (type == 'error') {
            options.backgroundColor = '#F3616D'
        } else if (type == 'warning') {
            options.backgroundColor = '#EACA4A'
        } else if (type == 'info') {
            options.backgroundColor = '#56B6F7'
        }
        Snackbar.show(options);
    })
</script>
