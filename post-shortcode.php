<?php 
/**
 * Plugin Name: Post Shortcode
 * Plugin URI: 
 * Description: This plugin is used for display posts in widget as well as shortcode.
 * Version: 2.0.9
 * Author: Sachin Jadhav
 * Author URI: http://sachin8600.wordpress.com/
 * Requires at least: 3.8
 * Tested up to: 4.8.2
 *
 * Text Domain: pcs
 * Domain Path: /languages/
 *
 * @package pcs
 * @author 
 */ 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'PostCustomize' ) ) :
/**
 * Main PostCustomize Class
 *
 * @class PostCustomize
 * @version	1.0.0
 */
final class PostCustomize {
	/**
	 * @var string of version
	 */
	public $version = '2.0.9';
	/**
	 * @var array of order by wp_query
	 * @since 2.0.5
	 */
	public $aob = array();
	/**
	 * @var array of pcs theme
	 * @since 2.0.5
	 */
	public $atl = array();
	/**
	 * @var array of show fields
	 * @since 2.0.5
	 */
	public $asf = array();
	/**
	 * @var array of post order
	 * @since 2.0.5
	 */
	public $aor = array(); 
	/**
	 * @var array of thumbnail sizes
	 * @since 2.0.5
	 */
	public $ats = array(); 
	/**
	 * @var array of taxonomy  qurey relation
	 * @since 2.0.5
	 */
	public $atr = array(); 
	/**
	 * @var array of read more
	 * @since 2.0.6
	 */
	public $arm = array(	
							"tqr" 	=> "https://codex.wordpress.org/Class_Reference/WP_Query#Taxonomy_Parameters",
							"pp" 	=> "https://codex.wordpress.org/Class_Reference/WP_Query#Post_.26_Page_Parameters",			
						); 
	/**
	 * @var array of text field of post parameter
	 * @since 2.0.6
	 */
	public $aft = array();
	/**
	 * @var array of select field of related post
	 * @since 2.0.6
	 */
	public $ars = array();
	/**
	 * @var PostCustomize The single instance of the class
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * Main PostCustomize Instance
	 *
	 * Ensures only one instance of PostCustomize is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @see pcs()
	 * @return PostCustomize - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * Cloning is forbidden.
	 * @since 1.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'pcs' ), '1.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 * @since 1.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'pcs' ), '1.0' );
	}


	/**
	 * PostCustomize Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Hook into actions and filters
	 * @since  1.0
	 */
	private function init_hooks() {
		// enque js css to front end commented on 2.0.4 version
		//add_action('wp_enqueue_scripts', array($this,'pcs_style_script') );
		//enque js css to backend end
		add_action('admin_enqueue_scripts', array($this,'pcs_admin_style_script') );
		//add tiny editor button
		//add_action('admin_head', array($this,'pcs_add_tiny_editor_button') );
		//add menu page
		add_action( 'admin_menu', array($this,'register_pcs_shortcode_menu_page') );
		//add widget 
		add_action( 'widgets_init', array($this,'register_pcs_widget') );
		//add plugin page link
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__),  array($this,'pcs_plugin_action_links') );
		//add css before head tag close
		add_action( 'wp_head', array($this,'pcs_add_header_css') );

	}

	/**
	 * Define pcs Constants
	 */
	private function define_constants() {
		// define constants 
		$this->define( 'PCS_DIR', plugin_dir_path( __FILE__ ) );
		$this->define( 'PCS_URL',plugin_dir_url( __FILE__ ) );
		$this->define( 'PCS_CSS_URL',PCS_URL."css/" );
		$this->define( 'PCS_JS_URL',PCS_URL."js/" );
		$this->define( 'PCS_IMG_URL',PCS_URL."images/" );
		$this->define( 'PCS_VERSION', $this->version );

		// array of text field of post parameter
		$this->aft['post_parent__in'] 		= __( 'Post Parent In ( eg: 10,1,89 ) :', 'pcs'  );
		$this->aft['post_parent__not_in'] 	= __( 'Post Parent Not In ( eg: 10,1,89 ) :', 'pcs'  );
		$this->aft['post__in'] 				= __( 'Post In ( eg: 10,1,89 ) :', 'pcs'  );
		$this->aft['post__not_in'] 			= __( 'Post Not In ( eg: 10,1,89 ) :', 'pcs'  );
		$this->aft['post_name__in'] 		= __( 'Post Name In ( eg: hello-world,sample-page ) :', 'pcs'  );

		// array of select field of related post
		$this->ars['excerptl'] 		= __( 'Excerpt Length ( In words, eg: 55 ) :', 'pcs' );
		$this->ars['readmoretitle'] = __( 'Read More Title ( eg: Read more ) :', 'pcs'  );
		$this->ars['customfield'] 	= __( 'Show Custom Fields ( Comma Separated ) :', 'pcs'  );

		// array of theme 
		$this->atl['ws'] 	= __( 'Widget Style', 'pcs'  );
		$this->atl['iws'] 	= __( 'Inverse Widget Style', 'pcs'  );
		$this->atl['gws'] 	= __( 'Grid Widget Style', 'pcs'  );
		$this->atl['igws'] 	= __( 'Inverse Grid Widget Style', 'pcs'  );
		$this->atl['core'] 	= __( 'Core Widget Style', 'pcs'  );
		$this->atl['gcore'] = __( 'Core Grid Widget Style', 'pcs'  );
		
		// array of show fields
		$this->asf['title'] 	 = __( 'Show Title', 'pcs'  );
		$this->asf['thumbnail']  = __( 'Show Thumbnail', 'pcs'  );
		$this->asf['excerpt'] 	 = __( 'Show Excerpt', 'pcs'  );
		$this->asf['date'] 		 = __( 'Show Published Date', 'pcs'  );
		$this->asf['author'] 	 = __( 'Show Post Author', 'pcs'  );
		$this->asf['cc'] 		 = __( 'Show Comments Count', 'pcs'  );
		$this->asf['content']	 = __( 'Show Content', 'pcs'  );
		$this->asf['readme'] 	 = __( 'Show Read More Link', 'pcs'  );
		$this->asf['category'] 	 = __( 'Show Post Categories', 'pcs'  );
		$this->asf['tag'] 		 = __( 'Show Post Tags', 'pcs'  );			
		$this->asf['pagination'] = __( 'Show Pagination', 'pcs'  );		
		// array of post order
	 	$this->aor['DESC'] 	= __( 'Descending order from highest to lowest values ', 'pcs'  );			
		$this->aor['ASC'] 	= __( 'Ascending order from lowest to highest values', 'pcs'  );		
		
		//array of thumbnail sizes
		$this->ats['thumbnail'] = __( 'Thumbnail (default 150px x 150px max)', 'pcs'  );
		$this->ats['medium'] 	= __( 'Medium (default 300px x 300px max)', 'pcs'  );
		$this->ats['large'] 	= __( 'Large (default 640px x 640px max)', 'pcs'  );			
		$this->ats['full'] 		= __( 'Full (original size uploaded)', 'pcs'  );		
		
		// array of taxonomy  qurey relation
		$this->atr['OR'] 	= __( 'OR', 'pcs'  );			
		$this->atr['AND'] 	= __( 'AND', 'pcs'  );		

		// array of order by wp_query
		$this->aob['ID']			= __( 'Order By Post ID', 'pcs'  );
		$this->aob['author']		= __( 'Order By Author', 'pcs'  );
		$this->aob['title']			= __( 'Order By Title', 'pcs'  );
		$this->aob['name']			= __( 'Order By Post Name (post slug)', 'pcs'  );
		$this->aob['date']			= __( 'Order By Date.', 'pcs'  );
		$this->aob['modified']		= __( 'Order By Last Modified Date', 'pcs'  );
		$this->aob['rand']			= __( 'Random Order', 'pcs'  );
		$this->aob['comment_count']	= __( 'Order By Number Of Comments', 'pcs'  );
		$this->aob['menu_order']	= __( 'Order By Page Order (menu_order)', 'pcs'  );

	}							
								
	/**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 * @since 2.0
	 */
	public function includes() {
		include_once("inc/pcs-shortcode.php");
		include_once("inc/pcs-widget.php");
		include_once("inc/pcs-ajax.php");
		include_once("inc/pcs-menu.php");
	}
	/**
	 * Used to add css, html and js on the frontend.
	 * @since 2.0.4
	 */
	function pcs_add_header_css(){
		if(get_option("pcscss01101989")){
			echo "<style type='text/css'>".get_option("pcscss01101989")."</style>";
		}else{
			?>
			<style type="text/css">.pcs-content,.pcs-excerpt{text-align:justify}.gws .pcs-sub,.igws .pcs-sub,.iws .pcs-sub,.ws .pcs-sub{border-bottom:1px solid #777}.pcs-body,.pcs-main,.pcs-pagination,.pcs-sub{overflow:hidden}.pcs-body,.pcs-img,.pcs-meta,.pcs-pagination ul li,.pcsmeta{float:left}.pcs-reset{line-height:1.7em;margin-bottom:3px}.pcs-main{padding:10px!important}.pcs-sub:first-child{margin-top:0}.pcs-sub{margin-top:15px;padding-right:10px;clear:both;display:block}.pcs-body,.pcs-img{display:block;vertical-align:top;box-sizing:border-box}.pcs-body{width:60%}.pcs-img{width:30%;margin:0 10px 10px 0!important}.pcs-title{font-size:15px;display:block;padding:0;margin:0 0 5px}.pcs-excerpt{font-size:13px;display:block}.pcs-content,.pcs-meta{display:block;font-size:12px}.pcs-rm,.pcsmeta{display:inline-block}.pcs-meta a{font-size:12px!important}.pcs-rm{font-size:15px;clear:both;text-align:left}.pcs-img img{max-width:100%;max-height:100%;margin:0 auto}.pcsmeta{padding-right:10px}.pcs-cust-field,.pcs-pagination{display:block;clear:both}.pcs-meta .glyphicon{margin-right:3px}.gws .pcs-title a,.ws .pcs-title a{color:#222}.gws .pcs-excerpt,.ws .pcs-excerpt{color:#333}.gws .pcs-content,.ws .pcs-content{color:#444}.gws .pcs-meta,.gws .pcs-meta a,.ws .pcs-meta,.ws .pcs-meta a{color:#555}.gws .pcs-rm,.ws .pcs-rm{color:#666}.gws a:hover,.ws a:hover{color:#000!important}.igws.pcs-main,.iws.pcs-main{background-color:#333}.igws .pcs-title a,.iws .pcs-title a{color:#eee}.igws .pcs-content,.igws .pcs-excerpt,.iws .pcs-content,.iws .pcs-excerpt{color:#ddd}.igws .pcs-meta,.igws .pcs-meta a,.iws .pcs-meta,.iws .pcs-meta a{color:#ccc}.igws .pcs-rm,.iws .pcs-rm{color:#eee!important}.igws a:hover,.iws a:hover{color:#fff!important}.gcore .pcs-body,.gcore .pcs-img,.gws .pcs-body,.gws .pcs-img,.igws .pcs-body,.igws .pcs-img{width:100%}.pcs-pagination ul{display:inline-block;padding:0;margin:10px 1px;border-radius:50%;list-style-type:none}.pcs-pagination ul li a,.pcs-pagination ul li span{float:left;padding:10px 15px;line-height:1.5;color:#0275d8;text-decoration:none;background-color:#fff;border:1px solid #ddd;display:block;margin-left:-1px}.pcs-pagination ul li a:hover,.pcs-pagination ul li span.current{background-color:#0275d8;color:#fff}</style>
			<?php
		}
	}

	/**
	 * Used to add css and js file on the frontend.
	 * @since 2.0
	 */
	function pcs_style_script(){
		wp_enqueue_style('pcs',PCS_CSS_URL."pcs.css");
	}
	/**
	 * Add menu page in admin menu
	 * @since 2.0
	 */
	function register_pcs_shortcode_menu_page(){
		//add_menu_page( 'Post Shortcode', 'Post Shortcode', 'manage_options', 'post-shortcode', 'fn_pcs_menu', PCS_IMG_URL.'icon.png' ); 
		add_submenu_page('edit.php','Post Shortcode', 'Post Shortcode', 'manage_options', 'post-shortcode', 'fn_pcs_menu' );
	}
	/**
	 * Add tiny editor button
	 */
	function pcs_add_tiny_editor_button() {
	    global $typenow;
	    // check user permissions
	    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
	    return;
	    }
	    // check if WYSIWYG is enabled
	    if ( get_user_option('rich_editing') == 'true') {
	        add_filter("mce_external_plugins", array($this,"pcs_add_tinymce_plugin") );
        	add_filter('mce_buttons', array($this,'pcs_register_my_tc_button') );
    	}
    }
    function pcs_add_tinymce_plugin($plugin_array) {
        $plugin_array['pcs_tc_button'] = PCS_JS_URL."tiny-shortcode.js"; // CHANGE THE BUTTON SCRIPT HERE
        return $plugin_array;
    }
    function pcs_register_my_tc_button($buttons) {
       array_push($buttons, "pcs_tc_button");
       return $buttons;
    }
    /**
     * Used to add css and js file on the admin side / back end.
     */
    function pcs_admin_style_script(){
    	wp_enqueue_style('pcs-admin',PCS_CSS_URL.'pcs-admin.css');
    	wp_enqueue_script ('jquery-ui-tabs');
    }
     /**
     * Used to add widget
     */
    function register_pcs_widget(){
    	register_widget( 'PCS_Widget' );
    }
    /**
     * Used to add link in plugin page
     */
	function pcs_plugin_action_links( $links ) {
	   $links[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?page=post-shortcode') ) .'">Plugin Page</a>';
	   return $links;
	}
	 /**
     * pcs selected option fuction
     * @var array of options
     * @var array or string of selected option
     * @since 2.0.5
     */
    function pcs_selected_option($aoption,$as){
     	if(!empty($aoption)){
     		$selected = "";
     		foreach ($aoption as $key => $value) {
     			if(!empty($as)){
     				if(is_array($as)){
     					$selected = ( in_array($key, $as) ) ? "selected='selected'" : "";
     				}else{
     					$selected = ( $as == $key )? "selected='selected'" : "";
     				}
     			}
     			?>
     			<option value="<?php echo $key; ?>" <?php echo $selected; ?> ><?php echo $value; ?></option>
     			<?php
     		}
     	}
    }
    /**
    * @since 2.0.5
    * get all post slug / name
    */
    function pcs_get_all_post_name(){
    	$apost = array();
    	$post_types = get_post_types( '', 'names' ); 
    	foreach ( $post_types as $post_type ) {
    		if($post_type != "attachment" && $post_type !="revision" && $post_type != "nav_menu_item" && $post_type != "product_variation" && $post_type != "shop_order" && $post_type != "shop_order_refund" && $post_type != "shop_coupon" && $post_type != "shop_webhook" ){
    			$apost[$post_type] = ucfirst( $post_type );
    		}
    	}
    	return $apost;
    }
    /**
    * @since 2.0.5
    * @var array of post type
    * get all post categories by post type 
    */
    function pcs_get_all_categories($post_type = array()){
    	$aCategories = $acats =array();
    	if(is_array($post_type) && !empty($post_type)){
    		foreach ($post_type as $ptkey => $ptvalue) {
    			$aCategories[] = $this->pcs_get_all_category($ptvalue);
    		}
    	}elseif(!empty($post_type)){
    		$aCategories[] = $this->pcs_get_all_category($post_type);
    	}else{
    		$aCategories[] = $this->pcs_get_all_category();
    	}
    	foreach ($aCategories as $ckey => $cvalue) {
    		foreach ($cvalue as $ck => $cv) {
    			foreach ($cv as $ck1 => $cv1) {
    				$cckey = $ck."$".$cv1->slug;
    				$acats[$cckey] = $cv1->slug." ( ".$ck." )";
    			}
    		}
    	}
    }

    /**
    * @since 2.0.5
    * @var string of post type
    * get all category of relative post type
    */
    function pcs_get_all_category($post_type="post"){
    		$aCategory = array();
    		$customPostTaxonomies = get_object_taxonomies($post_type);
    		if(count($customPostTaxonomies) > 0)
    		{
    		     foreach($customPostTaxonomies as $tax)
    		     {
    			     $args = array(
    		         	  	'type'                     => $post_type,
    						'child_of'                 => 0,
    						'parent'                   => '',
    						'orderby'                  => 'name',
    						'order'                    => 'ASC',
    						'hide_empty'               => 1,
    						'hierarchical'             => 1,
    						'exclude'                  => '',
    						'include'                  => '',
    						'number'                   => '',
    						'taxonomy'                 => $tax,
    						'pad_counts'               => false 
    		        	);

    			    $aCategory[$tax] =  get_categories( $args );
    		     }
    		}
    	return $aCategory;
    }
}
endif;
/**
 * Returns the main instance of pcs to prevent the need to use globals.
 *
 * @since  1.0
 * @return PostCustomize
 */
function pcs() {
	return PostCustomize::instance();
}
$GLOBALS['pcs'] = pcs();
/**
* @since 2.0.8
* Global for plugin addon
*/


// code for append theme by apply_filters function.
$pcs_atl = array();
$pcs_atl = $GLOBALS['pcs']->atl;
$pcs_atls = serialize($pcs_atl);
$pcs_atls = apply_filters( 'post_shortcode_themes', $pcs_atls );
$pcs_atl = unserialize($pcs_atls);
$GLOBALS['pcs']->atl = wp_parse_args( $pcs_atl, $GLOBALS['pcs']->atl );
// code for append show field by apply_filters function.
$pcs_asf = array();
$pcs_asf = $GLOBALS['pcs']->asf;
$pcs_asfs = serialize($pcs_asf);
$pcs_asfs = apply_filters( 'post_shortcode_show_fields', $pcs_asfs );
$pcs_asf = unserialize($pcs_asfs);
$GLOBALS['pcs']->asf = wp_parse_args( $pcs_asf, $GLOBALS['pcs']->asf );
?>