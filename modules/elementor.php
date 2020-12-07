<?php

class WPT_Elementor{
    
    /**
     * Instance of WPT_Elementor
     * 
     * @return Object Full Object of WPT_Elementor
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Init of WPT_Elementor
     */
    public function init() {
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        //add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
    }
    
    /**
     * Init Widget for Elementor
     * 
     * @return void
     */
    public function init_widgets() {
        $widget_file = WPT_DIR_BASE . 'modules/elementor-widget.php';
        if( ! is_file( $widget_file ) ) return;
        include $widget_file;
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new WPT_Elementor_Widget() );
    }
}
//WPT_Elementor::instance()->init();
$WPT_Elementor = new WPT_Elementor();
$WPT_Elementor->init();