<?php
$validation = apply_filters( 'wpt_notfound_validation', true );
if(!$validation){
    return;
}
do_action( 'wpt_notfound_start' );
?>
<div class="wpt_notfound">
    <?php echo $notfound; ?>
</div>
