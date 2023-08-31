console.log('HHHHHHHHHHHHHHHHHHHHHHHHHHHH');
console.log(wp);
(function (blocks, editor, components, i18n, element) {
    console.log(blocks, editor, components, i18n, element);
    var el = element.createElement;
    var TextControl = components.TextControl;

    blocks.registerBlockType('woo-product-table/wpt-block', {
        title: i18n.__('Woo Product Table', 'woo-product-table'),
        icon: 'smiley',
        category: 'common',
        attributes: {
            productId: {
                type: 'int',
                default: '123', // Default dynamic parameter
            },
        },
        edit: function (props) {
            var productId = props.attributes.productId;

            function onChangeProductId(newProductId) {
                props.setAttributes({ productId: newProductId });
            }

            return el(
                'div',
                { className: 'wpt-block-wrapper' },
                el(TextControl, {
                    label: i18n.__('Product ID', 'your-plugin'),
                    value: productId,
                    onChange: onChangeProductId,
                }),
                el('p', {
                    className: 'shortcode-output',
                    dangerouslySetInnerHTML: { __html: `[Product_Table id='${productId}']` },
                })
            );
        },
        save: function (props) {
            return el('div', {
                className: 'wpt-block-wrapper',
                dangerouslySetInnerHTML: { __html: `[Product_Table id='${props.attributes.productId}']` },
            });
        },
    });
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.components,
    window.wp.i18n,
    window.wp.element
);
