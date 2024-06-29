<div x-data="editor({{ $content }})">
    <template x-if="isLoaded()">
        <div
            class="mx-0 mb-0 mt-1 flex flex-none flex-wrap items-center break-words rounded-t-md border-x border-t border-solid border-skin-neutral-7 bg-no-repeat p-2 font-sans text-xl leading-5 tracking-normal">
            <x-tiptap-button :title="__('Bold')" icon="ri-bold" @click.prevent="editor.commands.toggleBold()" />

            <x-tiptap-button :title="__('Italic')" icon="ri-italic" @click.prevent="editor.commands.toggleItalic()" />

            <x-tiptap-button :title="__('Underline')" icon="ri-underline" @click.prevent="editor.commands.toggleUnderline()" />

            <x-tiptap-button :title="__('Strikethrough')" icon="ri-strikethrough" @click.prevent="editor.commands.toggleStrike()" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Heading 1')" icon="ri-h-1"
                @click.prevent="editor.commands.toggleHeading({ level: 1 })" />

            <x-tiptap-button :title="__('Heading 2')" icon="ri-h-2"
                @click.prevent="editor.commands.toggleHeading({ level: 2 })" />

            <x-tiptap-button :title="__('Heading 3')" icon="ri-h-3"
                @click.prevent="editor.commands.toggleHeading({ level: 3 })" />

            <x-tiptap-button :title="__('Heading 4')" icon="ri-h-4"
                @click.prevent="editor.commands.toggleHeading({ level: 4 })" />

            <x-tiptap-button :title="__('Paragraph')" icon="ri-paragraph" @click.prevent="editor.commands.setParagraph()" />

            <x-tiptap-button :title="__('List')" icon="ri-list-unordered"
                @click.prevent="editor.commands.toggleBulletList()" />

            <x-tiptap-button :title="__('Ordered Link')" icon="ri-list-ordered"
                @click.prevent="editor.commands.toggleOrderedList()" />

            <x-tiptap-button :title="__('Add Link')" icon="ri-link-m" @click.prevent="setLink" />

            <x-tiptap-button :title="__('Remove Link')" icon="ri-link-unlink-m" @click.prevent="editor.commands.unsetLink()" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Line Break')" icon="ri-text-wrap" @click.prevent="editor.commands.setHardBreak()" />

            <x-tiptap-button :title="__('Horizontal Rule')" icon="ri-separator"
                @click.prevent="editor.commands.setHorizontalRule()" />

            <x-tiptap-button :title="__('Clear Format')" icon="ri-format-clear" @click.prevent="editor.commands.clearNodes()" />

            <x-tiptap-divider />

            <x-tiptap-button v-if="fileUploadUrl" :title="__('Add Image')" icon="ri-image-add-line"
                @click.prevent="uploadFile" />

            <x-tiptap-button :title="__('Add Video')" icon="ri-youtube-line" @click.prevent="addVideo" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Table')" icon="ri-table-line" @click.prevent="toggleTableToolbar" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Undo')" icon="ri-arrow-go-back-line" @click.prevent="editor.commands.undo()" />

            <x-tiptap-button :title="__('Redo')" icon="ri-arrow-go-forward-line"
                @click.prevent="editor.commands.redo()" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Code View')" icon="ri-code-box-line" @click.prevent="changeEditorMode" />
        </div>

        <div v-show="showTableToolbar"
            class="mx-0 mb-0 flex flex-none flex-wrap items-center break-words border-x border-t border-solid border-skin-neutral-7 border-t-skin-neutral-7 bg-no-repeat p-2 font-sans text-xl leading-5 tracking-normal">
            <x-tiptap-button :title="__('Insert Table')" icon="ri-table-2"
                @click.prevent="
                    editor.commands.insertTable({
                        rows: 3,
                        cols: 3,
                        withHeaderRow: true
                    })
                " />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Add Column Before')" icon="ri-layout-3-line"
                @click.prevent="editor.commands.addColumnBefore()" />

            <x-tiptap-button :title="__('Add Column After')" icon="ri-layout-6-line"
                @click.prevent="editor.commands.addColumnAfter()" />

            <x-tiptap-button :title="__('Delete Column')" icon="ri-delete-column"
                @click.prevent="editor.commands.deleteColumn()" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Add Row Before')" icon="ri-insert-row-top"
                @click.prevent="editor.commands.addRowBefore()" />

            <x-tiptap-button :title="__('Add Row After')" icon="ri-insert-row-bottom"
                @click.prevent="editor.commands.addRowAfter()" />

            <x-tiptap-button :title="__('Delete Row')" icon="ri-delete-row" @click.prevent="editor.commands.deleteRow()" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Merge Cells')" icon="ri-merge-cells-horizontal"
                @click.prevent="editor.commands.mergeCells()" />

            <x-tiptap-button :title="__('Split Cell')" icon="ri-split-cells-horizontal"
                @click.prevent="editor.commands.splitCell()" />

            <x-tiptap-button :title="__('Alternate Column Header')" icon="ri-archive-drawer-line"
                @click.prevent="editor.commands.toggleHeaderColumn()" />

            <x-tiptap-button :title="__('Alternate Row Header')" icon="ri-archive-drawer-fill"
                @click.prevent="editor.commands.toggleHeaderRow()" />

            <x-tiptap-button :title="__('Alternate Cell Header')" icon="ri-split-cells-vertical"
                @click.prevent="editor.commands.toggleHeaderCell()" />

            <x-tiptap-button :title="__('Merge or Split')" icon="ri-merge-cells-vertical"
                @click.prevent="editor.commands.mergeOrSplit()" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Go to Next Cell')" icon="ri-arrow-right-s-line"
                @click.prevent="editor.chain().focus().goToNextCell().run()" />

            <x-tiptap-button :title="__('Go to Previous Cell')" icon="ri-arrow-left-s-line"
                @click.prevent="editor.chain().focus().goToPreviousCell().run()" />

            <x-tiptap-divider />

            <x-tiptap-button :title="__('Fix Table')" icon="ri-settings-line" @click.prevent="editor.commands.fixTables()" />

            <x-tiptap-button :title="__('Delete Table')" icon="ri-delete-bin-2-line"
                @click.prevent="editor.commands.deleteTable()" />
        </div>
    </template>

    <div x-ref="element"></div>
</div>
