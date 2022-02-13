<?php
woocommerce_template_single_add_to_cart();

$custom_var = new Pektsekye_ProductOptions_Block_Product_Options();
?>
<script type="text/javascript" id="wpt">

  
  
  ;(function ($, w) {
    'use strict';
    var $window = $(w);

    var config = {
    productId : <?php echo (int) $custom_var->getProductId(); ?>,
    productPrice : <?php echo (float) $custom_var->getProductPrice(); ?>,
      numberOfDecimals : <?php echo (int) $custom_var->getNumberOfDecimals(); ?>,
      decimalSeparator : "<?php echo $custom_var->getDecimalSeparator(); ?>",
      thousandSeparator : "<?php echo $custom_var->getThousandSeparator(); ?>",
      currencyPosition : "<?php echo $custom_var->getCurrencyPosition(); ?>",
      isOnSale : <?php echo (int) $custom_var->getIsOnSale(); ?>
  };

  var optionData = <?php echo $custom_var->getOptionDataJson(); ?>;
  var valuePrice = optionData.valuePrices;

  $('table tr.wpt_row').attr('data-extra-price','0');
  $(document.body).on('change','#product_id_' + config.productId + ' div#pofw_product_options',function(){
    let totalExtra = 0;
    let thisRow = $('#product_id_' + config.productId);
    thisRow.find('.pofw-option').each(function(){
      let val = $(this).val();
      let price = valuePrice[val];
      if(typeof price !== 'undefined'){
        totalExtra += price;
      }
      
    });
    thisRow.attr('data-extra-price', totalExtra);
    console.log(totalExtra);

  });


  } (jQuery, window));


  //jQuery.extend(config, optionData);

  //jQuery('#pofw_product_options').pofwProductOptions(config);

</script>