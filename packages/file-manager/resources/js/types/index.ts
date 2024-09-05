export interface IFile {
    name: string;
    type: string;
    path: string;
    size: number;
    modified_at: string;
    expanded: boolean;
    children: IFile[];
}
