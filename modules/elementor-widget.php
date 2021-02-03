<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;


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

                //For General/Content Tab
		$this->content_general();
                
                //For Typography Section Style Tab
                $this->style_table_head();
                
                //For Typography Section Style Tab
                $this->style_table_body();
                
                
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
                $name = get_the_title( $table_id );
                $shortcode = "[Product_Table id='{$table_id}' name='{$name}']";
                $shortcode = do_shortcode( shortcode_unautop( $shortcode ) );
		?>
                <div class="wpt-elementor-wrapper wpt-elementor-wrapper-<?php echo esc_attr( $table_id ); ?>">
                    <?php echo $shortcode; ?>
                </div>
		<?php
            }else{
                echo '<h2 class="wpt_elmnt_select_note">';
                echo esc_html__( 'Please select a Table.', 'wpt_pro' );
                echo '</h2>';
            }
	}
        
        protected function content_general() {
                $this->start_controls_section(
			'general',
			[
				'label' => __( 'General', 'wpt_pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
                    //Controls_Manager::HEADING
                endif;
                
		
                wp_reset_postdata();
                wp_reset_query();
                if( $table_options && is_array( $table_options ) ){
                    $this->add_control(
                            'table_id',
                            [
                                    'label' => __( 'Table List', 'wpt_pro' ),
                                    'type' => Controls_Manager::SELECT,
                                    'options' => $table_options,
                                    //'default' => '',
                            ]
                    );
                    /****************************
                    $this->add_control(
                            'table_edit',
                            [
				'label' => __( 'Additional Info', 'wpt_pro' ),
				'type' => Controls_Manager::RAW_HTML,
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
                            'type' => Controls_Manager::RAW_HTML,
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
         * Typography Section for Style Tab
         * 
         * @since 1.0.0.9
         */
        protected function style_table_head() {
            $this->start_controls_section(
                'thead',
                [
                    'label'     => esc_html__( 'Table Head', 'medilac' ),
                    'tab'       => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                            'name' => 'thead_typography',
                            'global' => [
                                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                            ],
                            'selector' => '{{WRAPPER}} table.wpt_product_table thead tr th',
                    ]
            );

            $this->add_control(
                'thead-color',
                [
                    'label'     => __( 'Color', 'medilac' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.wpt_product_table thead tr th' => 'color: {{VALUE}}',
                    ],
                    'default'   => '#ffffff',
                ]
            );
            
            $this->add_control(
                'thead-bg-color',
                [
                    'label'     => __( 'Background Color', 'medilac' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.wpt_product_table thead tr th' => 'background-color: {{VALUE}}',
                    ],
                    'default'   => '#0a7f9c',
                ]
            );
            
            
            
            $this->end_controls_section();
        }
    
        
        
        /**
         * Typography Section for Style Tab
         * 
         * @since 1.0.0.9
         */
        protected function style_table_body() {
            
            
            $this->start_controls_section(
                'tbody',
                [
                    'label'     => esc_html__( 'Table Body', 'medilac' ),
                    'tab'       => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                            'name' => 'tbody_typography',
                            'global' => [
                                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} table.wpt_product_table tbody tr td',
                                '{{WRAPPER}} table.wpt_product_table tbody tr td a',
                                '{{WRAPPER}} table.wpt_product_table tbody tr td p',
                                '{{WRAPPER}} table.wpt_product_table tbody tr td div',
                            ],
                    ]
            );

            $this->add_control(
                'tbody-text-color',
                [
                    'label'     => __( 'Text Color', 'medilac' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.wpt_product_table tbody tr td' => 'color: {{VALUE}}',
                        '{{WRAPPER}} table.wpt_product_table tbody tr td p' => 'color: {{VALUE}}',
                        '{{WRAPPER}} table.wpt_product_table tbody tr td div' => 'color: {{VALUE}}',
                    ],
                    'default'   => '#535353',
                ]
            );
            
            $this->add_control(
                'tbody-title-color',
                [
                    'label'     => __( 'Product Title Color', 'medilac' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.wpt_product_table tbody tr td .product_title a' => 'color: {{VALUE}}',
                    ],
                    'default'   => '#000',
                ]
            );
            
            
            $this->add_control(
                'tbody-bg-color',
                [
                    'label'     => __( 'Background Color', 'medilac' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} table.wpt_product_table tbody tr td' => 'background-color: {{VALUE}}',
                    ],
                    //'default'   => '#fff',
                ]
            );
            
            $this->end_controls_section();
        }
    

}