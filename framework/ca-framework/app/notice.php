<?php 
namespace CA_Framework\App;

use CA_Framework\App\Base\Notice_Base as Notice_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'CA_Framework\Notice' ) ){

    /**
     * Notice Handler Class
     * Developed by Saiful Islam,  CEO of Code Astrology
     * 
     * here User able to handle his Notice, using this one Class
     * 
     * EXAMPLE:
     * 
     *  $my_notice = new CA_Framework\Notice('ddvpl-');
     *  $my_notice->notice_type = 'error';
     *  $my_notice->set_message("Most Welcome. Thank you for using Quick View To get more amazing features and the outstanding pro ready-made layouts, please get the")
     ->show();
     *  $new_notice = new CA_Framework\Notice('dsfvfpld-');
     *  $new_notice>set_message("Nothing to do for it.");
     *  $new_notice>show();

     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     * @since 1.0.0.5
     */
    class Notice extends Notice_Base
    {
        private $temp = 1;

        private $diff_limit = 10; //for date
        private $notice_id;
        private $message;

        public $notice_type = 'success';
        private $img;
        private $img_target = 'https://codeastrology.com';
        private $title;

        public $start_date; //Example: 4/21/2022 17:1:24
        public $end_date; //Example: 4/21/2022 17:1:24

        private $buttons = array();

        /**
         * Declear your Action Hook, where you want to show
         * your Notice/Message/Offer
         *
         * @var String|Null 
         */
        private $location;

        /**
         * Define a Unique notice ID,
         * Example: new CA_Framework\Notice('skdlq')
         *
         * @param String $notice_id Each Notice should have new unique number
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        public function __construct( $notice_id )
        {
            parent::__construct();
            $this->notice_id = $notice_id;
        }
      
        public function set_diff_limit( $day )
        {
            $this->diff_limit = $day;
            return $this;
        }
        public function set_location( $location )
        {
            $this->location = $location;
            return $this;
        }

        public function add_button( $button_arr )
        {
            $this->buttons[] = $button_arr;
            return $this;
        }

        /**
         * Get full buttons array with generate with default value
         *
         * @return null||Array
         */
        private function get_buttons()
        {
            $defl = array(
                'type'      =>  'primary',
                'text'      =>  __( 'Click here', 'ca-framework' ),
                'target'    =>  '_blank',
                'link'      =>  '#'
            );
            if( ! is_array( $this->buttons ) ) return;
            $gen_buttons = array();
            foreach( $this->buttons as $key=>$button ){
                if( ! is_array( $button ) ) continue;
                $gen_buttons[$key] = array_merge( $defl, $button );

            }

            return $gen_buttons;
        }
        
        public function set_message( $message )
        {
            $this->message = $message;
            return $this;
        }

        /**
         * It's Actually Notice type.
         * we set some color for title based on Type
         * Available Type:
         * * warning
         * * primary
         * * success
         * * error
         * * offer
         *
         * @author Saiful <codersaiful@gmail.com>
         * @param String $notice_type
         * @return object
         */
        public function set_type( $notice_type )
        {
            $this->notice_type = $notice_type;
            return $this;
        }

        /**
         * Set unlimited day limit. It will set 9999 day as diff limit
         * which is almost no-repeat
         *
         * @return object
         */
        public function set_no_repeat()
        {
            $this->diff_limit = 9999;
            return $this;
        }

        /**
         * Set a date to display Notice after specific date
         *
         * @param String $start_date
         * @return object
         */
        public function set_start_date( $start_date )
        {
            $this->start_date = $start_date;
            return $this;
        }

        /**
         * Set a date to hide Notice after specific date
         *
         * @param String $end_date
         * @return object
         */
        public function set_end_date( $end_date )
        {
            $this->end_date = $end_date;
            return $this;
        }

        /**
         * Set full image url here to set display an image on Notice.
         *
         * @param String $img
         * @return object
         */
        public function set_img( $img ){
            $this->img = $img;
            return $this;
        }
        public function set_img_target( $img_target ){
            $this->img_target = $img_target;
            return $this;
        }
        public function set_title( $title ){
            $this->title = $title;
            return $this;
        }

    
        /**
         * Notice show if condition meet
         */
        public function show(){

            if( ! is_admin() ) return;

            //Control End Date
            if( ! empty( $this->end_date ) && strtotime($this->end_date) < current_time( 'timestamp' ) ) return;

            //Control Start Date
            if( ! empty( $this->start_date ) && strtotime($this->start_date) > current_time( 'timestamp' ) ) return;
                                 
            $close_date   = get_option( $this->notice_id . "_notice_close_date");
            if( ! empty($close_date) && is_numeric( $close_date )){
                $close_date		        = date("Y-m-d", $close_date);
    
                $date				    = new \DateTime($close_date);
                $now 				    = new \DateTime();
                $date_diff = $date->diff($now)->format("%d");
            }else{
                $date_diff = 99999;
            }
                            
            
            
            if( $date_diff >= $this->diff_limit ){
                add_action("admin_notices", [$this, "notice_output"]);
            }

            
            if( $this->location ){
                add_action( $this->location , [$this, "location_notice_output"]);
            }


            
        }
    
        
        /**
         * Notice Output
         */
        public function notice_output(){
        ?>
            <div data-notice_id="<?php echo $this->notice_id; ?>" class='notice ca-notice notice-<?php echo esc_attr( $this->notice_type ); ?>'>
            <?php $this->notice_html(); ?>
            </div>
         <?php
        }
        /**
         * Notice Output
         */
        public function location_notice_output(){
        ?>
            <div data-notice_id="<?php echo $this->notice_id; ?>" class='anywhere-notice ca-notice notice-<?php echo esc_attr( $this->notice_type ); ?>'>
            <?php $this->notice_html(); ?>
            </div>
         <?php
        }

        private function notice_html( $args = array() )
        {

            if( ! is_array( $args ) ) return;
            ?>
            <div class="ca-notice-content">
                    <?php if( ! empty( $this->img ) ): ?>
                    <div class="ca-logo">
                        <a class="ca-logo-link" href="<?php echo esc_url( $this->img_target ); ?>" target="_blank">
                            <img src="<?php echo esc_attr( $this->img ); ?>" >
                        </a>
                        <button class="ca-notice-dismiss"></button>
                    </div>
                    <?php endif; ?>
                    
                    <div class="ca-msg-text">
                        
                        <?php if( ! empty( $this->title ) ): ?>
                            <h1><?php echo wp_kses_post( $this->title ); ?></h1>
                        <?php endif; ?> 

                        <?php if( ! empty( $this->message ) ): ?>
                        <p><?php echo wp_kses_post( $this->message ); ?></p>
                        <?php endif; ?> 
                        
                        <?php if( ! empty( $this->get_buttons() ) ): ?>
                        <p class="ca-links-collection">
                            <?php
                            foreach( $this->get_buttons() as $button ){
                               $type = is_string( $button['type'] ) ? $button['type'] : ''; 
                               $text = is_string( $button['text'] ) ? $button['text'] : ''; 
                               $target = is_string( $button['target'] ) ? $button['target'] : ''; 
                               $link = is_string( $button['link'] ) ? $button['link'] : '#'; 
                               ?>
                               <a class="ca-button ca-button-type-<?php echo esc_attr( $type ); ?>" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"><?php echo esc_html( $text ); ?></a>
                               <?php 
                            }
                            ?>
                        </p>
                        <?php endif; ?> 

                    </div>
                       
                    <button class="ca-notice-dismiss"></button>
            </div>
            
            <?php
        }
    
        
    }

}
