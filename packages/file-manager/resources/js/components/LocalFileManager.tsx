import { useCallback, useEffect, useState } from 'react';
import { fetchFiles, fetchFileContent } from '@/utils';
import FileTree from '@/components/FileTree';
import { IFile } from '@/types';
import SimpleBar from 'simplebar-react';
import FileIcon from '@/components/FileIcon';
import LoadingSkeleton from '@/components/LoadingSkeleton';
import FileEditor from '@/components/FileEditor';

const LocalFileManager = () => {
    const [files, setFiles] = useState<IFile[]>([]);
    const [openEditor, setOpenEditor] = useState(false);
    const [fileContent, setFileContent] = useState('');
    const [fileName, setFileName] = useState('');
    const [selectedFiles, setSelectedFiles] = useState<IFile[]>([]);
    const [initialLoading, setInitialLoading] = useState(true);
    const [detailLoading, setDetailLoading] = useState(false);

    const [breadcrumb, setBreadcrumb] = useState<Record<string, string>[]>([
        {
            name: '',
            separator: '/'
        }
    ]);

    const fetchNestedFiles = async (file: IFile) => {
        if (file.type === 'file') {
            fileEditHandler(file);
            return;
        }
        const data = file.path.split('\\').map((item) => {
            return {
                name: item.trim(),
                separator: '/'
            };
        });
        setBreadcrumb(data);
        if (file.children?.length) {
            setSelectedFiles(file.children);
            return;
        }
        try {
            setDetailLoading(true);
            const { data: response } = await fetchFiles(file.path);
            file.children.push(...response.files);
            setSelectedFiles(file.children);
            setDetailLoading(false);
        } catch (err) {
            console.error(err);
        }
    };

    const breadcrumbClickHandler = async (index: number) => {
        const data = breadcrumb.slice(0, index + 1);
        setBreadcrumb(data);
        const path = data.map((item) => item.name).join('\\');
        fetchInitialFile(path);
        setDetailLoading(true);
    };

    const fetchInitialFile = useCallback(async (path?: string) => {
        try {
            const { data: response } = await fetchFiles(path);
            if (!path) {
                setFiles(response.files);
            }
            setSelectedFiles(response.files);
            setDetailLoading(false);
            setInitialLoading(false);
        } catch (err) {
            console.error(err);
        }
    }, []);

    const fileEditHandler = async (file: IFile) => {
        if (file.type === 'file') {
            toggleEditor();
            setFileName(file.name);
            const { data: response } = await fetchFileContent(file.path);
            setFileContent(response.contents);
        }
    };

    const toggleEditor = () => {
        setOpenEditor(!openEditor);
        if (!openEditor) {
            setFileContent('');
        }
    };

    const allSelected = selectedFiles.every((file) => file.checked);

    const checkedItems = selectedFiles.filter((file) => file.checked);

    const checkedItem = (file: IFile, e: React.ChangeEvent<HTMLInputElement>) => {
        setSelectedFiles(
            selectedFiles.map((item) => {
                if (item.path === file.path) {
                    return { ...item, checked: e.target.checked };
                }
                return item;
            })
        );
    };

    const checkedAllItems = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSelectedFiles(selectedFiles.map((file) => ({ ...file, checked: e.target.checked })));
    };

    useEffect(() => {
        fetchInitialFile();
    }, [fetchInitialFile]);
    return (
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
                                    className="stroke-primary"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-dasharray="4 4"></path>
                            </g>
                        </svg>
                    </span>
                    <div className="flex gap-2">
                        {breadcrumb.map((item, index) => (
                            <div className="text-primary-500">
                                <span
                                    onClick={breadcrumbClickHandler.bind(null, index)}
                                    className="underline cursor-pointer">
                                    {item.name || 'Local'}
                                </span>
                                {index != breadcrumb.length - 1 ? (
                                    <span className="text-gray-700 ml-2">{item.separator}</span>
                                ) : null}
                            </div>
                        ))}
                    </div>
                </div>
                <span className="rounded bg-primary-500 text-white p-1">
                    {selectedFiles.length} items
                </span>
            </div>

            {/* <!-- File List --> */}
            <div className="overflow-auto grid grid-cols-7 border rounded-lg">
                <div className="col-span-2">
                    {initialLoading ? (
                        <div className="p-4">
                            {Array.from({ length: 10 }).map((_, index) => (
                                <LoadingSkeleton key={index} />
                            ))}
                        </div>
                    ) : (
                        <SimpleBar style={{ maxHeight: 500 }}>
                            <ul className="p-4">
                                {files.map((file) => (
                                    <FileTree
                                        key={file.path}
                                        file={file}
                                        action={fetchNestedFiles}
                                    />
                                ))}
                            </ul>
                        </SimpleBar>
                    )}
                </div>

                <div className="col-span-5 border-l">
                    {detailLoading ? (
                        <div className="p-4">
                            {Array.from({ length: 10 }).map((_, index) => (
                                <LoadingSkeleton key={index} />
                            ))}
                        </div>
                    ) : null}
                    {selectedFiles.length && !detailLoading ? (
                        <SimpleBar style={{ maxHeight: 500, height: '100%' }}>
                            <table className="w-full text-left">
                                <thead>
                                    <tr className="text-gray-500 uppercase text-sm border-b">
                                        <td className="bg-white sticky top-0 z-50 py-1.5 px-3 w-10">
                                            <input
                                                type="checkbox"
                                                className="rounded"
                                                checked={allSelected}
                                                onChange={checkedAllItems}
                                            />
                                        </td>
                                        <th className="bg-white sticky top-0 z-50 py-1.5 px-3">
                                            Name
                                        </th>
                                        <th className="bg-white sticky top-0 z-50 py-1.5 px-3">
                                            Size
                                        </th>
                                        <th className="bg-white sticky top-0 z-50 py-1.5 px-3">
                                            Last Modified
                                        </th>
                                        <th className="bg-white sticky top-0 z-50 py-1.5 px-3 text-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="text-sm text-gray-700">
                                    {checkedItems.length ? (
                                        <tr className="border-b border-gray-200 on-parent-hover-show">
                                            <td colSpan={5} className="text-center px-3 py-2">
                                                You have selected{' '}
                                                <strong>{checkedItems.length}</strong> users.
                                                <button
                                                    className="text-red-500 hover:text-red-700"
                                                    onClick={() =>
                                                        confirm(
                                                            'Are you sure you want to delete all selected files?'
                                                        )
                                                    }>
                                                    Delete
                                                </button>
                                                them?
                                            </td>
                                        </tr>
                                    ) : null}

                                    {selectedFiles.map((file) => (
                                        <tr className="divide-y divide-gray-200">
                                            <td className="py-1.5 px-3 w-10">
                                                <input
                                                    type="checkbox"
                                                    className="rounded"
                                                    onChange={checkedItem.bind(null, file)}
                                                    checked={file.checked}
                                                />
                                            </td>
                                            <td className="py-1.5 px-3">
                                                <div
                                                    onClick={fetchNestedFiles.bind(null, file)}
                                                    className="flex items-center cursor-pointer">
                                                    <FileIcon type={file.type} />

                                                    <span className="mx-2">{file.name}</span>
                                                </div>
                                            </td>
                                            <td className="py-1.5 px-3">{file.size}</td>
                                            <td className="py-1.5 px-3">{file.modified_at}</td>
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
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </SimpleBar>
                    ) : null}
                </div>
            </div>
            <FileEditor
                open={openEditor}
                toggle={toggleEditor}
                fileContent={fileContent}
                fileName={fileName}
            />
        </div>
    );
};

export default LocalFileManager;
