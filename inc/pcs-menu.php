<?php
/**
* @since 2.0
* Add menu page
*/
function fn_pcs_menu()
{
?>
<div class="wrap">
	<h2>Post Shortcode</h2>
</div>
<?php 
	/**
	* pcs object
	*/
	global $pcs,$wp_version;
	$aob = $pcs->aob; 
	$asf = $pcs->asf;
	$aor = $pcs->aor;
	$atl = $pcs->atl;
	$ats = $pcs->ats;
	$atr = $pcs->atr;
	$aft = $pcs->aft;
	$ars = $pcs->ars;
	$arm = $pcs->arm;
	$apt = $pcs->pcs_get_all_post_name();
	/**
	* Edit css save code
	*/
	$nonceval = md5( get_option("admin_email","you_are_less_secure") );
	if( isset($_POST['pcscss01101989']) && wp_verify_nonce( $_POST['nonce_of_pcs'], $nonceval ) ){

		    $_POST = array_filter($_POST,"sanitize_text_field");
		    $pcscss01101989 = ( isset($_POST['pcscss01101989']) && !empty($_POST['pcscss01101989'])) ? $_POST['pcscss01101989'] : "";

		if( update_option("pcscss01101989",stripslashes( trim( $pcscss01101989 ) ) ) ){
			?>
			<div class="updated notice is-dismissible"><p>CSS updated successfully....</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
			<?php
		}else{
			?>
			<div class="error notice is-dismissible"><p>Something went wrong.... OR ( May your CSS has not changed or edited. )</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
			<?php
		}
	
	} ?>
<div class="clear"></div>
<div id="col-container">
	<div id="col-right">
		<div class="pcs-div">
		<?php $postt = $categories = $showfield = $template = $orderby = $order = $tsize = $taxrel = "";
			if( isset($_POST['pcs-code']) && wp_verify_nonce( $_POST['nonce_of_pcs'], $nonceval ) ){
				if( isset($_POST['showfield']) && !empty($_POST['showfield'])) $showfield = implode(",", $_POST['showfield']);
				if( isset($_POST['postt']) && !empty($_POST['postt'])) $postt = implode(",", $_POST['postt']);
				if( isset($_POST['categories']) && !empty($_POST['categories'])) $categories = implode(",", $_POST['categories']);
				$shortcode = "[pcs";
				if( isset($_POST['template']) && !empty($_POST['template'])){
					$shortcode .= " template='".$_POST['template']."'";
					$template = sanitize_text_field($_POST['template']);
				}
				if( isset($_POST['postno']) && !empty($_POST['postno'])) $shortcode .= " postcount='".$_POST['postno']."'";
				if(!empty($showfield)) $shortcode .= " showfield='".$showfield."'";
				if(!empty( $postt )) $shortcode .= " posttype='".$postt."'";
				if(!empty( $categories )) $shortcode .= " categories='".$categories."'";
				if( isset($_POST['orderby']) && !empty($_POST['orderby'])){
					$shortcode .= " orderby='".$_POST['orderby']."'";
					$orderby = sanitize_text_field($_POST['orderby']);
				}
				if( isset($_POST['order']) && !empty($_POST['order'])){
					$shortcode .= " order='".$_POST['order']."'";
					$order = sanitize_text_field($_POST['order']);
				}
				if( isset($_POST['tsize']) && !empty($_POST['tsize'])){
					$shortcode .= " tsize='".$_POST['tsize']."'";
					$tsize = sanitize_text_field($_POST['tsize']);
				}
				if( isset($_POST['paged']) && !empty($_POST['paged'])) $shortcode .= " paged='".$_POST['paged']."'";
				if( isset($_POST['taxrel']) && !empty($_POST['taxrel'])){
					$shortcode .= " taxrel='".$_POST['taxrel']."'";
					$taxrel = sanitize_text_field($_POST['taxrel']);
				}
				if(!empty($aft) && is_array($aft)){
					foreach ($aft as $aftvalue => $aftkey ) {
					    if(isset($_POST[$aftvalue]) && !empty($_POST[$aftvalue])){
					        $shortcode .= " ".$aftvalue."='".$_POST[$aftvalue]."'";
					    }
					}
				}
				if(!empty($ars) && is_array($ars)){
					foreach ($ars as $arsvalue => $arskey) {
					    if(isset($_POST[$arsvalue]) && !empty($_POST[$arsvalue])){
					        $shortcode .= " ".$arsvalue."='".$_POST[$arsvalue]."'";
					    }
					}
				}
				if( isset($_POST['pagedvar']) && !empty($_POST['pagedvar'])){
					$shortcode .= " pagedvar='".$_POST['pagedvar']."'";
				}
				$shortcode .= "]";
				echo "<h3>Generated Shortcode :</h3><textarea readonly class='pcs-ta'>". $shortcode."</textarea>";
			}
		?>
		</div>
		<div class="pcs-div">
			<h3>Edit CSS</h3>
			<form method="post">
				<textarea class='pcs-ta' name="pcscss01101989" 	><?php if(get_option("pcscss01101989")){
						echo get_option("pcscss01101989");
					}else{
						?>
/* pcs style */

.pcs-reset{line-height: 1.7em;margin-bottom: 3px;}
.pcs-main{overflow: hidden;padding: 10px !important;}
.pcs-sub:first-child {margin-top: 0;}
.pcs-sub{margin-top: 15px;padding-right: 10px;clear: both;display: block;}
.pcs-sub,.pcs-body{overflow: hidden;}
.pcs-img,.pcs-body{display: block;vertical-align: top;box-sizing: border-box;}
.pcs-body {width: 60%;float: left;}
.pcs-img{float: left;width: 30%;margin: 0 10px 10px 0!important;}
.pcs-title{font-size: 15px;display: block;padding: 0px;margin: 0px;margin-bottom: 5px;}
.pcs-excerpt{font-size: 13px;text-align: justify;display: block;}
.pcs-content{font-size: 12px;text-align: justify;display: block;}
.pcs-meta{display: block;font-size: 12px;float: left;}
.pcs-meta a{font-size: 12px !important;}
.pcs-rm{font-size: 15px;display: inline-block;clear: both;text-align: left;}
.pcs-img img{max-width: 100%;max-height: 100%;margin: 0 auto;}
.pcsmeta{float: left;padding-right: 10px;display: inline-block;}
.pcs-meta .glyphicon{margin-right: 3px;}
.pcs-cust-field{display: block;clear: both;}

/* pcs style for Widget Style as ws and Grid Widget Style as gws */

.ws .pcs-sub,.gws .pcs-sub{border-bottom: 1px solid #777;}
.ws .pcs-title a,.gws .pcs-title a{color: #222;}
.ws .pcs-excerpt,.gws .pcs-excerpt{color: #333;}
.ws .pcs-content,.gws .pcs-content{color: #444;}
.ws .pcs-meta,.ws .pcs-meta a,.gws .pcs-meta,.gws .pcs-meta a{color: #555;}
.ws .pcs-rm,.gws .pcs-rm{color: #666;}
.ws a:hover,.gws a:hover{color: #000 !important;}

/* pcs style for Inverse Widget Style as iws and Inverse Grid Widget Style as igws */

.iws.pcs-main,.igws.pcs-main{background-color: #333;}
.iws .pcs-sub,.igws .pcs-sub{border-bottom: 1px solid #777;}
.iws .pcs-title a,.igws .pcs-title a{color: #eee;}
.iws .pcs-excerpt,.igws .pcs-excerpt{color: #ddd;}
.iws .pcs-content,.igws .pcs-content{color: #ddd;}
.iws .pcs-meta,.iws .pcs-meta a,.igws .pcs-meta,.igws .pcs-meta a{color: #ccc;}
.iws .pcs-rm,.igws .pcs-rm{color: #eee !important;}
.iws a:hover,.igws a:hover{color: #fff !important;}

/* pcs style for Grid Widget Style as gws and Inverse Grid Widget Style as igws*/

.gws .pcs-body,.igws .pcs-body,.gcore .pcs-body{width: 100%;}
.gws .pcs-img,.igws .pcs-img,.gcore .pcs-img{width: 100%}

/* pcs style for pagination */

.pcs-pagination{display: block;clear:both;overflow: hidden;}
.pcs-pagination ul {display: inline-block;padding: 0;margin: 10px 1px;border-radius: 50%;list-style-type: none;}
.pcs-pagination ul li {float: left}
.pcs-pagination ul li a,.pcs-pagination ul li span{float: left;padding: 10px 15px;line-height: 1.5;color: #0275d8;text-decoration: none;background-color: #fff;border: 1px solid #ddd;display: block;margin-left: -1px}
.pcs-pagination ul li a:hover,.pcs-pagination ul li span.current{background-color: #0275d8;color: #fff;}
				<?php } ?></textarea>
				<?php wp_nonce_field( $nonceval, 'nonce_of_pcs' ); ?>
				<p class="submit"><input type="submit" name="pcs-css" class="button button-primary" value="Save CSS"></p>
			</form>
		</div>
		<div id="welcome-panel" class="welcome-panel pcs-div">
			<div class="welcome-panel-content">
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h3>Do you like it?</h3>
						<a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://wordpress.org/support/view/plugin-reviews/post-shortcode" target="_blank">Rate me</a>
						<a class="button button-primary button-hero hide-if-customize" href="https://wordpress.org/support/view/plugin-reviews/post-shortcode" target="_blank">Rate me</a>
						<p class="hide-if-no-customize">or, <a href="https://wordpress.org/plugins/post-shortcode/faq" target="_blank">FAQ</a> | <a href="https://wordpress.org/support/plugin/post-shortcode" target="_blank">Support</a></p>
						<h3>Add On</h3>
						<p><a href="https://sachin8600.wordpress.com/2017/10/20/in-5-minute-create-your-wordpress-plugin-using-post-shortcode-plugin/" target="_blank">More Info</a></p>
					</div>
					<div class="welcome-panel-column">
						<h3>Change Layout</h3>
						<ul>
							<li><div class="welcome-icon welcome-widgets-menus">Do you want to change the layout of shortcode or widget output, ( Like you want to add bootstrap layout. ) then you can copy function pcs_get_post_output() from the plugin folder post-shortcode/inc/pcs-shortcode.php file, then paste it into your theme functions.php file and rename function name as pcs_get_custom_post_output().</div></li>
						</ul>
					</div>
					<div class="welcome-panel-column welcome-panel-last">
						<h3>Revert CSS</h3>
						<ul>
							<li><div class="welcome-icon welcome-widgets-menus">Do you want to revert plugin css, you can do it by empty the textarea and click on `Save CSS` button.</div></li>
						</ul>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<div id="col-left">
		<form method="post">
		<div id="tabs-10011989"  class="pcs-tabs pcs-page-tabs" >
		<ul>
	       <li><a href="#tabs-10011989-1">Basic</a></li>
	       <li><a href="#tabs-10011989-2">Intermediate</a></li>
	       <li><a href="#tabs-10011989-3">Advance</a></li>
	    </ul>
	    <div id="tabs-10011989-1">
		<p>
		<label for="template"><?php _e( 'Template :', 'pcs' ); ?></label> 
		<select  class="widefat" id="template" name="template" >
			<?php $pcs->pcs_selected_option($atl,esc_attr($template)); ?>
		</select>
		</p>
		<p>
		<label for="postno"><?php _e( 'Number Of Post :', 'pcs' ); ?></label> 
		<input class="widefat" id="postno" name="postno" type="text" value="<?php if( isset($_POST['postno'])) echo esc_attr( $_POST['postno'] ); ?>">
		</p>
		<p>
		<label for="showfield"><?php _e( 'Show Field :', 'pcs' ); ?></label> 
		<select  class="widefat" id="showfield" name="showfield[]" multiple >
			<?php 
				if( isset($_POST['showfield']) && !empty($_POST['showfield'])){
					$showfield = $_POST['showfield'];
				}
				else{
					$showfield = array();
				}
				$pcs->pcs_selected_option($asf,$showfield); 
			?>
		</select>
		</p>
		<p>
		<label for="tsize"><?php _e( 'Thumbnail Size :', 'pcs'  ); ?></label> 
		<select  class="widefat" id="tsize" name="tsize" >
			<?php $pcs->pcs_selected_option($ats,$tsize); ?>
		</select>
		</p>
		<p>
		<label for="orderby"><?php _e( 'Order By :', 'pcs'  ); ?></label> 
		<select  class="widefat" id="orderby" name="orderby" >
			<?php $pcs->pcs_selected_option($aob,$orderby); ?>
		</select>
		</p>
		<p>
		<label for="order"><?php _e( 'Order :', 'pcs'  ); ?></label> 
		<select  class="widefat" id="order" name="order" >
			<?php $pcs->pcs_selected_option($aor,$order); ?>
		</select>
		</p>
		</div>
		<div id="tabs-10011989-2">
		<?php
			if(!empty($ars) && is_array($ars)){
				foreach ($ars as $arsvalue => $arskey ) {
				    ?>
				    <p>
				    <label for="<?php echo $arsvalue; ?>"><?php echo $arskey; ?></label> 
				    <input class="widefat" id="<?php echo $arsvalue; ?>" name="<?php echo $arsvalue; ?>" type="text" value="<?php if(isset($_POST[$arsvalue])) echo esc_attr( $_POST[$arsvalue] ); ?>" />
				    </p>
				    <?php
				}
			}
		?>
		<p>
		<label for="postt"><?php _e( 'Post Type :', 'pcs' ); ?></label> 
		<select  class="widefat" id="postt" name="postt[]" multiple >
			<?php 
			if(isset( $_POST['postt']) && !empty( $_POST['postt'])){
				$postt = $_POST['postt'];
			}else{
				$postt = array();
			}
			$pcs->pcs_selected_option($apt,$postt); 
			?>
		</select>
		</p>
		<p>
		<script type="text/javascript" >
			jQuery(document).ready(function($) {
				$(document).on("change","#postt",function(){
					$val = $(this).val();
					var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
					var data = {
					'action': 'pcs_get_cat',
					'postt': $val.toString(),
					'categories':"<?php echo $categories; ?>"
					};
					$.post(ajaxurl, data, function(response) {
						jQuery("#categories").html(response);
					});
				})				
			});
		</script> 
		<label for="categories"><?php _e( 'Categories :' , 'pcs' ); ?></label> 
		<?php $acs = $pcs->pcs_get_all_categories($postt);
			if(isset($_POST['categories']) && !empty($_POST['categories']))
			{
				$categories = $_POST['categories'];
			}else{
				$categories = array();
			} ?>
		<select  class="widefat" id="categories" name="categories[]" multiple >
			<?php $pcs->pcs_selected_option($acs,$categories); ?>
		</select>
		</p>
		</div>
		<div id="tabs-10011989-3">
		<p>
		<label for="paged"><?php _e( 'Paged ( Page Number ) :', 'pcs'  ); ?></label> 
		<input class="widefat" id="paged" name="paged" type="text" value="<?php if(isset($_POST['paged'])) echo esc_attr( $_POST['paged'] ); ?>">
		</p>
		<p>
		<label for="taxrel"><?php _e( 'Taxonomy Relation :', 'pcs'  ); ?></label> 
		<select  class="widefat" id="taxrel" name="taxrel" >
			<?php $pcs->pcs_selected_option($atr,$taxrel); ?>
		</select>
		</p>
		<?php
			if(!empty($aft) && is_array($aft)){
				foreach ($aft as $aftvalue => $aftkey ) {
					if ( $aftvalue == "post_name__in" && $wp_version < 4.4 ) {
						continue;
					}
				    ?>
				    <p>
				    <label for="<?php echo $aftvalue; ?>"><?php echo $aftkey; ?><a href="<?php echo $arm['pp']; ?>" target="_blank" ><?php  _e( 'Read More', 'pcs'  ); ?></a></label> 
				    <input class="widefat" id="<?php echo $aftvalue; ?>" name="<?php echo $aftvalue; ?>" type="text" value="<?php if(isset($_POST[$aftvalue])) echo esc_attr( $_POST[$aftvalue] ); ?>" />
				    </p>
				    <?php
				}
			}
		?>
		<p>
		</div>
		</div>
		<script type="text/javascript">
		    jQuery(document).ready(function($){
		        $("#tabs-10011989").tabs();
		    });
		</script>
		
		<p class="submit">
			<?php wp_nonce_field( $nonceval, 'nonce_of_pcs' ); ?>
			<input type="hidden" name="pagedvar" value="<?php echo uniqid(); ?>" />
			<input type="submit" name="pcs-code" id="submit" class="button button-primary" value="Generate Shortcode">
		</p>
		</form>
	</div>
</div>
	<?php
}
?>