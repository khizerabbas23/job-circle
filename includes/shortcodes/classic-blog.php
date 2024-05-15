<?php
function jobcircle_classic_blog()
{
    vc_map(
        array(
            'name' => __('Classic Blog'),
            'base' => 'jobcircle_classic_blog',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'interest_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'interest_short_description',
                ),
                 
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_classic_blog');
// popular category frontend
function jobcircle_classic_blog_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'interest_title' => '',
            'interest_short_description' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_classic_blog'
    );

    $title = isset($atts['interest_title']) ? $atts['interest_title'] : '';
    $desc = isset($atts['interest_short_description']) ? $atts['interest_short_description'] : '';
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
   
    ob_start();
    ?>
     			<section class="section section-theme-3 news-block pt-35 pt-md-50 pt-lg-75 pt-xxl-100 pb-35 pb-md-50 pb-lg-65 pb-xxl-80">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-20 mb-lg-40">
                        <?php
                    if(!empty($title)){ ?>
						<h2><?php jobcircle_esc_the_html($title);?></h2>
                        <?php } ?>
                        <?php
                    if(!empty($desc)){ ?>
						<p><?php jobcircle_esc_the_html($desc);?></p>
                        <?php } ?>
					</header>
					<div class="row">
						<div class="col-12">
							<div class="news-carousel">
        <?php
               $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
               $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
       
               $args = array(
                   'post_type' => 'post',
                   'post_status' => 'publish',
                   'posts_per_page' => $numofpost,
                   'order' => 'DESC',
                   'orderby' =>  $orderby,
                   'tax_query' => array(
                       array(
                           'taxonomy' => 'category',
                           'field'    => 'slug',
                           'terms'    => 'latest-news',
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
                       $author = get_the_author();
                    
                       $title = get_the_title($post);
                       
                       $excerpt = get_the_excerpt($post);
       
                       $permalinkget = get_the_permalink($post);
                       
                       $posted_date = get_the_date('F j, Y');
                       
                       
                       $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                       
                       ?>
                      				<div class="news-post-box">
									<div class="image-holder">
                                    <?php
                                if(!empty($image) || !empty($permalinkget)){ ?>
									<a href="<?php echo jobcircle_esc_the_html($permalinkget)?>"><img src="<?php echo esc_url_raw($image[0]) ?>" width="620" height="338" alt="image"></a>
                                        <?php } ?>
									</div>
									<div class="news-info">
										<div class="title-bar">
											<ul class="meta-list">
											    	<?php 
                                     $cat_terms = get_terms( array(
                                        'taxonomy'   => 'job_category',
                                        'hide_empty' => false,
                                    ) );
                                    if (!empty($cat_terms)) {
                                        $counter=1;
                                    foreach ($cat_terms as $cat_term) {
                                        if($counter==1){
                                            ?>
												<li><strong class="lbl"><?php echo jobcircle_esc_the_html($cat_term->name) ?></strong></li>
												<?php 
							 }else{
                                            break;
                                        }
                                       $counter++; }
                                    }
                                    ?>       
                                                <?php
                                            if(!empty($posted_date)){ ?>
												<li><?php jobcircle_esc_the_html($posted_date) ?></li>
                                                <?php } ?>
											</ul>
                                             <?php
                                if(!empty($title) && !empty($permalinkget)){ ?>
											<h3><a href="<?php jobcircle_esc_the_html($permalinkget) ?>"><?php jobcircle_esc_the_html($title) ?></a></h3>
                                            <?php } ?>
										</div>
                                        <?php if(!empty($excerpt)){ ?>
										<p><?php jobcircle_esc_the_html($excerpt) ?></p>
                                         <?php } ?>
                                         
									</div>
								</div>
                       <?php
                   }
               }
               // Restore original post data.

               wp_reset_postdata();
               ?>	
               </div>
						</div>
					</div>
				</div>
			</section>
   <?php 
    return ob_get_clean();
}
add_shortcode('jobcircle_classic_blog', 'jobcircle_classic_blog_frontend');

?>