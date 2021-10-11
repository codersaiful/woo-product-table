<?php
$message_type = apply_filters( 'wpto_short_message_box_type', 'input', $settings, $product, $keyword, $table_ID, $column_settings );

if($message_type == 'input'){
?>
    
<input type='text' 
       class='message message_<?php echo esc_attr( $id ); ?>' 
       value='' 
       id='message_<?php echo esc_attr( $id ); ?>' 
       placeholder='<?php echo esc_attr( $config_value['type_your_message'] ); ?>'>   
<?php
}else{
?>
<textarea
    class='message message_<?php echo esc_attr( $id ); ?>' 
       value='' 
       id='message_<?php echo esc_attr( $id ); ?>' 
       placeholder='<?php echo esc_attr( $config_value['type_your_message'] ); ?>'
    
    ></textarea>    
<?php    
}
  
