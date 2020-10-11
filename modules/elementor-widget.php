<?php

class WPT_Elementor_Widget extends \Elementor\Widget_Base{
    
	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wpt-table';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Woo Product Table', 'wpt_pro' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-table';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'wpt_pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
                
                $args = array(
                    'post_type' => 'wpt_product_table',
                    'posts_per_page'=> '-1',
                    'post_status' => 'publish',
                );
                $productTable = new WP_Query( $args );
                $table_options = array();
                $wpt_extra_msg = false;
                if ($productTable->have_posts()) : 
                    
                    while ($productTable->have_posts()): $productTable->the_post();

                    $id = get_the_id();
                    $table_options[$id] = get_the_title();
                    endwhile;
                    //$table_options[''] = esc_html__( 'Please Choose a Table', 'wpt_pro' );
                else:
                    $table_options = false;
                    //\Elementor\Controls_Manager::HEADING
                endif;
                
		
                wp_reset_postdata();
                wp_reset_query();
                if( $table_options && is_array( $table_options ) ){
                    $this->add_control(
                            'table_id',
                            [
                                    'label' => __( 'Table List', 'wpt_pro' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'options' => $table_options,
                                    //'default' => '',
                            ]
                    );
                    /****************************
                    $this->add_control(
                            'table_edit',
                            [
				'label' => __( 'Additional Info', 'wpt_pro' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => sprintf( 
                                        __( 'Edit your %sTable%s.', 'wpt_pro' ), 
                                        '<a href="' . esc_attr( admin_url( 'post.php?post=' . $table_ID . '&action=edit&classic-editor' ) ) . '">',
                                        '</a>'
                                        ),
				'content_classes' => 'wpt_add_new_table',
                            ]
                    );
                    //***************************************/
                }else{
                    $wpt_extra_msg = __( 'There is not founded any table to your. ', 'wpt_pro' );
                }
                
                $this->add_control(
                        'table_notification',
                        [
                            'label' => __( 'Additional Information', 'wpt_pro' ),
                            'type' => \Elementor\Controls_Manager::RAW_HTML,
                            'raw' => $wpt_extra_msg . sprintf( 
                                    __( 'Create %sa new table%s.', 'wpt_pro' ), 
                                    '<a href="' . admin_url( 'post-new.php?post_type=wpt_product_table' ) . '">',
                                    '</a>'
                                    ),
                            'content_classes' => 'wpt_elementor_additional_info',
                        ]
                );
                
		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
            $settings = $this->get_settings_for_display();
            $table_id = isset( $settings['table_id'] ) && !empty( $settings['table_id'] ) ? $settings['table_id'] : false;
            if( $table_id && is_numeric( $table_id ) ){
                echo do_shortcode( "[Product_Table id='{$table_id}']" );
            }else{
                echo '<h2 class="wpt_elmnt_select_note">';
                echo esc_html__( 'Please select a Table.', 'wpt_pro' );
                echo '</h2>';
            }
	}

}