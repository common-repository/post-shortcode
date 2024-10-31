<?php 
/**
* @since 2.0.0
* Add shortcode
*/
function pcs_func( $atts ) {
    global $pcs;

    $a = shortcode_atts( array(
        'template' 		        => 'ws',
        'postcount' 	        => '3',
        'showfield' 	        => 'title,thumbnail,excerpt',
        'excerptl'              => '55',
        'readmoretitle'         => 'Read more',
        'customfield' 	        => '',
        'posttype' 		        => 'post',
        'categories' 	        => '',
        'orderby' 		        => 'modified',
        'order' 		        => 'DESC',
        'tsize'                 => 'thumbnail',
        'paged'                 => '1',
        'taxrel'                => 'OR',
        'post_parent__in'       => '',
        'post_parent__not_in'   => '',
        'post__in'              => '',
        'post__not_in'          => '',
        'post_name__in'         => '',
        'pagedvar'              => 'paged',
    ), $atts );
    $custfun = "post_shortcode_callback_for_".$a['template'];
    if(function_exists($custfun)){
        return $custfun($a);
    }elseif(function_exists('pcs_get_custom_post_output')){
    	return pcs_get_custom_post_output($a);
    }else{
    	return pcs_get_post_output($a);
    }
}
add_shortcode( 'pcs', 'pcs_func' ); 

