import MonacoEditor from '@monaco-editor/react';
import { useEffect, useRef } from 'react';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';

// Mapping of file extensions to Monaco languages
const extensionToLanguageMap = {
    '.js': 'javascript',
    '.ts': 'typescript',
    '.jsx': 'javascript',
    '.tsx': 'typescript',
    '.py': 'python',
    '.cpp': 'cpp',
    '.html': 'html',
    '.css': 'css',
    '.json': 'json',
    '.xml': 'xml',
    '.yml': 'yaml',
    '.yaml': 'yaml',
    '.md': 'markdown',
    '.sh': 'shell',
    '.sql': 'sql',
    '.java': 'java',
    '.php': 'php',
    '.rb': 'ruby',
    '.go': 'go',
    '.cs': 'csharp',
    '.swift': 'swift',
    '.lock': 'json'
} as Record<string, string>;

// Function to get language based on file extension
function getLanguageFromExtension(filename: string) {
    const ext = filename.slice(Math.max(0, filename.lastIndexOf('.')) || Infinity);
    return extensionToLanguageMap[ext] || 'plaintext'; // Default to 'plaintext'
}

const FileEditor = ({
    open,
    toggle,
    fileName,
    fileContent,
    readOnly = false
}: {
    open: boolean;
    fileContent: string;
    fileName: string;
    readOnly?: boolean;
    toggle: (action: boolean) => void;
}) => {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const editorRef = useRef<any>(undefined);

    // eslint-disable-next-line @typescript-eslint/no-explicit-any, @typescript-eslint/no-unused-vars
    const handleEditorDidMount = (editor: any, monaco: any) => {
        editorRef.current = editor;
    };

    useEffect(() => {
        if (editorRef.current) {
            editorRef.current.setValue(fileContent);
            editorRef.current.getModel()?.updateOptions({ tabSize: 4 });
            editorRef.current.getModel()?.updateOptions({ insertSpaces: true });
        }
    }, [fileContent]);

    return (
        <Dialog open={open} as="div" className="relative z-50 focus:outline-none" onClose={close}>
            <div className="fixed inset-0 z-50 w-screen overflow-y-auto">
                <DialogPanel
                    transition
                    className="w-full rounded-xl bg-white/5 p-4 h-full backdrop-blur-2xl duration-300 ease-out data-[closed]:transform-[scale(95%)] data-[closed]:opacity-0">
                    <DialogTitle as="h3" className="text-base/7 pb-4 font-bold">
                        {fileName}
                    </DialogTitle>
                    <MonacoEditor
                        height="85vh"
                        defaultValue={fileContent}
                        onMount={handleEditorDidMount}
                        options={{ readOnly: readOnly }}
                        defaultLanguage={getLanguageFromExtension(fileName)}
                    />
                    <div className="mt-4">
                        <div className="mt-2 flex justify-end">
                            <button className="btn btn-primary">Save</button>
                            <button
                                className="btn btn-secondary ml-2"
                                onClick={() => toggle(false)}>
                                Cancel
                            </button>
                        </div>
                    </div>
                </DialogPanel>
            </div>
        </Dialog>
    );
};

export default FileEditor;
