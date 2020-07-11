<?php 

$head = WPT_TABLE::get_head();

$tr_class = isset( $datas['thead_class'] ) ? $datas['thead_class'] : 'wpt_table_head';
$tr_class_arr = array(
    'th_post_id_' . $POST_ID,
    'wpt_table_head',
    'th_' . $datas['id'],
    $tr_class,
);
$tr_class = implode(" ", $tr_class_arr);
?>
<thead>
    <tr class="<?php echo esc_attr( $tr_class );
    ?>">

    <?php
    foreach( $head as $h_col_no => $h_column ){
        $tag = isset( $h_column['tag'] ) ? $h_column['tag'] : false;
        $content = isset( $h_column['content'] ) ? $h_column['content'] : false;
        $class = isset( $h_column['class'] ) ? $h_column['class'] : false;
        $class .= " " . "column_{$POST_ID}_" . $h_col_no . ' collumn_no_' . $h_col_no;
        $attribute = isset( $h_column['attribute'] ) ? $h_column['attribute'] : false;
        $all_attributes = false;
        if( is_array( $attribute ) && count( $attribute ) > 0 ){
            foreach( $attribute as $attr_key => $attr_value ){
                $all_attributes .= "{$attr_key}='" . esc_attr( $attr_value ) . "' ";
            }
        }
        $tag_start = $tag ? "<$tag>" : false;
        $tag_end = $tag ? "</$tag>" : false;
        
        $h_total_content = $tag_start . do_shortcode( $content ) . $tag_end;
        
        $h_total_content = apply_filters( 'wpt_th_content',$h_total_content, $h_col_no, $POST_ID );
    ?>
        <th data-col_no='<?php echo esc_attr( $h_col_no ); ?>' 
            data-post_id='<?php echo esc_attr( $POST_ID ); ?>'
            class="<?php echo esc_attr( $class ); ?>" <?php echo $all_attributes; ?>>
                <?php echo $h_total_content; ?>
        </th>
    <?php
    }
    ?>
    </tr>
</thead>