( function( blocks, element ) {
    var el = element.createElement;
 
    var blockStyle = {
        backgroundColor: '#900',
        color: '#fff',
        padding: '20px',
    };
    console.log(blocks);
    blocks.registerBlockType( 'gutenberg-examples/example-01-basic', {
        title: 'Example: Basic',
        icon: 'universal-access-alt',
        category: 'design',
        example: {},
        edit: function() {
            return el(
                'div',
                { style: blockStyle },
                'Hello World, step 1 (from the editor).'
            );
        },
        save: function() {
            return el(
                'div',
                { style: blockStyle },
                'Hello World, step 1 (from the frontend).'
            );
        },
    } );
}(
    window.wp.blocks,
    window.wp.element
) );