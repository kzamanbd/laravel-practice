import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/react';
import { IFile } from '@/types';

interface TreeProps {
    file: IFile;
    action: (file: IFile) => void;
}

const FileTree = ({ file, action }: TreeProps) => {
    return (
        <Disclosure as="li" className="mb-2">
            <DisclosureButton className="w-full">
                {file.type == 'directory' ? (
                    <div onClick={() => action(file)} className="flex items-center ">
                        <span className="mr-2">📂</span>
                        <span className="font-bold">{file.name}</span>
                    </div>
                ) : (
                    <div className="flex items-center ">
                        <span className="mr-2">📄</span>
                        <span>{file.name}</span>
                    </div>
                )}
            </DisclosureButton>

            {file.children?.length ? (
                <DisclosurePanel
                    as="ul"
                    transition
                    className="pl-4 origin-top transition duration-100 ease-out data-[closed]:-translate-y-4 data-[closed]:opacity-0">
                    {file.children?.map((child) => (
                        <FileTree key={child.path} file={child} action={action} />
                    ))}
                </DisclosurePanel>
            ) : null}
        </Disclosure>
    );
};

export default FileTree;
