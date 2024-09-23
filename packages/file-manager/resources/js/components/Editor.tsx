import MonacoEditor from '@monaco-editor/react';
import Modal from './Modal';
import { useEffect, useRef } from 'react';

type EditorType = undefined | import('monaco-editor').editor.IStandaloneCodeEditor;

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
    '.swift': 'swift'
} as Record<string, string>;

// Function to get language based on file extension
function getLanguageFromExtension(filename: string) {
    const ext = filename.slice(Math.max(0, filename.lastIndexOf('.')) || Infinity);
    return extensionToLanguageMap[ext] || 'plaintext'; // Default to 'plaintext'
}

const Editor = ({
    open,
    toggle,
    fileName,
    fileContent
}: {
    open: boolean;
    fileContent: string;
    fileName: string;
    toggle: (action: boolean) => void;
}) => {
    const editorRef = useRef<EditorType>(undefined);

    function handleEditorDidMount(editor: EditorType) {
        editorRef.current = editor;
    }

    useEffect(() => {
        if (editorRef.current) {
            editorRef.current.setValue(fileContent);
            editorRef.current.getModel()?.updateOptions({ tabSize: 4 });
            editorRef.current.getModel()?.updateOptions({ insertSpaces: true });
        }
    }, [fileContent]);

    return (
        <Modal show={open} title="Editor" maxWidth="w-full">
            <MonacoEditor
                height="85vh"
                defaultValue={fileContent}
                onMount={handleEditorDidMount}
                defaultLanguage={getLanguageFromExtension(fileName)}
            />
            <div className="mt-2 flex justify-end">
                <button className="btn btn-primary">Save</button>
                <button className="btn btn-secondary ml-2" onClick={() => toggle(false)}>
                    Cancel
                </button>
            </div>
        </Modal>
    );
};

export default Editor;
