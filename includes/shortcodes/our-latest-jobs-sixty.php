<?php
function jobcircle_hsixteen_jobs()
{

    vc_map(

        array(
            'name' => __('Our Latest Jobs'),
            'base' => 'jobcircle_hsixteen_jobs',
            'category' => __('Job Circle'),
            'params' => array(

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Outline'),
                    'param_name' => 'outline',
                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order BY'),
                    'param_name' => 'orderby',
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
add_action('vc_before_init', 'jobcircle_hsixteen_jobs');

// popular category frontend
function jobcircle_hsixteen_jobs_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'outline' => '',
            'title' => '',
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_hsixteen_jobs'
    );

    $outline  = isset($atts['outline']) ? $atts['outline'] : '';
    $title  = isset($atts['title']) ? $atts['title'] : '';
  
ob_start();
?>

<section class="section section-theme-12 featured_Jobs_Block pt-60">
				<div class="container">
					<div class="jobs_info_wrap">
						<!-- Section header -->
						<header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-50">
                            <?php 
                            if(!empty($outline)){
                                ?>
							<p> <?php echo esc_html($outline);?> </p>
                            <?php 
                            }?>

                            <?php 
                            if(!empty($title)){
                                ?>
							<h2 class="showhead"><span class="text-outlined"> <?php echo esc_html($title);?> </span></h2>
                            <?php
                            }?>

						</header>
					</div>
					<div class="row">
					
<?php  
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

    $page_numbr = get_query_var('paged');

    $args = array(
        'post_type' => 'jobs',
         'post_status' => 'publish',                                                                                                                                                                                             
          'posts_per_page' => $numofpost, 
          'order' => 'DESC',  
          'paged' => $page_numbr,                   
          'orderby' =>  $orderby, 
              );         

    // Custom query.
    $query = new WP_Query($args);
     $total_posts = $query->found_posts;

    // Check that we have query results.
    if ($query->have_posts()) {

        // Start looping over the query results.
        while ($query->have_posts()) {

            $query->the_post();
            $post = get_post();
            $postid = $post->ID;
            $title = get_the_title($postid);
            $permalinkget = get_the_permalink($postid);
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $post_date = get_post_field('post_date', $postid);
            $minut = date("F j, Y", strtotime($post_date));
    		$job_location = jobcircle_post_location_str($postid);
            $job_salary = jobcircle_job_salary_str($postid, '', 'sub');
            $remote = get_post_meta($post->ID, 'remote', true);           
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
            ?>
                        <div class="col-12 col-lg-6 mb-15 mb-xl-30">
							<div class="jobs_info_holder">
								<div class="wrap_holder">
									<div class="icon_holder">
									    <?php if(!empty($permalinkget) && !empty($image)){ ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
										<img src=" <?php echo esc_url_raw($image[0]);?>" alt="img">
                                        </a>
                                        <?php } ?>
									</div>
									<div class="info_holder">
									    <?php if(!empty($post_author_name) && !empty($post_author_link)){ ?>
										<p> <?php esc_html_e('By','jobcircle-frame')?> <a href="<?php echo  $post_author_link ?>"> <?php echo esc_html($post_author_name);?> </a></p>
										<?php } ?>
										<?php if(!empty($permalinkget) && !empty($title)){ ?>
                                        <a class="text-decoration-none" href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                            <?php if(!empty($title)){ ?>
										<strong class="h6 showhead"> <?php echo esc_html($title);?> </strong>
										<?php } ?>
                                        </a>
                                        <?php } ?>
										<ul class="location_info">
											<li>
											    <?php if(!empty($minut)){ ?>
												<span class="text"> <?php echo esc_html($minut);?> </span>
												<?php } ?>
											</li>
											<li>
											    <?php if(!empty($job_location)){ ?>
												<span class="text"> <?php echo esc_html($job_location);?> </span>
												<?php } ?>
											</li>
										</ul>
									</div>
								</div>
								<div class="apply_bar">
								    <?php if(!empty($job_salary)){ ?>
							<span class="amount subclass"><strong> <?php echo jobcircle_esc_the_html($job_salary) ;?></strong></span>
							<?php } ?>
									<div class="apply_bar-links">
									    <?php if(!empty($remote)){ ?>
										<a class="remote"> <?php echo esc_html($remote);?> </a>
										<?php } ?>
										<a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-green btn-sm"> <?php esc_html_e('Apply Now','jobcircle-frame')?></a>
									</div>
								</div>
							</div>
						</div>
            <?php
        }

    }
             ?>

                <?php
                // Check if there are more posts than the specified number
    // Restore original post data.
    wp_reset_postdata();
    ?>
   
           </div>
				</div>
			</section>

    <?php
    return ob_get_clean();

}
add_shortcode('jobcircle_hsixteen_jobs', 'jobcircle_hsixteen_jobs_frontend');