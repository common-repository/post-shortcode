<?php 
/**
* @since 2.0
* Adds ajax function.
* @version 2.0.1
*/
add_action( 'wp_ajax_pcs_get_cat', 'pcs_get_cat_callback' );
//add_action( 'wp_ajax_nopriv_pcs_get_cat', 'pcs_get_cat_callback' ); change in 2.0.5
function pcs_get_cat_callback() {
	global $pcs;
	$postt = explode(",", $_POST['postt']);
	$categories = explode(",", $_POST['categories']);
    $acs = $pcs->pcs_get_all_category($postt);
	foreach ($acs as $ckey => $cvalue) {
		foreach ($cvalue as $ck => $cv) {
			$cckey = $ckey."$".$cv->slug;
			?>
			<option value="<?php echo $cckey; ?>" <?php if(in_array( $cckey, $categories )  ) echo "selected"; ?>>
			<?php echo $cv->slug." ( ".$ckey." )"; ?>
			</option>
			<?php
		}
	} 
	wp_die();
}
?>