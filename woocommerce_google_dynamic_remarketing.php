<?php
/**
 * send remarketing data to goodle ads
 * gtag is not included and must be installed on site prior to this running
 * Add snippet to functions.php
 * Replace $adwords_id and $gtag_tracking_id with your values
 * 
 * By Brandyn Lordi
 * https://github.com/BrandynL
 */

// if global site tag not installed, enable this action:
// add_action('wp_head', 'g_gtag');
function g_gtag(){ 
	$gtag_tracking_id = 'XXX'
	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	
	gtag('config', '<?= $gtag_tracking_id; ?>');
	</script>
<?php }
// end gtag

add_action('wp_footer','fk_google_dynamic_remarketing');
function fk_google_dynamic_remarketing(){ 
  $adwords_id = 'AW-XXXXXXXX';
?>
<!-- dynamic google remarketing event tag -->
<script>
  gtag('event', 'page_view', {'send_to': '<?= $adwords_id; ?>',
  <?php
  if(is_product()){
    echo "'ecomm_prodid': '".get_the_ID()."',";
  }
   $page_type = '';
   if(is_product_category() || is_product_tag()){$page_type ='category';}
   else if(is_product()){$page_type ='product';}
   else if(is_cart()){$page_type ='cart';}
   else if(is_search()){$page_type ='search-results';}
   else if(is_checkout()){$page_type ='checkout';}
   else if(is_wc_endpoint_url('order-received')){$page_type ='successful-purchase';}
   else{$page_type ='non-shopping-page';}
   ?>
   'ecomm_pagetype': '<?php echo $page_type; ?>',
   <?php
   if(is_product()){
    $_product = wc_get_product( get_the_ID() );
       echo "'ecomm_totalvalue': '".$_product->get_price()."'";
       echo "'ecomm_prodid': '".get_the_id()."'";
   }
   ?>
  });
</script>
<?php }
