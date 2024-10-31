<?php
/**
 * @since 2.0
 * Adds PCS_Widget widget.
 * @version 2.0.1
 */
class PCS_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'PCS_Widget', // Base ID
			__( 'PS Widget', 'pcs' ), // Name
			array( 'description' => __( 'Post Shortcode widget', 'pcs' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $pcs;
		$aft = $pcs->aft;
		$ars = $pcs->ars;
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			$as = (!empty($instance['titleurl'])) ? "<a href='".$instance['titleurl']."'>" : "" ;
			$ae = (!empty($instance['titleurl'])) ? "</a>" : "" ;
			echo $args['before_title'] . $as. apply_filters( 'widget_title', $instance['title'] ). $ae. $args['after_title'];
		}
		$shortcode = "[pcs";
		if( isset($instance['template']) && !empty($instance['template']) ) $shortcode .= " template='".$instance['template']."'";
		if( isset($instance['postno']) && !empty($instance['postno']) ) $shortcode .= " postcount='".$instance['postno']."'";
		if( isset($instance['showfield']) && !empty($instance['showfield']) ) $shortcode .= " showfield='".$instance['showfield']."'";
		if( isset($instance['postt']) && !empty( $instance['postt'] ) ) $shortcode .= " posttype='".$instance['postt']."'";
		if( isset($instance['categories']) && !empty( $instance['categories'] ) ) $shortcode .= " categories='".$instance['categories']."'";
		if( isset($instance['orderby']) && !empty($instance['orderby']) ) $shortcode .= " orderby='".$instance['orderby']."'";
		if( isset($instance['order']) && !empty($instance['order']) ) $shortcode .= " order='".$instance['order']."'";
		if( isset($instance['tsize']) && !empty($instance['tsize']) ) $shortcode .= " tsize='".$instance['tsize']."'";
		if( isset($instance['paged']) && !empty($instance['paged']) ) $shortcode .= " paged='".$instance['paged']."'";
		if( isset($instance['taxrel']) && !empty($instance['taxrel']) ) $shortcode .= " taxrel='".$instance['taxrel']."'";
		if( isset($instance['pagedvar']) && !empty($instance['pagedvar']) ) $shortcode .= " pagedvar='".$instance['pagedvar']."'";
		/* old version support code upto 2.0.5 */
		$readmoretitle = (isset($instance['readmoretitle']) && !empty($instance['readmoretitle'])) ? $instance['readmoretitle'] : "" ;
		if( isset($instance['rmt']) && !empty($instance['rmt']) &&  empty($readmoretitle) ) $shortcode .= " readmoretitle='".$instance['rmt']."'";

		$customfield = (isset($instance['customfield']) && !empty($instance['customfield'])) ? $instance['customfield'] : "" ;
		if( isset($instance['scf']) && !empty($instance['scf']) && empty($customfield)  ) $shortcode .= " customfield='".$instance['scf']."'";
		/* @since version 2.0.6 */
		foreach ($aft as $aftvalue => $aftkey ) {
		    if(isset($instance[$aftvalue]) && !empty($instance[$aftvalue])){
		        $shortcode .= " ".$aftvalue."='".$instance[$aftvalue]."'";
		    }
		}
		foreach ($ars as $arsvalue => $arskey ) {
		    if(isset($instance[$arsvalue]) && !empty($instance[$arsvalue])){
		        $shortcode .= " ".$arsvalue."='".$instance[$arsvalue]."'";
		    }
		}
		$shortcode .= "]";
		echo do_shortcode($shortcode);
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		global $pcs,$wp_version;
		$aob = $pcs->aob; 
		$asf = $pcs->asf;
		$aor = $pcs->aor;
		$atl = $pcs->atl;
		$ats = $pcs->ats;
		$atr = $pcs->atr;
		$arm = $pcs->arm;
		$aft = $pcs->aft;
		$ars = $pcs->ars;
		$apt = $pcs->pcs_get_all_post_name();
		$title =  (isset($instance['title']) && ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'pcs' );
		$titleurl =  (isset($instance['titleurl']) && ! empty( $instance['titleurl'] ) )? $instance['titleurl'] : "";
		$template =  (isset($instance['template']) && ! empty( $instance['template'] ) )? $instance['template'] :"ws";
		$postno =  (isset($instance['postno']) && ! empty( $instance['postno'] ) )? $instance['postno'] : "3";
		$showfield =  (isset($instance['showfield']) && ! empty( $instance['showfield'] ) )? $instance['showfield'] : 'title,thumbnail,excerpt';
		$postt =  (isset($instance['postt']) && ! empty( $instance['postt'] ) )? $instance['postt'] : "post";
		$categories =  (isset($instance['categories']) && ! empty( $instance['categories'] ) )? $instance['categories'] : "";
		$orderby =  (isset($instance['orderby']) && ! empty( $instance['orderby'] ) )? $instance['orderby'] : "modified";
		$order =  (isset($instance['order']) && ! empty( $instance['order'] ) )? $instance['order'] : "DESC";
		$tsize =  (isset($instance['tsize']) && ! empty( $instance['tsize'] ) )? $instance['tsize'] : "thumbnail";
		$paged =  (isset($instance['paged']) && ! empty( $instance['paged'] ) )? $instance['paged'] : 1;
		$taxrel =  (isset($instance['taxrel']) && ! empty( $instance['taxrel'] ) )? $instance['taxrel'] : "OR";
		$pagedvar =  (isset($instance['pagedvar']) && ! empty( $instance['pagedvar'] ) )? $instance['pagedvar'] : "";

		foreach ($aft as $aftvalue => $aftkey ) {
		    if(isset($instance[$aftvalue]) && !empty($instance[$aftvalue])){
		        $$aftvalue = $instance[$aftvalue]; 
		    }else{
		    	$$aftvalue = "";
		    }
		}
		foreach ($ars as $arsvalue => $arskey ) {
		    if(isset($instance[$arsvalue]) && !empty($instance[$arsvalue])){
		        $$arsvalue = $instance[$arsvalue];
		    }else{
		    	$$arsvalue = "";
		    }
		}
		/* old version support upto 2.0.5 */
		if(isset($instance['rmt']) && ! empty( $instance['rmt'] ) && isset($readmoretitle) && empty($readmoretitle) ) $readmoretitle =  $instance['rmt'];
		if(isset($instance['scf']) && ! empty( $instance['scf'] ) && isset($customfield) && empty($customfield) ) $customfield =  $instance['scf'];

		?>
		<div id="tabs-<?php echo $this->id; ?>" class="pcs-tabs" >
		<ul>
	       <li><a href="#tabs-<?php echo $this->id; ?>-1">Basic</a></li>
	       <li><a href="#tabs-<?php echo $this->id; ?>-2">Intermediate</a></li>
	       <li><a href="#tabs-<?php echo $this->id; ?>-3">Advance</a></li>
	    </ul>
	    <div id="tabs-<?php echo $this->id; ?>-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title :', 'pcs' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'titleurl' ); ?>"><?php _e( 'Title URL :', 'pcs' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'titleurl' ); ?>" name="<?php echo $this->get_field_name( 'titleurl' ); ?>" type="text" value="<?php echo esc_attr( $titleurl ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Template :', 'pcs' ); ?></label> 
			<select  class="widefat" id="<?php echo $this->get_field_id( 'template' ); ?>" name="<?php echo $this->get_field_name( 'template' ); ?>" >
				<?php $pcs->pcs_selected_option($atl,esc_attr($template)); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'postno' ); ?>"><?php _e( 'Number Of Post :', 'pcs' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'postno' ); ?>" name="<?php echo $this->get_field_name( 'postno' ); ?>" type="text" value="<?php echo esc_attr( $postno ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'showfield' ); ?>"><?php _e( 'Show Field :', 'pcs' ); ?></label> 
			<select  class="widefat" id="<?php echo $this->get_field_id( 'showfield' ); ?>" name="<?php echo $this->get_field_name( 'showfield' ); ?>[]" multiple >
				<?php 
					if(!empty($showfield)){
						$showfield = explode(",", $showfield);
					}else{
						$showfield = array();
					}
					$pcs->pcs_selected_option($asf,$showfield); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tsize' ); ?>"><?php _e( 'Thumbnail Size :', 'pcs'  ); ?></label> 
			<select  class="widefat" id="<?php echo $this->get_field_id( 'tsize' ); ?>" name="<?php echo $this->get_field_name( 'tsize' ); ?>" >
				<?php $pcs->pcs_selected_option($ats,esc_attr( $tsize )); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By :', 'pcs'  ); ?></label> 
			<select  class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" >
				<?php $pcs->pcs_selected_option($aob,esc_attr( $orderby )); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order :', 'pcs'  ); ?></label> 
			<select  class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" >
				<?php $pcs->pcs_selected_option($aor,esc_attr( $order )); ?>
			</select>
		</p>
		</div>
		<div id="tabs-<?php echo $this->id; ?>-2">
		<?php 
		if(!empty($ars) && is_array($ars)){
			foreach ($ars as $arsvalue => $arskey ) {
				?>
				<p>
				<label for="<?php echo $this->get_field_id( $arsvalue ); ?>"><?php echo $arskey; ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( $arsvalue ); ?>" name="<?php echo $this->get_field_name( $arsvalue ); ?>" type="text" value="<?php echo esc_attr( $$arsvalue ); ?>">
				</p>
				<?php
			}
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'postt' ); ?>"><?php _e( 'Post Type :', 'pcs' ); ?></label> 
			<select  class="widefat" id="<?php echo $this->get_field_id( 'postt' ); ?>" name="<?php echo $this->get_field_name( 'postt' ); ?>[]" multiple >
				<?php 
				if(!empty($postt)){
					$postt = explode(",", $postt);
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
					$(document).on("change","#<?php echo $this->get_field_id( 'postt' ); ?>",function(){
						$val = $(this).val();
						var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
						var data = {
						'action': 'pcs_get_cat',
						'postt': $val.toString(),
						'categories':"<?php echo $categories; ?>"
						};
						$.post(ajaxurl, data, function(response) {
							jQuery("#<?php echo $this->get_field_id( 'categories' ); ?>").html(response);
						});
					})				
				});
			</script> 
			<label for="<?php echo $this->get_field_id( 'categories' ); ?>"><?php _e( 'Categories :' , 'pcs' ); ?></label> 
			<?php $acs = $pcs->pcs_get_all_category($postt);
			//print_r($acs);
				if(!empty($categories)):
					$categories = explode(",", $categories);
				else:
					$categories = array();
				endif; ?>
			<select  class="widefat" id="<?php echo $this->get_field_id( 'categories' ); ?>" name="<?php echo $this->get_field_name( 'categories' ); ?>[]" multiple >
				<?php 
				foreach ($acs as $ckey => $cvalue) {
					foreach ($cvalue as $ck => $cv) {
						$cckey = $ckey."$".$cv->slug;
						?>
						<option value="<?php echo $cckey; ?>" <?php if(in_array( $cckey, $categories )  ) echo "selected"; ?>>
						<?php echo $cv->slug." ( ".$ckey." )"; ?>
						</option>
						<?php
					}
				} ?>
			</select>
		</p>
		</div>
		<div id="tabs-<?php echo $this->id; ?>-3">
		<p>
			<label for="<?php echo $this->get_field_id( 'paged' ); ?>"><?php _e( 'Paged ( Page Number ) :', 'pcs'  ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'paged' ); ?>" name="<?php echo $this->get_field_name( 'paged' ); ?>" type="text" value="<?php echo esc_attr( $paged ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'taxrel' ); ?>"><?php _e( 'Taxonomy Relation :', 'pcs'  ); ?><a href="<?php echo $arm['tqr']; ?>" target="_blank" ><?php  _e( 'Read More', 'pcs'  ); ?></a></label> 
			<select  class="widefat" id="<?php echo $this->get_field_id( 'taxrel' ); ?>" name="<?php echo $this->get_field_name( 'taxrel' ); ?>" >
				<?php $pcs->pcs_selected_option($atr,esc_attr( $taxrel )); ?>
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
				<label for="<?php echo $this->get_field_id( $aftvalue ); ?>"><?php echo $aftkey; ?><a href="<?php echo $arm['pp']; ?>" target="_blank" ><?php  _e( 'Read More', 'pcs'  ); ?></a></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( $aftvalue ); ?>" name="<?php echo $this->get_field_name( $aftvalue ); ?>" type="text" value="<?php echo esc_attr( $$aftvalue ); ?>">
				</p>
				<?php
			}
		}
		?>
		</div>
		</div>
		<script type="text/javascript">
		    jQuery(document).ready(function($){
		        $("#tabs-<?php echo $this->id; ?>").tabs();
		    });
		</script>
		<input class="widefat" id="<?php echo $this->get_field_id( 'pagedvar' ); ?>" name="<?php echo $this->get_field_name( 'pagedvar' ); ?>" type="hidden" value="<?php if(!empty($pagedvar)){ echo esc_attr( $pagedvar );}else{ echo uniqid();} ?>">
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		global $pcs;
		$aft = $pcs->aft;
		$ars = $pcs->ars;
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : __( 'Recent Posts', 'pcs' );
		$instance['titleurl'] = ( ! empty( $new_instance['titleurl'] ) ) ? strip_tags( $new_instance['titleurl'] ) : '';
		$instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : 'ws';
		$instance['postno'] = ( ! empty( $new_instance['postno'] ) ) ? strip_tags( $new_instance['postno'] ) : '3';
		$instance['showfield'] = ( ! empty( $new_instance['showfield'] ) ) ? strip_tags( implode(",", $new_instance['showfield']) ) : 'title,thumbnail,excerpt';
		$instance['postt'] = ( ! empty( $new_instance['postt'] ) ) ? strip_tags( implode(",", $new_instance['postt']) ) : 'post';
		$instance['categories'] = ( ! empty( $new_instance['categories'] ) ) ? strip_tags( implode(",", $new_instance['categories']) ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : 'modified';
		$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : 'DESC';
		$instance['tsize'] = ( ! empty( $new_instance['tsize'] ) ) ? strip_tags( $new_instance['tsize'] ) : 'thumbnail';
		$instance['paged'] = ( ! empty( $new_instance['paged'] ) ) ? strip_tags( $new_instance['paged'] ) : 1;
		$instance['taxrel'] = ( ! empty( $new_instance['taxrel'] ) ) ? strip_tags( $new_instance['taxrel'] ) : 'OR';
		$instance['pagedvar'] = ( ! empty( $new_instance['pagedvar'] ) ) ? strip_tags( $new_instance['pagedvar'] ) : '';
		foreach ($aft as $aftvalue => $aftkey ) {
		    if(isset($new_instance[$aftvalue]) && !empty($new_instance[$aftvalue])){
		        $instance[$aftvalue] = strip_tags( $new_instance[$aftvalue] );
		    }else{
		    	$instance[$aftvalue] = "";
		    }
		}
		foreach ($ars as $arsvalue => $arskey ) {
		    if(isset($new_instance[$arsvalue]) && !empty($new_instance[$arsvalue])){
		        $instance[$arsvalue] = strip_tags( $new_instance[$arsvalue] );
		    }else{
		    	$instance[$arsvalue] = "";
		    }
		}
		return $instance;
	}

} // class PCS_Widget