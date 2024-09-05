export interface IFile {
    name: string;
    type: string;
    path: string;
    size: number;
    lastModified: string;
    children: IFile[];
}
