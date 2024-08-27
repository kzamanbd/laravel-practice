<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                File Manager
            </h2>
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 ">
                <button class="bg-green-100 text-green-500 px-4 py-1.5 rounded-lg">Filter</button>
                <button class="bg-green-500 text-white px-4 py-1.5 rounded-lg">Create</button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <!-- Header Section -->
            <div class="bg-white shadow-sm rounded-lg p-4">

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <!-- Placeholder for the icon -->
                            <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M5 3L19 3C20.1 3 21 3.9 21 5V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3M5 5V19H19V5H5Z" />
                            </svg>
                        </div>
                        <div class="font-semibold">
                            <h1 class="text-lg font-bold">Settings</h1>
                            <p class="text-sm text-gray-500 space-x-2">
                                <span class="text-green-500">Laravel</span>
                                <span>|</span>
                                <span class="text-green-500">File Manager</span>
                                <span>|</span>
                                <span>2.6 GB</span>
                                <span>|</span>
                                <span>758 items</span>
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Tabs -->
                <div class="mt-4">
                    <nav class="p-2 flex space-x-4">
                        <a href="#" class="text-green-500 font-semibold">Files</a>
                        <a href="#" class="text-gray-500 ">Settings</a>
                    </nav>
                </div>
            </div>

            <!-- File Manager Main Area -->
            <div class="mt-4">
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <!-- Search and Action Buttons -->
                    <div class="flex justify-between items-center mb-4">
                        <input type="text" placeholder="Search Files & Folders"
                            class="border border-gray-100 rounded-lg p-2 w-1/3">
                        <div class="flex space-x-4">
                            <button class="bg-green-100 text-green-500 px-4 py-1.5 rounded-lg">New Folder</button>
                            <button class="bg-green-500 text-white px-4 py-1.5 rounded-lg">Upload Files</button>
                        </div>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="text-sm space-x-1 font-semibold text-gray-500 mb-4">
                        <div class="w-max py-1.5 px-2 rounded gap-2 bg-green-100 flex items-center">
                            <span class="text-green-500">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                            stroke="#22c55e" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-dasharray="4 4"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="text-green-500">Laravel</span>
                            <span>/</span>
                            <span class="text-green-500">File Manager</span>
                            <span>/</span>
                            <span class="text-green-500">Root</span>
                        </div>
                    </div>

                    <!-- File List -->
                    <div class="overflow-auto border rounded-lg">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-gray-500 uppercase text-sm border-b">
                                    <td class="py-1.5 px-3 w-10">
                                        <input type="checkbox" class="rounded">
                                    </td>
                                    <th class="py-1.5 px-3">Name</th>
                                    <th class="py-1.5 px-3">Size</th>
                                    <th class="py-1.5 px-3">Last Modified</th>
                                    <th class="py-1.5 px-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700">
                                <!-- Sample Row -->
                                <tr class="divide-y divide-gray-200">
                                    <td class="py-1.5 px-3 w-10">
                                        <input type="checkbox" class="rounded">
                                    </td>
                                    <td class="py-1.5 px-3">
                                        <div class="flex items-center">
                                            <svg class="size-5" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path opacity="0.5" d="M18 10L13 10" stroke="#22c55e"
                                                        stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path opacity="0.5"
                                                        d="M10 3H16.5C16.9644 3 17.1966 3 17.3916 3.02567C18.7378 3.2029 19.7971 4.26222 19.9743 5.60842C20 5.80337 20 6.03558 20 6.5"
                                                        stroke="#22c55e" stroke-width="1.5"></path>
                                                    <path
                                                        d="M2 6.94975C2 6.06722 2 5.62595 2.06935 5.25839C2.37464 3.64031 3.64031 2.37464 5.25839 2.06935C5.62595 2 6.06722 2 6.94975 2C7.33642 2 7.52976 2 7.71557 2.01738C8.51665 2.09229 9.27652 2.40704 9.89594 2.92051C10.0396 3.03961 10.1763 3.17633 10.4497 3.44975L11 4C11.8158 4.81578 12.2237 5.22367 12.7121 5.49543C12.9804 5.64471 13.2651 5.7626 13.5604 5.84678C14.0979 6 14.6747 6 15.8284 6H16.2021C18.8345 6 20.1506 6 21.0062 6.76946C21.0849 6.84024 21.1598 6.91514 21.2305 6.99383C22 7.84935 22 9.16554 22 11.7979V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V6.94975Z"
                                                        stroke="#22c55e" stroke-width="1.5"></path>
                                                </g>
                                            </svg>

                                            <span class="mx-2">Accounts</span>
                                        </div>
                                    </td>
                                    <td class="py-1.5 px-3">489 KB</td>
                                    <td class="py-1.5 px-3">21 Feb 2024, 11:05 am</td>
                                    <td class="py-1.5 px-3 text-center">
                                        <button class="text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots-vertical"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                            </svg>
                                        </button>
                                        <!-- Add more buttons as necessary -->
                                    </td>
                                </tr>
                                <!-- Repeat above block for each directory/file -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
