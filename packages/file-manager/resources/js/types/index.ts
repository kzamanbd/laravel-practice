export interface IFile {
    name: string;
    type: string;
    path: string;
    size: number;
    checked: boolean;
    modified_at: string;
    expanded: boolean;
    children: IFile[];
}
