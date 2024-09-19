@props(['files' => []])

<ul class="pl-4">
    <!-- Directory Example -->
    @foreach ($files as $file)
        <li class="mb-2">
            @if ($file['type'] === 'directory')
                <div class="flex items-center">
                    <span class="mr-2">📂</span>
                    <span class="font-bold">{{ $file['name'] }}</span>
                </div>
                @if (isset($file['children']) && count($file['children']) > 0)
                    <!-- Recursively render the child elements -->
                    <x-file-tree :files="$file['children']" />
                @endif
            @else
                <div class="flex items-center">
                    <span class="mr-2">📄</span>
                    <span>{{ $file['name'] }}</span>
                </div>
            @endif
        </li>
    @endforeach
</ul>
