<?php
   function jobcircle_recent_artical_17() {  
    vc_map( 
       array(
             'name' => __( 'Recent Artical 17' ),
             'base' => 'jobcircle_recent_artical_17',
             'category' => __( 'Job Circle' ),
             'params' => array(
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Url' ),
                    'param_name' => 'url',
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
add_action( 'vc_before_init', 'jobcircle_recent_artical_17' );

// popular category frontend
function jobcircle_recent_artical_17_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(

        'titles' => '',
        'heading' => '',
        'url' => '',
        'orderby' => '',
		'numofpost' => '',

    ), $atts, 'jobcircle_recent_artical_17');

    $titles = isset($atts['titles']) ? $atts['titles'] : '';
$heading  = isset($atts['heading']) ? $atts['heading'] : '';
$url  = isset($atts['url']) ? $atts['url'] : '';
ob_start()


?>
			<section class="section section-theme-17 articles page-theme-17">
				<div class="container">
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
						<div class="article_info_row">
<?php

        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
//this one
        $page_numbr = get_query_var('paged');
        $args = array(
           'post_type' => 'post',
            'post_status' => 'publish',                                                                                                                
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',            
             'paged' => $page_numbr, 

             'orderby' =>  $orderby,  
             'tax_query' => array(                           
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => 'blog-post',
                ),  
            ),
        );
               
        // Custom query.// also this one 
        $query = new WP_Query( $args );
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
									     <?php if(!empty($permalinkget) || !empty($titles)) { ?>
                                    <a href="<?php echo esc_html($permalinkget) ?>">
										<strong class="title"><?php echo esc_html($titles) ?></strong>
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
       //also this one      
        
       wp_reset_postdata();
        ?>
		</div>
						<div class="d-flex justify-content-center">
						     <?php if(!empty($url)) { ?>
							<a class="btn btn-orange btn-sm" href="<?php echo esc_html($url) ?>"><span class="btn-text"><?php esc_html_e('View All Articles', 'jobcircle-frame') ?></span></a>
						<?php } ?>
						</div>
					</div>
				</div>
			</section>
    <?php 
   
    return ob_get_clean();
}
add_shortcode( 'jobcircle_recent_artical_17', 'jobcircle_recent_artical_17_frontend' );