<?php
function jobcircle_fits_blog_sidebar() {   
    vc_map(       
       array(
             'name' => __( 'Fits Blog Sidebar' ),
             'base' => 'jobcircle_fits_blog_sidebar',
             'category' => __( 'Job Circle' ),
             'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'TItle' ),
                    'param_name' => 'title',
                   ),

                   array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Sub Title' ),
                    'param_name' => 'sub_title',
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
add_action( 'vc_before_init', 'jobcircle_fits_blog_sidebar' );

// popular category frontend
function jobcircle_fits_blog_sidebar_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
       
        'title' => '',
        'sub_title' => '',
        'orderby' => '',
        'numofpost' => '',
    ), $atts, 'jobcircle_fits_blog_sidebar'
);

$title  = isset($atts['title']) ? $atts['title'] : '';
$sub_title  = isset($atts['sub_title']) ? $atts['sub_title'] : '';

 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 $output ='';

 ob_start();
 ?>

<section class="section section-theme-10 recent-articles-block bg-white pt-30px pt-md-40 pt-lg-80 pt-xxl-90 pb-35 pb-md-50 pb-lg-100 pb-xxl-120 theme_sevenb">
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column-reverse text-center mb-20 mb-md-30">
                        <?php 
                        if(!empty($title)){
                            ?>
						<h2><?php echo esc_html($title);?></h2>
                        <?php 
                        }
                        ?>
                        <?php 
                        if(!empty($sub_title)){
                            ?>
						<p><?php echo esc_html($sub_title);?></p>
                        <?php 
                        }
                        ?>
					</header>
					<div class="acticles-slider my-slider">

 <?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
        $page_numbr = get_query_var('paged');
        $args = array(
           'post_type' => 'post',
            'post_status' => 'publish',                                                                                                                                                                                             
             'posts_per_page' => $numofpost, 
             'order' => 'DESC',
             'paged' => $page_numbr,
             'orderby' =>  $orderby, 
                'tax_query' => array(
                            'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'slug',
                                'terms'    => 'recent-news',
                            ),
                        ),        
                     ),
                 );         
        // Custom query.
        $query = new WP_Query( $args );
        $total_posts = $query->found_posts;

        // Check that we have query results.
        if ( $query->have_posts() ) {
        
            // Start looping over the query results.
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_the_id();
                $permalinkget = get_the_permalink($post);
                $comments_number = get_comments_number($post);
                $title = get_the_title($post);
                $excerpt = get_the_excerpt($post);
                $posted = get_the_date('M d, Y', $post);
          
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                                 
                $comments_link = get_comments_link($post);

             ?>
 
           <div class="article-slide">
							<div class="acticle">
								<div class="image-holder">
								    <?php 
									    if(!empty($permalinkget)){
									        ?>
									<a href="<?php echo esc_html($permalinkget) ?>">
									    <?php 
									    }
									    if(!empty($image)){
									        ?>
                                <img src=" <?php echo esc_url_raw($image[0]); ?>" alt="image">
                                <?php 
							    }
							    ?>
                                </a>
								</div>
								<div class="text-frm">
								    <?php 
								    if(!empty($permalinkget) || !empty($title)){
								        ?>
									<h3><a href="<?php echo esc_html($permalinkget);?>"> <?php echo esc_html($title); ?></a></h3>
									<?php 
								    }
								    if(!empty($excerpt)){
								    ?>
									<p> <?php echo esc_html($excerpt);?></p>
									<?php 
								    }
								    ?>
									<ul class="list-inline tags-items m-0">
										<li>
											<time class="date" datetime="2024-12-25">
												<span class="jobcircle-icon-calendar"></span>
												<?php if(!empty($posted)){
												    
												     echo esc_html($posted);
												}
												?>
											</time>
										</li>
										<li>
										    <?php if(!empty($comments_link || $comments_number)){
												    ?>
												
											<a href="<?php echo esc_html($comments_link); ?>"><span class="far fa-comment-dots"></span><?php echo esc_html($comments_number); ?> <?php esc_html_e('Comments','jobcircle-frame'); ?>
											</a>
											<?php 
										    }
										    ?>
										</li>
									</ul>
								</div>
							</div>
						</div>

                <?php
            }
        }
        // Restore original post data.
       
        wp_reset_postdata();
        ?>
	    </div>
					<div class="row">
						<div class="col-12 d-flex justify-content-center pt-lg-60">
						    <?php 
						    if(!empty($view_all_url)){
						        ?>
							<a href="<?php echo esc_html($view_all_url) ?>"><button class="btn btn-orange"><span> <?php esc_html_e('View All Articles','jobcircle-frame'); ?></span></button></a>
							<?php 
						    }
						    ?>
						</div>
					</div>
				</div>
			</section>
        <?php
    if ($total_posts > $numofpost) {
        ?>
        <?php echo jobcircle_pagination($query, true); ?>
        <?php
    }
    return ob_get_clean();
}
add_shortcode( 'jobcircle_fits_blog_sidebar', 'jobcircle_fits_blog_sidebar_frontend' );
