const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType( 'arraytics/form', {
    title: __( 'Arraytics Form', '' ),
    description: __( '', ''),
    icon: '',
    category: 'common',
    keywords: [
        __('Arraytics Form'),
        __('Arraytics Forms'),
    ],
    edit: function( { attributes, setAttributes } ) {

    },
    save: function( { attributes } ) {
        return '[arraytics-form]'
    },
});

registerBlockType( 'arraytics/report', {
    title: __( 'Arraytics Report', '' ),
    description: __( '', ''),
    icon: '',
    category: 'common',
    keywords: [
        __('Arraytics Report')
    ],
    edit: function( { attributes, setAttributes } ) {

    },
    save: function( { attributes } ) {
        return '[arraytics-report]'
    },
});