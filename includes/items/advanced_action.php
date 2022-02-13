<?php
woocommerce_template_single_add_to_cart();

$custom_var = new Pektsekye_ProductOptions_Block_Product_Options();
?>
<script type="text/javascript" id="wpt">

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

  jQuery.extend(config, optionData);

  jQuery('#pofw_product_options').pofwProductOptions(config);

</script>