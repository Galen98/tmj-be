import tinymce from 'tinymce/tinymce';

import 'tinymce/icons/default';
import 'tinymce/themes/silver';

import 'tinymce/models/dom';

import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/table';
import 'tinymce/plugins/code';

import 'tinymce/skins/ui/oxide/skin.css';

window.tinymce = tinymce;


export function initTinyMCE() {

    const selector =
        '#full_description';


    const element =
        document.querySelector(selector);

    if (!element) {
        return;
    }


    /*
     * Hindari editor double init.
     */
    const existingEditor =
        tinymce.get('full_description');

    if (existingEditor) {
        existingEditor.remove();
    }


    tinymce.init({
        selector,

        height:
            450,

        license_key: 'gpl',

        menubar:
            false,

        branding:
            false,

        promotion:
            false,

        skin:
            false,

        content_css:
            false,

        plugins: [
            'lists',
            'link',
            'table',
            'code',
        ],

        toolbar:
            'undo redo | ' +
            'blocks | ' +
            'bold italic underline | ' +
            'bullist numlist | ' +
            'link table | ' +
            'code',

        setup(editor) {

            editor.on(
                'change keyup input',
                () => {
                    editor.save();
                }
            );

        },
    });
}
