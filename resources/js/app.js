import './bootstrap';

import Alpine from 'alpinejs';
import tinymce from 'tinymce/tinymce';
import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/models/dom';

import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/table';
import 'tinymce/plugins/code';

import 'tinymce/skins/ui/oxide/skin.css';

window.Alpine = Alpine;
window.tinymce = tinymce;

/*
|--------------------------------------------------------------------------
| Travel Form
|--------------------------------------------------------------------------
*/

Alpine.data('travelForm', (data) => ({
    tags: [],
    includes: [],
    options: [],

    isPickup: false,
    isGroup: false,
    isDiscount: false,

    travelName:
        data.travelName ?? '',

    slug:
        data.slug ?? '',

    slugTouched:
        false,

    generateSlug(value) {
        return value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    },

    updateSlug() {
        if (!this.slugTouched) {
            this.slug =
                this.generateSlug(
                    this.travelName
                );
        }
    },

    init() {
        this.isPickup =
            Boolean(data.isPickup);

        this.isGroup =
            Boolean(data.isGroup);

        this.isDiscount =
            Boolean(data.isDiscount);

        this.tags =
            (data.tags || []).map((id) => ({
                key: this.generateKey(),
                id: String(id),
            }));

        this.includes =
            (data.includes || []).map((item) => ({
                key: this.generateKey(),
                id: item.id ?? '',
                include_desc:
                    item.include_desc ?? '',
            }));

        this.options =
            (data.options || []).map((option) => ({
                key: this.generateKey(),

                id:
                    option.id ?? '',

                option_name:
                    option.option_name ?? '',

                description:
                    option.description ?? '',

                prices:
                    (option.prices || []).map((price) => ({
                        key: this.generateKey(),
                        id: price.id ?? '',
                        type: price.type ?? 'person',
                        label: price.label ?? '',
                        min: price.min ?? 1,
                        max: price.max ?? '',
                        price: price.price ?? '',
                    })),

                times:
                    (option.times || []).map((time) => ({
                        key: this.generateKey(),
                        id: time.id ?? '',
                        time: time.time ?? '',
                    })),

                addons:
                    (option.addons || []).map((addon) => ({
                        key: this.generateKey(),
                        id: addon.id ?? '',
                        addon_name:
                            addon.addon_name ?? '',
                        description:
                            addon.description ?? '',
                        price:
                            addon.price ?? '',
                        min:
                            addon.min ?? 0,
                        max:
                            addon.max ?? 1,
                    })),
            }));

        if (this.options.length === 0) {
            this.addOption();
        }
    },

    generateKey() {
        return (
            Date.now().toString(36) +
            Math.random()
                .toString(36)
                .substring(2)
        );
    },

    addTag() {
        this.tags.push({
            key: this.generateKey(),
            id: '',
        });
    },

    removeTag(index) {
        this.tags.splice(index, 1);
    },

    addInclude() {
        this.includes.push({
            key: this.generateKey(),
            id: '',
            include_desc: '',
        });
    },

    removeInclude(index) {
        this.includes.splice(index, 1);
    },

    addOption() {
        const option = {
            key: this.generateKey(),
            id: '',
            option_name: '',
            description: '',
            prices: [],
            times: [],
            addons: [],
        };

        this.addPrice(option);

        this.options.push(option);
    },

    removeOption(index) {
        if (this.options.length <= 1) {
            return;
        }

        this.options.splice(index, 1);
    },

    addPrice(option) {
        option.prices.push({
            key: this.generateKey(),
            id: '',
            type: 'person',
            label: '',
            min: 1,
            max: '',
            price: '',
        });
    },

    removePrice(option, index) {
        if (option.prices.length <= 1) {
            return;
        }

        option.prices.splice(index, 1);
    },

    addTime(option) {
        option.times.push({
            key: this.generateKey(),
            id: '',
            time: '',
        });
    },

    removeTime(option, index) {
        option.times.splice(index, 1);
    },

    addAddon(option) {
        option.addons.push({
            key: this.generateKey(),
            id: '',
            addon_name: '',
            description: '',
            price: '',
            min: 0,
            max: 1,
        });
    },

    removeAddon(option, index) {
        option.addons.splice(index, 1);
    },
}));


/*
|--------------------------------------------------------------------------
| Travel Image
|--------------------------------------------------------------------------
*/

Alpine.data(
    'travelImage',
    (initialImage = null) => ({

        preview:
            initialImage,

        objectUrl:
            null,

        change(event) {
            const file =
                event.target.files?.[0];

            if (!file) {
                return;
            }

            if (this.objectUrl) {
                URL.revokeObjectURL(
                    this.objectUrl
                );
            }

            this.objectUrl =
                URL.createObjectURL(file);

            this.preview =
                this.objectUrl;
        },
    })
);


/*
|--------------------------------------------------------------------------
| START ALPINE
|--------------------------------------------------------------------------
|
| HARUS PALING BAWAH setelah semua Alpine.data()
|
*/

Alpine.start();


/*
|--------------------------------------------------------------------------
| TinyMCE
|--------------------------------------------------------------------------
*/

function initTinyMCE() {

    const textarea =
        document.querySelector(
            '#full_description'
        );

    /*
     * Halaman lain tidak punya
     * full_description.
     */
    if (!textarea) {
        return;
    }

    /*
     * Hindari double initialization.
     */
    const existingEditor =
        tinymce.get(
            'full_description'
        );

    if (existingEditor) {
        existingEditor.remove();
    }

    tinymce.init({
        selector:
            '#full_description',

        license_key: 'gpl',

        height:
            450,

        menubar:
            false,

        branding:
            false,

        promotion:
            false,

        /*
         * Karena skin CSS sudah
         * di-import melalui Vite.
         */
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

            /*
             * Sinkronkan isi TinyMCE
             * ke textarea Laravel.
             */
            editor.on(
                'change keyup input',
                () => {
                    editor.save();
                }
            );

        },
    });
}


if (
    document.readyState === 'loading'
) {

    document.addEventListener(
        'DOMContentLoaded',
        initTinyMCE
    );

} else {

    initTinyMCE();

}


