<li class="flex justify-end gap-x-2 sm:gap-x-4">
    <div class="grow text-end space-y-3">
        <!-- Card -->
        <div class="max-w-[90%] w-full inline-block">
            <p class="bg-white overflow-auto border border-gray-200 rounded-lg p-3">
                {{ $message['content'] }}
            </p>
        </div>
        <!-- End Card -->
    </div>

    <span class="shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-gray-600">
        <img src="{{ auth()->user()->profile_photo_url }}" alt="image" class="rounded-full size-10" />
    </span>
</li>
