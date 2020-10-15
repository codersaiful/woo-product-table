<?php

function gutenberg_examples_01_register_block() {
 
    // automatically load dependencies and version
    $asset_file = array('dependencies' => array('wp-blocks', 'wp-element', 'wp-i18n', 'wp-polyfill'), 'version' => 'a35cc1c098b69994c9c6d6dc1416bb90');
 
    wp_register_script(
        'gutenberg-examples-01-esnext',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );
 
    register_block_type( 'gutenberg-examples/example-01-basic', array(
        'editor_script' => 'gutenberg-examples-01-esnext',
    ) );
 
}
add_action( 'init', 'gutenberg_examples_01_register_block' );