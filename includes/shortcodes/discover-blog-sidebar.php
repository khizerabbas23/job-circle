<?php
   function jobcircle_discover_blog_siderbar() {  
           $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map( 
       array(
             'name' => __( 'Discover Blog Sidebar' ),
             'base' => 'jobcircle_discover_blog_siderbar',
             'category' => __( 'Job Circle' ),
             'params' => array(
                 array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Blog Page Style', 'jobcircle-frame'),
                'param_name' => 'blog_page_style',
                'description' => __('Select Blog Page Style', 'jobcircle-frame'),
                'value' => array(
                    'Select Style' => '',
                    'Blog Full Width' => 'blog_full_width',
                    'Blog Container' => 'blog_containier',
                ),
              ),
                array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Post Title FontSize'),
                'param_name' => 'font_size',
                ),
               array(
                   'type' => 'textfield',
                   'holder' => 'div',
                   'class' => '',
                   'heading' => __( 'Title' ),
                   'param_name' => 'titles',
                  ),
                  array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Heading' ),
                    'param_name' => 'heading',
                   ),
                   array(
            		  'type' => 'dropdown',
            		  'holder' => 'div',
            		  'class' => '',
            		  'heading' => __('Checkbox Options'),
            		  'param_name' => 'checkbox_param',
            		  'value' => $job_types,
            		),
                  array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Order By' ),
                    'param_name' => 'orderby',
                   ),
               array(   
                   'type' => 'textfield',
                   'holder' => 'div',
                   'class' => '',
                   'heading' => __( 'Number Of Post' ),
                   'param_name' => 'numofpost',
                  ),            
          )
         )
        
      );
}
add_action( 'vc_before_init', 'jobcircle_discover_blog_siderbar' );

// popular category frontend
function jobcircle_discover_blog_siderbar_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(

        'titles' => '',
        'heading' => '',
        'font_size' => '',         
         'blog_page_style' => '',
        'checkbox_param' => '',
        'orderby' => '',
		'numofpost' => '',

    ), $atts, 'jobcircle_discover_blog_siderbar');

    $titles = isset($atts['titles']) ? $atts['titles'] : '';
$heading  = isset($atts['heading']) ? $atts['heading'] : '';
$font_size = isset($atts['font_size']) ? $atts['font_size'] : '';
$blog_page_style  = isset($atts['blog_page_style']) ? $atts['blog_page_style'] : '';
$checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
$job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
ob_start();

if ($atts['blog_page_style'] == 'blog_full_width') {
         $container ='container-fluid';
     }else{
         $container ='container';
     }

?>
			<section class="section section-theme-17 articles page-theme-17 theme_sevenb">
				<div class="<?php echo $container ?>">
					<div class="recent_articles">
						<!-- Section header -->
						<header class="section-header d-flex flex-column text-center mb-15 mb-xl-25">
                            <?php if(!empty($titles)) { ?>
							<p><?php echo esc_html($titles) ?></p>
                            <?php } ?>
                            <?php if(!empty($heading)) { ?>
							<h2><span class="text-outlined"><?php echo esc_html($heading) ?></span></h2>
                            <?php } ?>
						</header>
						<div class="article_info_row my-discover">
<?php

        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
        
        $include_category_ids = $job_type_arr;
$page_numbr = get_query_var('paged');
               $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $numofpost,
                        'paged' => $page_numbr,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
                            ),
                        ),
                    );
               
        // Custom query.// also this one 
        $query = new WP_Query($args);
        $total_posts = $query->found_posts;
         
        // Check that we have query results.
        if ( $query->have_posts() ) {
        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_post();   
                $postid =  $post->ID;       
                $title = get_the_title($postid);
                $excerpt = get_the_excerpt($postid);
                $permalinkget = get_permalink($postid);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                $full_date = get_the_date('M, Y'); 
                $month = get_the_date('d'); 
?>
	<div class="article_holder">
								<div class="date-holder">
									<span class="date"><?php echo esc_html($month ) ?><span class="month"><?php echo esc_html($full_date) ?></span></span>
								</div>
								<div class="article_info">
									<div class="image-holder">
									    <?php if(!empty($permalinkget)) { ?>
                                        <a href="<?php echo esc_html($permalinkget) ?>">
                                        <?php } if(!empty($image)) { ?>
										<img src="<?php echo esc_url_raw($image[0]) ?>" alt="img">
                                        <?php } ?>
                                        </a>
									</div>
									<div class="text-holder">
									     <?php if(!empty($permalinkget) || !empty($title)) { ?>
                                    <a href="<?php echo esc_html($permalinkget) ?>">
										<strong class="title " style="font-size:<?php echo $font_size ?>px; line-height:30px;"><?php echo esc_html($title) ?></strong>
                                        </a> <?php } ?>
                                         <?php if(!empty($excerpt) || !empty($permalinkget)) { ?>
										<p><?php echo esc_html($excerpt) ?></p>
										<a class="btn-more" href="<?php echo esc_html($permalinkget) ?>"><?php esc_html_e('read more', 'jobcircle-frame') ?></a>
									<?php } ?>
									</div>
								</div>
							</div>
<?php
            }
        }
           
        
       wp_reset_postdata();
        ?>
	        	</div>
	        	<?php
    if ($total_posts > $numofpost) {
        ?>
        <?php echo jobcircle_pagination($query, true); ?>
        <?php
    }
    ?>
					</div>
				</div>
			</section>
    <?php
    return ob_get_clean();
}
add_shortcode( 'jobcircle_discover_blog_siderbar', 'jobcircle_discover_blog_siderbar_frontend' );