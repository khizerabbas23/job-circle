<?php
function jobcircle_hfifteen_recent_artical() {
    $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => false,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	};
	
    vc_map(
        array(
             'name' => __('Recent Artical Home 15'),
             'base' => 'jobcircle_hfifteen_recent_artical',
             'category' => __( 'Job Circle'),
             'params' => array(
                 array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Post Selector'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
        		),
        		array(
    		       'type' => 'checkbox',
    		       'holder' => 'div',
    		       'class' => '',
    		       'heading' => __('Category Selector'),
    		       'param_name' => 'checkbox_param',
    		       'value' => $job_types,
	         	),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => __( 'Title' ),
				'param_name' => 'titl',
			   ),
               array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => __( 'Discription ' ),
				'param_name' => 'disc',
			   ),
               array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => __( 'Url ' ),
				'param_name' => 'url',
			   ),
            // by defalt
               array(
                   'type' => 'textfield',
                   'holder' => 'div',
                   'class' => '',
                   'heading' => __( 'Order BY' ),
                   'param_name' => 'orderby',
                  ),
               array(   
                   'type' => 'textarea',
                   'holder' => 'div',
                   'class' => '',
                   'heading' => __( 'Number Of Post' ),
                   'param_name' => 'numofpost',
                  ),
          )
         )
      );
}
add_action( 'vc_before_init', 'jobcircle_hfifteen_recent_artical' );

// popular category frontend
function jobcircle_hfifteen_recent_artical_frontend( $atts, $content ) {

    $atts = shortcode_atts(

    array(
       
        'titl' => '',
        'disc' => '',
        'url' => '',
        // by defalt
        'orderby' => '',
		'numofpost' => '',
		'dropdown_param' => '',
        'checkbox_param' => '',


    ), $atts, 'jobcircle_hfifteen_recent_artical'
);

$titl = isset($atts['titl']) ? $atts['titl'] : '';
$disc  = isset($atts['disc']) ? $atts['disc'] : '';
$url  = isset($atts['url']) ? $atts['url'] : '';
$numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
$orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
$dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
$job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
$checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
$job_type_arry = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
   
 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
ob_start();
?>

<section class="section section-theme-15 recent-news-articles-block bg-white pt-30 pt-md-30 pt-lg-60 pt-xl-90 pt-xxl-100 pb-35 pb-md-50 pb-lg-80 pb-xxl-120">
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column-reverse text-center mb-20 mb-lg-30 mb-xl-45">
						<?php
                        if(!empty($titl) && !empty($disc)){
                            ?>
                    <h2><?php echo esc_html($titl) ?></h2>
						<p><?php echo esc_html($disc) ?></p>
                        <?php
                        }
                        ?>
					</header>
					<div class="news-acticles-carousel">
<?php
               
        
             $include_category_ids = $job_type_arr;

               $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $numofpost,
                        'orderby' =>  $orderby,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
                            ),
                        ),
                    );
             
    
        // Custom query.
        $query = new WP_Query( $args );
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
                    $date = get_the_date(' d');
                    $month = get_the_date('M, Y');
             $job_post = get_post($post->ID);
		    $post_author = $job_post->post_author;
	        $post_employer_id = jobcircle_user_employer_id($post_author);
        	 if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
        	     $post_author_name = get_the_title($post_employer_id);
        	     $post_author_link = get_permalink($post_employer_id);
        	 } else {
        	     $author_user_obj = get_user_by('id', $post_author);
        	     $post_author_name = $author_user_obj->display_name;
        	     $post_author_link = get_author_posts_url($post_author);
        	 }
			 
		 $categories = wp_get_post_terms($postid, 'category' );                
               ?>
				  <div class="acticle">
							<div class="image-holder">
                            <time class="date" datetime="2024-12-23">
                                <?php if (!empty ($date) || !empty($monty)) { ?>
									<strong><?php echo esc_html($date) ?></strong><?php echo esc_html($month) ?>
								<?php } ?>
                                </time>
                                <?php if(!empty($permalinkget)){ ?>
								<a href="<?php echo esc_html($permalinkget) ?>">
                                <?php
                                }
                                if(!empty($image)){
                                    ?>
									<img src="<?php echo esc_url_raw($image[0]) ?>" alt="image" >
                                    <?php
                                }
                                ?>
								</a>
							</div>
							<div class="text-frm">
								 <?php
                                   $include_category_ids = $job_type_arry;
                                   $terms = get_terms(
                                    array(
                                        'taxonomy' => 'category',
                                        'post_type' => 'post',
                                        'hide_empty' => false,
                                        'parent' => 0,
                                        'include' => $include_category_ids,
                                    )
                                );   ?>
						<strong class="designation">
			  <?php
                $counter=1;   
                        if (!empty($terms)) {
                           foreach ($terms as $term){
                                ?>
                                    <a class="text-black" href="<?php echo esc_url(get_term_link($term)); ?>">
                                       <?php echo esc_html($term->name); ?><?php echo ($counter ==1)? ', ' : ""; ?>
                                    </a>
                                        
                                <?php
                                $counter++;
                            }
                        }
                        ?>
								
                                </strong>
							<?php   
								if(!empty($permalinkget) || !empty($title)){ ?>
								<h3><a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h3>
								<?php
                                }
                                ?>
                                <span class="post-by"><?php esc_html_e('By ', 'jobcircle-frame') ?><a href="<?php echo esc_html($post_author_link) ?>"><?php echo esc_html($post_author_name) ?></a></span>
							</div>
						</div>
         <?php       
        }
    }
        // Restore original post data.
        wp_reset_postdata();
     ?>
</div>
					<div class="row mt-30 mt-lg-0">
						<div class="col-12 d-flex justify-content-center pt-lg-60">
                            <?php if(!empty($url)){ ?>
                            <a href="<?php echo jobcircle_esc_the_html($url) ?>">
                            <?php }?>
							<button class="btn btn-blue"><span><?php esc_html_e('View All News', 'jobcircle-frame') ?></span></button></a>
						</div>
					</div>
				</div>
			</section>
     <?php
    return ob_get_clean();
        }
add_shortcode( 'jobcircle_hfifteen_recent_artical', 'jobcircle_hfifteen_recent_artical_frontend' );