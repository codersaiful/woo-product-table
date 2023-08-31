console.log('HHHHHHHHHHHHHHHHHHHHHHHHHHHH');
console.log(wp);
(function (blocks, editor, components, i18n, element) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var apiFetch = wp.apiFetch;

    blocks.registerBlockType('woo-product-table/wpt-block', {
        title: i18n.__('Woo Product Table Block', 'woo-product-table'),
        icon: 'smiley',
        category: 'common',
        attributes: {
            productId: {
                type: 'string',
                default: '', // Default dynamic parameter
            },
            productOptions: {
                type: 'array',
                default: [],
            },
        },
        edit: function (props) {
            var productId = props.attributes.productId;
            var productOptions = props.attributes.productOptions;

            function onChangeProductId(newProductId) {
                props.setAttributes({ productId: newProductId });
            }

            function fetchProductOptions() {
                apiFetch({
                    url: '/wp/v2/wpt_product_table', // Adjust the REST API endpoint
                }).then(function (products) {
                    var options = products.map(function (product) {
                        return { value: product.id, label: product.title.rendered };
                    });
                    props.setAttributes({ productOptions: options });
                });
            }

            if (productOptions.length === 0) {
                fetchProductOptions();
            }

            return el(
                'div',
                { className: 'wpt-block-wrapper' },
                el(SelectControl, {
                    label: i18n.__('Select Product', 'woo-product-table'),
                    value: productId,
                    options: productOptions,
                    onChange: onChangeProductId,
                }),
                el('p', {
                    className: 'shortcode-output',
                    dangerouslySetInnerHTML: { __html: `[Product_Table id='${productId}']` },
                })
            );
        },
        // ...
    });
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.components,
    window.wp.i18n,
    window.wp.element
);
