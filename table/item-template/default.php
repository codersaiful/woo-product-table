<?php
/**
 * Content for Default
 * Here $item_keyword is a passed collumn keywork what user want to pass
 */
do_action( 'wpt_default_collumn_content', $item_keyword, $product, $POST_ID );

?>
<code>deflt: [<?php echo $item_keyword; ?>]</code>