/**
* @version 2.0.1
* get output of post query
*/
function pcs_get_post_output($a){
    ob_start();
    global $pcs;
    $app = array();
    $aft = $pcs->aft;
    $a = array_filter($a,"sanitize_text_field");
    extract($a);
    if(isset($posttype) && !empty($posttype)){
        $args['post_type'] = explode(",", $posttype); 
    }else{
        $args['post_type'] = explode(",", 'post'); 
    }
    $showfield = (isset($showfield) && !empty($showfield)) ? $showfield : "title,thumbnail,excerpt";
    $ashowfield =explode(",", $showfield);
    $args['post_status'] = array( 'publish' );
    $args['posts_per_page'] = (isset($postcount) && !empty($postcount)) ? $postcount : 3;
    $paged = (isset($paged) && !empty($paged)) ? $paged : 1;
    $taxrel = (isset($taxrel) && !empty($taxrel)) ? $taxrel : 'OR';
    $args['paged'] = (int) $paged;
    $pagedvar = (isset($pagedvar) && !empty($pagedvar)) ? $pagedvar : "paged";
    if(in_array("pagination", $ashowfield)){
        $args['paged'] = 1;
        if(isset($_GET['pagedvar']) && $_GET['pagedvar'] == $pagedvar ){
            $args['paged'] =  ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        }
    }
    if(!empty($categories)):
        $acat = explode(",", $categories);
        if(!empty($acat)):
            foreach ($acat as $catkey => $catvalue) {
                $actt = explode("$", $catvalue);
                $ctkey = $actt[0];
                $ctvalue = $actt[1];
                $afctt[$ctkey][] = $ctvalue;
            }
        endif;
        if(!empty($afctt)):
            foreach ($afctt as $afckey => $afcvalue) {
                $tax[] = array(
                        'taxonomy' => $afckey,
                        'field'    => 'slug',
                        'terms'    => $afcvalue,
                    );
            }
        endif;
        $tax_query = array(
                'relation' => $taxrel,
                $tax
            );
        $args['tax_query'] = $tax_query;
    endif;
    $orderby = (isset($orderby) && !empty($orderby)) ? $orderby : "modified";
    $args['orderby'] = $orderby;
    $order = (isset($order) && !empty($order)) ? $order : "DESC";
	$args['order']   = $order;
    $tsize = (isset($tsize) && !empty($tsize)) ? $tsize : "thumbnail";
    $excerptl = (isset($excerptl) && !empty($excerptl)) ? $excerptl : 55;
    foreach ($aft as $aftvalue => $aftkey ) {
        if(isset($$aftvalue) && !empty($$aftvalue)){
            $app = explode( ",", $$aftvalue );
            $args[$aftvalue] = $app;
        }
    }
	query_posts($args);
	// The Loop
    if ( have_posts() ) :
        ?>
        <div class="pcs-main pcs-reset <?php echo $template; ?>" >
        <?php    
    	while ( have_posts() ) : the_post();
    	    $lnk = get_the_permalink();
            ?>
            <div class="pcs-sub pcs-reset">
                <?php if(in_array("thumbnail", $ashowfield)): ?>
                <?php if ( has_post_thumbnail() ) {
                    echo "<a href='".$lnk."' class='pcs-img pcs-reset'>";
                    the_post_thumbnail($tsize, array( 'class' => 'img-responsive' ) );
                    echo "</a>";
                }?>
                <?php endif; ?>
                <div class="pcs-body">
                    <?php if(in_array("title", $ashowfield)): ?>
    	               <h3 class="pcs-title pcs-reset"><?php  echo "<a href='".$lnk."'>"; the_title(); echo "</a>";?></h3>
                    <?php endif; ?>
                    <?php if(in_array("excerpt", $ashowfield)): 
                           add_filter( 'excerpt_length', function($excerptl){
                                return $excerptl;
                            },999);
                    ?>
                        <div class="pcs-excerpt pcs-reset"><?php echo wp_trim_words( get_the_excerpt(), $excerptl); ?></div>
                    <?php endif; ?>
                    <?php if(in_array("content", $ashowfield)): ?>
                        <div class="pcs-content pcs-reset"><?php the_content(); ?></div>
                    <?php endif; ?>
                    <?php if(!empty($customfield)): 
                        $acustomfield = explode(",", $customfield);
                        $pid = get_the_ID();
                        foreach ($acustomfield as $ackey => $acvalue) {
                            $actxt = "";
                            $actxt = get_post_meta($pid,$acvalue,true);
                            if(!empty($actxt)) echo "<span class='pcs-reset pcs-cust-field ".$acvalue."'>".$actxt."</span>";
                        }
                    endif; ?>
                   <div class="pcs-meta pcs-reset">
                        <?php if(in_array("date", $ashowfield)): ?>
                            <span class="pcsmeta">
                                <?php 
                                $ay = get_the_time('Y');
                                $am = get_the_time('m');
                                $alink = get_month_link( $ay, $am ); 
                                $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                                $dateformat = get_option('date_format');
                                _e( 'On &nbsp;', 'pcs' ) ?><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><a href="<?php echo esc_url( $alink ); ?>" rel="bookmark"><?php echo sprintf( $time_string,esc_attr( get_the_date( 'c' ) ),get_the_date($dateformat)  ); ?></a>
                            </span>
                        <?php endif; ?>
                        <?php if(in_array("author", $ashowfield)): ?>
                            <span class="pcsmeta">
                                <?php _e( 'By &nbsp; ', 'pcs' ) ?><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a>
                            </span>
                        <?php endif; ?>
                        <?php if(in_array("cc", $ashowfield)): ?>
                            <span class="pcsmeta">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><?php comments_popup_link( __( 'Leave a comment', 'pcs' ), __( '1 Comment', 'pcs' ), __( '% Comments', 'pcs' ) );?>
                            </span>
                        <?php endif; ?>
                        <?php 
                            if( in_array("category", $ashowfield) ){
                                $categories_list = get_the_category_list( "," );
                                if( !empty( $categories_list ) ){ ?>
                                    <span class="pcsmeta">
                                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> <?php _e( 'Categories ', 'pcs' ); echo $categories_list; ?>
                                    </span>
                        <?php }
                            } ?>

                        <?php if(in_array("tag", $ashowfield)){
                                $tags_list = get_the_tag_list( "", "," );
                                if(!empty($tags_list)){ ?>
                                    <span class="pcsmeta">
                                        <span class="glyphicon glyphicon-tags" aria-hidden="true"></span> <?php _e( 'Tags ', 'pcs' ); echo $tags_list; ?>
                                    </span>
                        <?php   }
                              }?>
                   </div>
                    <?php if(in_array("readme", $ashowfield)): ?>
                        <a class="pcs-rm pcs-reset" href="<?php echo $lnk; ?>"><?php echo $readmoretitle; ?></a>
                   <?php endif; ?>
               </div>
            </div>
    	   	<?php
    	endwhile;
        ?>
        </div>
        <?php
        /**
        * @version 2.0.7
        * pagination code for query post 
        */
        if(in_array("pagination", $ashowfield)){ ?>
            <nav class="pcs-pagination pcs-reset" >
                <?php global $wp_query;
                $big = 999999999; // need an unlikely integer
                $asearch   = array( $big, '#038;' );
                $areplace = array( '%#%', '&' ); 
                echo paginate_links( array(
                    'base' => str_replace( $asearch, $areplace, esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total' => $wp_query->max_num_pages,
                    'type' => 'list',
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'add_args' => array( "pagedvar" => $pagedvar),
                ) );
                ?>
            </nav>      
        <?php
        }
    endif;
	$output = ob_get_contents();
	ob_end_clean();
	// Reset Query
	wp_reset_query();
	return $output;
}
?>