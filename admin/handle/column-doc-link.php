<?php
namespace WOO_PRODUCT_TABLE\Admin\Handle;

use WOO_PRODUCT_TABLE\Core\Base;

/**
 * To add documentation links in the column basic form.
 * 
 * specially from 3.4.8.0
 * If we want to Doc or tutorial link for any column,
 * You have to add link using $links array.
 * see inside run method.
 * 
 * there is also an example available for Custom Link.
 * 
 * @author Saiful Islam <codersaiful@gmail.com>
 * 
 * @since 3.4.8.0
 * 
 * @package WOO_PRODUCT_TABLE
 */
class Column_Doc_Link extends Base 
{
    public $links = [];

    /**
     * Initializes the links array and adds an action to display the document links in the column basic form.
     *
     * @return void
     */
    public function run()
    {
        $this->links = [
            'audio' => [
                [
                    'title' => 'Tutorial - How can create?',   
                    'url' => 'https://wooproducttable.com/docs/doc/tutorials/how-to-create-a-audio-table-using-woo-product-table/',
                ],
                [
                    'title' => 'Demo Table',
                    'url' => 'https://demo.wooproducttable.com/demo-list/audio-table/',
                ]
            ],

            'all_content' => [
                [
                    'title' => 'Tutorial - How to use?',   
                    'url' => 'https://wooproducttable.com/docs/doc/advance-uses/add-multiple-content-column/',
                ],
            ],


            'variation_name' => [
                [
                    'title' => 'Tutorial - How to create variation?',   
                    'url' => 'https://wooproducttable.com/docs/doc/table-options/show-variation-name-in-a-single-column/',
                ],
                [
                    'title' => 'Explore Demo',   
                    'url' => 'https://demo.wooproducttable.com/',
                ],
            ],
            
            // ekhane column type or column keyword diye dite hobe

            //Example for Custom Link
            // 'type_or_column_keyword' => [
            //     [
            //         'title' => 'Tutoiral Doc',
            //         'url' => 'https://wooproducttable.com/sample-doc/',
            //     ]
            // ],

            // 'product_title' => [
            //     [
            //         'title' => 'Tutoiral - How can create?',   
            //         'url' => 'https://wooproducttable.com/docs/doc/tutorials/how-to-create-a-audio-table-using-woo-product-table/',
            //     ],
            //     [
            //         'title' => 'Demo Table',
            //         'url' => 'https://demo.wooproducttable.com/demo-list/audio-table/',
            //     ]
            // ],
        ];
        add_action( 'wpto_column_basic_form', [$this, 'add_doc_link'], 10, 3 );
        // add_action( 'wpto_column_setting_form', [$this, 'add_doc_link'], 10, 3 );

    }

    public function add_doc_link( $keyword, $_device_name, $column_settings )
    {
        if( empty( $column_settings['type'] )) return;
        $target_keyword =  $column_settings['type'] == 'default' ? $keyword : $column_settings['type'];

        if( ! isset($this->links[$target_keyword]) || ! is_array( $this->links[$target_keyword] ) ) return;

        $this->links[$target_keyword] = apply_filters( 'wpt_pro_column_doc_link', $this->links[$target_keyword], $target_keyword, $_device_name, $column_settings );

        if( empty( $this->links[$target_keyword] ) ) return;
        
        $docs = $this->links[$target_keyword];
        if( ! isset( $docs[0]['title'] ) ) return;
        foreach( $docs as $doc ) {
            $title = $doc['title'] ?? 'Doc';
            $url = $doc['url'] ?? '#';
            ?>
             🌐 <a href="<?php echo esc_url( $url ); ?>" title="Tutorial for <?php echo esc_attr( $target_keyword ); ?>" target="_blank"><?php echo esc_html( $title ); ?></a> 
            <?php

        }
        ?>
        
        <?php 
    }
}