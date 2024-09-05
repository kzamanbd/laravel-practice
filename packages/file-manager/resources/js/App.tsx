function App() {
    return (
        <div>
            <header className="bg-white dark:bg-gray-800 shadow">
                <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between">
                        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            File Manager
                        </h2>

                        <div className="flex justify-end space-x-4 ">
                            <button className="bg-primary-100 text-primary-500 px-4 py-1.5 rounded-lg">
                                Filter
                            </button>
                            <button className="bg-primary-500 text-white px-4 py-1.5 rounded-lg">
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div className="py-6">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                    <div className="bg-white shadow-sm rounded-lg p-4">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center space-x-4">
                                <div className="bg-primary-100 p-3 rounded-full">
                                    <svg
                                        className="h-6 w-6 text-primary-500"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M5 3L19 3C20.1 3 21 3.9 21 5V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3M5 5V19H19V5H5Z" />
                                    </svg>
                                </div>
                                <div className="font-semibold">
                                    <h1 className="text-lg font-bold">File Manager</h1>
                                    <p className="text-sm text-gray-500 space-x-2">
                                        <span className="text-primary-500">Laravel</span>
                                        <span>|</span>
                                        <span className="text-primary-500">File Manager</span>
                                        <span>|</span>
                                        <span>2.6 GB</span>
                                        <span>|</span>
                                        <span>758 items</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div className="mt-4">
                            <nav className="p-2 flex space-x-4">
                                <a href="#" className="text-primary-500 font-semibold">
                                    Files
                                </a>
                                <a href="#" className="text-gray-500 ">
                                    Settings
                                </a>
                            </nav>
                        </div>
                    </div>

                    <div className="bg-white shadow-sm rounded-lg">
                        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4">
                            <div className="flex justify-between border-r p-4">
                                <div className="flex items-center gap-4">
                                    <div className="flex size-10 items-center justify-center rounded-lg bg-[#9B51E0]/[0.08]">
                                        <svg
                                            width="31"
                                            height="31"
                                            viewBox="0 0 31 31"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M5.01313 5.3272C4.76381 5.3272 4.52469 5.42625 4.34839 5.60254C4.17209 5.77884 4.07305 6.01796 4.07305 6.26728V23.8154C4.07305 24.0648 4.17209 24.3039 4.34839 24.4802C4.52469 24.6565 4.76381 24.7555 5.01313 24.7555H25.0682C25.3175 24.7555 25.5566 24.6565 25.7329 24.4802C25.9092 24.3039 26.0082 24.0648 26.0082 23.8154V10.0276C26.0082 9.77828 25.9092 9.53916 25.7329 9.36286C25.5566 9.18656 25.3175 9.08752 25.0682 9.08752H13.7872C13.2633 9.08752 12.7741 8.82571 12.4835 8.38983L10.4418 5.3272H5.01313ZM2.13261 3.38676C2.89657 2.62279 3.93272 2.1936 5.01313 2.1936H11.2803C11.8042 2.1936 12.2934 2.45542 12.584 2.8913L14.6257 5.95392H25.0682C26.1486 5.95392 27.1847 6.38311 27.9487 7.14707C28.7126 7.91104 29.1418 8.94719 29.1418 10.0276V23.8154C29.1418 24.8958 28.7126 25.932 27.9487 26.696C27.1847 27.4599 26.1486 27.8891 25.0682 27.8891H5.01313C3.93272 27.8891 2.89657 27.4599 2.13261 26.696C1.36864 25.932 0.939453 24.8958 0.939453 23.8154V6.26728C0.939453 5.18688 1.36864 4.15072 2.13261 3.38676Z"
                                                fill="#9B51E0"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p className="text-lg font-medium text-[#9B51E0]">Design</p>
                                        <span className="font-medium">17 files</span>
                                    </div>
                                </div>
                                <div>
                                    <p className="mt-1.5 font-medium text-black dark:text-white">
                                        459 MB
                                    </p>
                                </div>
                            </div>
                            <div className="flex justify-between border-r p-4">
                                <div className="flex items-center gap-4">
                                    <div className="flex size-10 items-center justify-center rounded-lg bg-[#219653]/[0.08]">
                                        <svg
                                            width="31"
                                            height="31"
                                            viewBox="0 0 31 31"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M6.84516 5.3272C6.32597 5.3272 5.90508 5.74809 5.90508 6.26728V23.8154C5.90508 24.3346 6.32597 24.7555 6.84516 24.7555H24.3933C24.9125 24.7555 25.3334 24.3346 25.3334 23.8154V6.26728C25.3334 5.74809 24.9125 5.3272 24.3933 5.3272H6.84516ZM2.77148 6.26728C2.77148 4.01745 4.59533 2.1936 6.84516 2.1936H24.3933C26.6431 2.1936 28.467 4.01745 28.467 6.26728V23.8154C28.467 26.0653 26.6431 27.8891 24.3933 27.8891H6.84516C4.59533 27.8891 2.77148 26.0653 2.77148 23.8154V6.26728Z"
                                                fill="#219653"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M11.2323 9.71414C10.7132 9.71414 10.2923 10.135 10.2923 10.6542C10.2923 11.1734 10.7132 11.5943 11.2323 11.5943C11.7515 11.5943 12.1724 11.1734 12.1724 10.6542C12.1724 10.135 11.7515 9.71414 11.2323 9.71414ZM8.41211 10.6542C8.41211 9.09665 9.67477 7.83398 11.2323 7.83398C12.7899 7.83398 14.0526 9.09665 14.0526 10.6542C14.0526 12.2118 12.7899 13.4745 11.2323 13.4745C9.67477 13.4745 8.41211 12.2118 8.41211 10.6542Z"
                                                fill="#219653"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M19.528 11.4264C20.1399 10.8146 21.1319 10.8146 21.7438 11.4264L28.011 17.6936C28.6228 18.3055 28.6228 19.2975 28.011 19.9094C27.3991 20.5213 26.4071 20.5213 25.7952 19.9094L20.6359 14.7501L7.95594 27.4301C7.34407 28.0419 6.35203 28.0419 5.74015 27.4301C5.12828 26.8182 5.12828 25.8261 5.74015 25.2143L19.528 11.4264Z"
                                                fill="#219653"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p className="text-lg font-medium text-primary-500">
                                            Image
                                        </p>
                                        <span className="font-medium">12 files</span>
                                    </div>
                                </div>
                                <div>
                                    <p className="mt-1.5 font-medium text-black dark:text-white">
                                        120 MB
                                    </p>
                                </div>
                            </div>
                            <div className="flex justify-between border-r p-4">
                                <div className="flex items-center gap-4">
                                    <div className="flex size-10 items-center justify-center rounded-lg bg-[#2F80ED]/[0.08]">
                                        <svg
                                            width="31"
                                            height="31"
                                            viewBox="0 0 31 31"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M27.9372 2.56492C28.2886 2.86261 28.4913 3.29985 28.4913 3.76041V20.0551C28.4913 20.9204 27.7898 21.6219 26.9245 21.6219C26.0592 21.6219 25.3577 20.9204 25.3577 20.0551V5.60996L13.45 7.59457V22.562C13.45 23.4273 12.7485 24.1288 11.8832 24.1288C11.0179 24.1288 10.3164 23.4273 10.3164 22.562V6.26729C10.3164 5.50138 10.8701 4.84773 11.6256 4.72181L26.6669 2.21493C27.1212 2.13922 27.5858 2.26722 27.9372 2.56492Z"
                                                fill="#2F80ED"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M8.12204 20.3685C6.91059 20.3685 5.92852 21.3505 5.92852 22.562C5.92852 23.7734 6.91059 24.7555 8.12204 24.7555C9.33349 24.7555 10.3156 23.7734 10.3156 22.562C10.3156 21.3505 9.33349 20.3685 8.12204 20.3685ZM2.79492 22.562C2.79492 19.6199 5.17995 17.2349 8.12204 17.2349C11.0641 17.2349 13.4492 19.6199 13.4492 22.562C13.4492 25.5041 11.0641 27.8891 8.12204 27.8891C5.17995 27.8891 2.79492 25.5041 2.79492 22.562Z"
                                                fill="#2F80ED"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M23.1631 17.8615C21.9516 17.8615 20.9695 18.8436 20.9695 20.055C20.9695 21.2665 21.9516 22.2485 23.1631 22.2485C24.3745 22.2485 25.3566 21.2665 25.3566 20.055C25.3566 18.8436 24.3745 17.8615 23.1631 17.8615ZM17.8359 20.055C17.8359 17.1129 20.221 14.7279 23.1631 14.7279C26.1051 14.7279 28.4902 17.1129 28.4902 20.055C28.4902 22.9971 26.1051 25.3821 23.1631 25.3821C20.221 25.3821 17.8359 22.9971 17.8359 20.055Z"
                                                fill="#2F80ED"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p className="text-lg font-medium text-[#2F80ED]">Music</p>
                                        <span className="font-medium">39 files</span>
                                    </div>
                                </div>
                                <div>
                                    <p className="mt-1.5 font-medium text-black dark:text-white">
                                        374 MB
                                    </p>
                                </div>
                            </div>
                            <div className="flex justify-between p-4">
                                <div className="flex items-center gap-4">
                                    <div className="flex size-10 items-center justify-center rounded-lg bg-[#F2994A]/[0.08]">
                                        <svg
                                            width="31"
                                            height="31"
                                            viewBox="0 0 31 31"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M5.27128 2.13334C6.03524 1.36938 7.0714 0.940186 8.1518 0.940186H18.1793C18.5949 0.940186 18.9934 1.10526 19.2872 1.39909L26.8078 8.91973C27.1017 9.21356 27.2668 9.61208 27.2668 10.0276V25.0689C27.2668 26.1493 26.8376 27.1855 26.0736 27.9494C25.3096 28.7134 24.2735 29.1426 23.1931 29.1426H8.1518C7.0714 29.1426 6.03524 28.7134 5.27128 27.9494C4.50731 27.1855 4.07812 26.1493 4.07812 25.0689V5.01386C4.07812 3.93346 4.50731 2.8973 5.27128 2.13334ZM8.1518 4.07378C7.90248 4.07378 7.66337 4.17283 7.48707 4.34913C7.31077 4.52543 7.21172 4.76454 7.21172 5.01386V25.0689C7.21172 25.3182 7.31077 25.5573 7.48707 25.7336C7.66337 25.9099 7.90248 26.009 8.1518 26.009H23.1931C23.4424 26.009 23.6815 25.9099 23.8578 25.7336C24.0341 25.5573 24.1332 25.3182 24.1332 25.0689V10.6766L17.5303 4.07378H8.1518Z"
                                                fill="#F2994A"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M18.1801 0.940186C19.0454 0.940186 19.7469 1.64167 19.7469 2.50698V8.46082H25.7007C26.566 8.46082 27.2675 9.1623 27.2675 10.0276C27.2675 10.8929 26.566 11.5944 25.7007 11.5944H18.1801C17.3148 11.5944 16.6133 10.8929 16.6133 10.0276V2.50698C16.6133 1.64167 17.3148 0.940186 18.1801 0.940186Z"
                                                fill="#F2994A"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M9.0918 16.2947C9.0918 15.4294 9.79328 14.7279 10.6586 14.7279H20.6861C21.5514 14.7279 22.2529 15.4294 22.2529 16.2947C22.2529 17.16 21.5514 17.8615 20.6861 17.8615H10.6586C9.79328 17.8615 9.0918 17.16 9.0918 16.2947Z"
                                                fill="#F2994A"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M9.0918 21.3085C9.0918 20.4432 9.79328 19.7417 10.6586 19.7417H20.6861C21.5514 19.7417 22.2529 20.4432 22.2529 21.3085C22.2529 22.1738 21.5514 22.8753 20.6861 22.8753H10.6586C9.79328 22.8753 9.0918 22.1738 9.0918 21.3085Z"
                                                fill="#F2994A"></path>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M9.0918 11.281C9.0918 10.4157 9.79328 9.71423 10.6586 9.71423H13.1655C14.0308 9.71423 14.7323 10.4157 14.7323 11.281C14.7323 12.1464 14.0308 12.8478 13.1655 12.8478H10.6586C9.79328 12.8478 9.0918 12.1464 9.0918 11.281Z"
                                                fill="#F2994A"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p className="text-lg font-medium text-[#F2994A]">Docs</p>
                                        <span className="font-medium">78 files</span>
                                    </div>
                                </div>
                                <div>
                                    <p className="mt-1.5 font-medium text-black dark:text-white">
                                        237 MB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* <!-- File Manager Main Area --> */}
                    <div className="bg-white shadow-sm rounded-lg p-4">
                        {/* <!-- Search and Action Buttons --> */}
                        <div className="flex justify-between items-center mb-4">
                            <input
                                type="text"
                                placeholder="Search Files & Folders"
                                className="border border-gray-100 rounded-lg p-2 w-1/3"
                            />
                            <div className="flex space-x-4">
                                <button className="flex items-center gap-2 bg-primary-100 text-primary-500 px-4 py-1.5 rounded-lg">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        className="bi bi-cloud-arrow-up"
                                        viewBox="0 0 16 16">
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"
                                        />
                                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                    </svg>
                                    <span>New Folder</span>
                                </button>
                                <button className="flex items-center gap-2 bg-primary-500 text-white px-4 py-1.5 rounded-lg">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        className="bi bi-cloud-arrow-up"
                                        viewBox="0 0 16 16">
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"
                                        />
                                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                    </svg>
                                    <span>Upload Files</span>
                                </button>
                            </div>
                        </div>

                        {/* <!-- Breadcrumb --> */}
                        <div className="text-sm flex items-center justify-between font-semibold text-gray-500 mb-4">
                            <div className="w-max py-1 px-2 rounded-lg gap-2 bg-primary-100 flex items-center">
                                <span className="text-primary-500">
                                    <svg
                                        className="size-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g
                                            id="SVGRepo_tracerCarrier"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                                stroke="#22c55e"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-dasharray="4 4"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span className="text-primary-500">Laravel</span>
                                <span>/</span>
                                <span className="text-primary-500">File Manager</span>
                                <span>/</span>
                                <span>Root</span>
                            </div>
                            <span className="rounded bg-primary-500 text-white p-1">485 items</span>
                        </div>

                        {/* <!-- File List --> */}
                        <div className="overflow-auto grid grid-cols-7 border rounded-lg">
                            <div className="col-span-2">
                                <ul className="p-4">
                                    {/* <!-- Directory Example --> */}
                                    <li className="mb-2">
                                        <div className="flex items-center">
                                            <span className="mr-2">📂</span>
                                            <span className="font-bold">app</span>
                                        </div>
                                        <ul className="pl-4">
                                            <li className="mb-2">
                                                <div className="flex items-center">
                                                    <span className="mr-2">📂</span>
                                                    <span className="font-bold">Http</span>
                                                </div>
                                                <ul className="pl-4">
                                                    <li>
                                                        <div className="flex items-center">
                                                            <span className="mr-2">📄</span>
                                                            <span>Kernel.php</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div className="flex items-center">
                                                            <span className="mr-2">📄</span>
                                                            <span>Controller.php</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li className="mb-2">
                                                <div className="flex items-center">
                                                    <span className="mr-2">📂</span>
                                                    <span className="font-bold">Models</span>
                                                </div>
                                                <ul className="pl-4">
                                                    <li>
                                                        <div className="flex items-center">
                                                            <span className="mr-2">📄</span>
                                                            <span>User.php</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    {/* <!-- Another Directory Example --> */}
                                    <li className="mb-2">
                                        <div className="flex items-center">
                                            <span className="mr-2">📂</span>
                                            <span className="font-bold">config</span>
                                        </div>
                                        <ul className="pl-4">
                                            <li>
                                                <div className="flex items-center">
                                                    <span className="mr-2">📄</span>
                                                    <span>app.php</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div className="flex items-center">
                                                    <span className="mr-2">📄</span>
                                                    <span>database.php</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                    {/* <!-- File at Root Level --> */}
                                    <li>
                                        <div className="flex items-center">
                                            <span className="mr-2">📄</span>
                                            <span>README.md</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div className="col-span-5 border-l">
                                <table className="w-full text-left">
                                    <thead>
                                        <tr className="text-gray-500 uppercase text-sm border-b">
                                            <td className="py-1.5 px-3 w-10">
                                                <input type="checkbox" className="rounded" />
                                            </td>
                                            <th className="py-1.5 px-3">Name</th>
                                            <th className="py-1.5 px-3">Size</th>
                                            <th className="py-1.5 px-3">Last Modified</th>
                                            <th className="py-1.5 px-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody className="text-sm text-gray-700">
                                        {/* <!-- Sample Row --> */}
                                        <tr className="divide-y divide-gray-200">
                                            <td className="py-1.5 px-3 w-10">
                                                <input type="checkbox" className="rounded" />
                                            </td>
                                            <td className="py-1.5 px-3">
                                                <div className="flex items-center">
                                                    <svg
                                                        className="size-5"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g
                                                            id="SVGRepo_bgCarrier"
                                                            stroke-width="0"></g>
                                                        <g
                                                            id="SVGRepo_tracerCarrier"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                opacity="0.5"
                                                                d="M18 10L13 10"
                                                                stroke="#22c55e"
                                                                stroke-width="1.5"
                                                                stroke-linecap="round"></path>
                                                            <path
                                                                opacity="0.5"
                                                                d="M10 3H16.5C16.9644 3 17.1966 3 17.3916 3.02567C18.7378 3.2029 19.7971 4.26222 19.9743 5.60842C20 5.80337 20 6.03558 20 6.5"
                                                                stroke="#22c55e"
                                                                stroke-width="1.5"></path>
                                                            <path
                                                                d="M2 6.94975C2 6.06722 2 5.62595 2.06935 5.25839C2.37464 3.64031 3.64031 2.37464 5.25839 2.06935C5.62595 2 6.06722 2 6.94975 2C7.33642 2 7.52976 2 7.71557 2.01738C8.51665 2.09229 9.27652 2.40704 9.89594 2.92051C10.0396 3.03961 10.1763 3.17633 10.4497 3.44975L11 4C11.8158 4.81578 12.2237 5.22367 12.7121 5.49543C12.9804 5.64471 13.2651 5.7626 13.5604 5.84678C14.0979 6 14.6747 6 15.8284 6H16.2021C18.8345 6 20.1506 6 21.0062 6.76946C21.0849 6.84024 21.1598 6.91514 21.2305 6.99383C22 7.84935 22 9.16554 22 11.7979V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V6.94975Z"
                                                                stroke="#22c55e"
                                                                stroke-width="1.5"></path>
                                                        </g>
                                                    </svg>

                                                    <span className="mx-2">Accounts</span>
                                                </div>
                                            </td>
                                            <td className="py-1.5 px-3">489 KB</td>
                                            <td className="py-1.5 px-3">21 Feb 2024, 11:05 am</td>
                                            <td className="py-1.5 px-3 text-center">
                                                <button className="text-gray-500 hover:text-gray-700">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="16"
                                                        height="16"
                                                        fill="currentColor"
                                                        className="bi bi-three-dots-vertical"
                                                        viewBox="0 0 16 16">
                                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                    </svg>
                                                </button>
                                                {/* <!-- Add more buttons as necessary --> */}
                                            </td>
                                        </tr>
                                        {/* <!-- Repeat above block for each directory/file --> */}
                                        <tr className="divide-y divide-gray-200">
                                            <td className="py-1.5 px-3 w-10">
                                                <input type="checkbox" className="rounded" />
                                            </td>
                                            <td className="py-1.5 px-3">
                                                <div className="flex items-center">
                                                    <svg
                                                        className="size-5"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g
                                                            id="SVGRepo_bgCarrier"
                                                            stroke-width="0"></g>
                                                        <g
                                                            id="SVGRepo_tracerCarrier"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M15.3929 4.05365L14.8912 4.61112L15.3929 4.05365ZM19.3517 7.61654L18.85 8.17402L19.3517 7.61654ZM21.654 10.1541L20.9689 10.4592V10.4592L21.654 10.1541ZM3.17157 20.8284L3.7019 20.2981H3.7019L3.17157 20.8284ZM20.8284 20.8284L20.2981 20.2981L20.2981 20.2981L20.8284 20.8284ZM14 21.25H10V22.75H14V21.25ZM2.75 14V10H1.25V14H2.75ZM21.25 13.5629V14H22.75V13.5629H21.25ZM14.8912 4.61112L18.85 8.17402L19.8534 7.05907L15.8947 3.49618L14.8912 4.61112ZM22.75 13.5629C22.75 11.8745 22.7651 10.8055 22.3391 9.84897L20.9689 10.4592C21.2349 11.0565 21.25 11.742 21.25 13.5629H22.75ZM18.85 8.17402C20.2034 9.3921 20.7029 9.86199 20.9689 10.4592L22.3391 9.84897C21.9131 8.89241 21.1084 8.18853 19.8534 7.05907L18.85 8.17402ZM10.0298 2.75C11.6116 2.75 12.2085 2.76158 12.7405 2.96573L13.2779 1.5653C12.4261 1.23842 11.498 1.25 10.0298 1.25V2.75ZM15.8947 3.49618C14.8087 2.51878 14.1297 1.89214 13.2779 1.5653L12.7405 2.96573C13.2727 3.16993 13.7215 3.55836 14.8912 4.61112L15.8947 3.49618ZM10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981L2.64124 21.3588C3.38961 22.1071 4.33855 22.4392 5.51098 22.5969C6.66182 22.7516 8.13558 22.75 10 22.75V21.25ZM1.25 14C1.25 15.8644 1.24841 17.3382 1.40313 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588L3.7019 20.2981C3.27869 19.8749 3.02502 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14H1.25ZM14 22.75C15.8644 22.75 17.3382 22.7516 18.489 22.5969C19.6614 22.4392 20.6104 22.1071 21.3588 21.3588L20.2981 20.2981C19.8749 20.7213 19.2952 20.975 18.2892 21.1102C17.2615 21.2484 15.9068 21.25 14 21.25V22.75ZM21.25 14C21.25 15.9068 21.2484 17.2615 21.1102 18.2892C20.975 19.2952 20.7213 19.8749 20.2981 20.2981L21.3588 21.3588C22.1071 20.6104 22.4392 19.6614 22.5969 18.489C22.7516 17.3382 22.75 15.8644 22.75 14H21.25ZM2.75 10C2.75 8.09318 2.75159 6.73851 2.88976 5.71085C3.02502 4.70476 3.27869 4.12511 3.7019 3.7019L2.64124 2.64124C1.89288 3.38961 1.56076 4.33855 1.40313 5.51098C1.24841 6.66182 1.25 8.13558 1.25 10H2.75ZM10.0298 1.25C8.15538 1.25 6.67442 1.24842 5.51887 1.40307C4.34232 1.56054 3.39019 1.8923 2.64124 2.64124L3.7019 3.7019C4.12453 3.27928 4.70596 3.02525 5.71785 2.88982C6.75075 2.75158 8.11311 2.75 10.0298 2.75V1.25Z"
                                                                fill="#22c55e"></path>
                                                            <path
                                                                opacity="0.5"
                                                                d="M13 2.5V5C13 7.35702 13 8.53553 13.7322 9.26777C14.4645 10 15.643 10 18 10H22"
                                                                stroke="#22c55e"
                                                                stroke-width="1.5"></path>
                                                            <path
                                                                opacity="0.5"
                                                                d="M6 16L11 16M11 16L9.125 14M11 16L9.125 18"
                                                                stroke="#22c55e"
                                                                stroke-width="1.5"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>

                                                    <span className="mx-2">index.html</span>
                                                </div>
                                            </td>
                                            <td className="py-1.5 px-3">489 KB</td>
                                            <td className="py-1.5 px-3">21 Feb 2024, 11:05 am</td>
                                            <td className="py-1.5 px-3 text-center">
                                                <button className="text-gray-500 hover:text-gray-700">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="16"
                                                        height="16"
                                                        fill="currentColor"
                                                        className="bi bi-three-dots-vertical"
                                                        viewBox="0 0 16 16">
                                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                    </svg>
                                                </button>
                                                {/* <!-- Add more buttons as necessary --> */}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default App;