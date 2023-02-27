<div id="root-progress" class="hidden w-full bg-gray-200 rounded-full h-0.5 mb-4 dark:bg-gray-700 fixed top-0 left-0">
    <div id="progress-bar" class="bg-blue-600 h-0.5 rounded-full dark:bg-blue-500"></div>
</div>

<script>
    // Assume that loading will complete under this amount of time.
    const defaultDuration = 8000;
    // How frequently to update
    const defaultInterval = 1000;
    // 0 - 1. Add some variation to how much the bar will grow at each interval
    const variation = 0.5;
    // 0 - 100. Where the progress bar should start from.
    const startingPoint = 0;
    // Limiting how far the progress bar will get to before loading is complete
    const endingPoint = 90;

    let isLoading = false; // Once loading is done, start fading away
    let isVisible = false; // Once animate finish, set display: none
    let progress = startingPoint;
    let timeoutId = undefined;

    const rootProgressElement = document.getElementById('root-progress');
    const progressBarElement = document.getElementById('progress-bar');

    function startProgress() {
        isLoading = true;
        isVisible = true;
        progress = startingPoint;
        loopProgress();
        rootProgressElement.classList.remove('hidden');
    }

    function loopProgress() {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        if (progress >= endingPoint) {
            return;
        }
        const size = (endingPoint - startingPoint) / (defaultDuration / defaultInterval);
        const p = Math.round(progress + _.random(size * (1 - variation), size * (1 + variation)));
        console.log(`p: ${p}, size: ${size}, progress: ${Math.min(p, endingPoint)}`);
        progress = Math.min(p, endingPoint);
        progressBarElement.style.width = `${progress}%`;
        timeoutId = setTimeout(
            loopProgress,
            _.random(defaultInterval * (1 - variation), defaultInterval * (1 + variation)),
        );
    }

    function stopProgress() {
        isLoading = false;
        progress = 100;
        progressBarElement.style.width = `${progress}%`;
        rootProgressElement.classList.add('hidden');
        clearTimeout(timeoutId);
        setTimeout(() => {
            if (!isLoading) {
                isVisible = false;
            }
        }, 200);
    }

    Livewire.hook('message.sent', () => {
        startProgress();
    });

    Livewire.hook('message.received', () => {
        stopProgress();
    });
</script>
