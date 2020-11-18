import EditorJS from '@editorjs/editorjs';

document.addEventListener('DOMContentLoaded', () => {
    const editors = document.querySelectorAll('.editor--js');

    editors.forEach((editorElement) => {
        const input = document.querySelector(`[data-editor="${editorElement.id}"]`);

        const data = JSON.parse(input.value);

        const Header = require('@editorjs/header');
        const SimpleImage = require('@editorjs/simple-image');
        const List = require('@editorjs/list');
        const Checklist = require('@editorjs/checklist');
        const Quote = require('@editorjs/quote');
        const Warning = require('@editorjs/warning');
        const Marker = require('@editorjs/marker');
        const CodeTool = require('@editorjs/code');
        const Delimiter = require('@editorjs/delimiter');
        const InlineCode = require('@editorjs/inline-code');
        const LinkTool = require('@editorjs/link');
        const Embed = require('@editorjs/embed');
        const Table = require('@editorjs/table');

        const editor = new EditorJS({
            holder: editorElement.id,

            tools: {
                header: {
                    class: Header,
                    inlineToolbar : true
                },

                image: SimpleImage,

                list: {
                    class: List,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+L'
                },

                checklist: {
                    class: Checklist,
                    inlineToolbar: true,
                },

                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    config: {
                        quotePlaceholder: 'Enter a quote',
                        captionPlaceholder: 'Quote\'s author',
                    },
                    shortcut: 'CMD+SHIFT+O'
                },

                warning: Warning,

                marker: {
                    class:  Marker,
                    shortcut: 'CMD+SHIFT+M'
                },

                code: {
                    class:  CodeTool,
                    shortcut: 'CMD+SHIFT+C'
                },

                delimiter: Delimiter,

                inlineCode: {
                    class: InlineCode,
                    shortcut: 'CMD+SHIFT+C'
                },

                linkTool: LinkTool,

                embed: Embed,

                table: {
                    class: Table,
                    inlineToolbar: true,
                    shortcut: 'CMD+ALT+T'
                },
            },

            data: data,

            onChange: (api) => {
                const input = document.querySelector(`[data-editor="${editorElement.id}"]`);

                api.saver.save()
                    .then((data) => {
                        input.value = JSON.stringify(data);
                    });
            }
        });

        window.editor = editor;
    });
})

