<?php
function jobcircle_news_post() {
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
            'name' => __( 'Latest News Post' ),
            'base' => 'jc_news_post',
            'category' => __( 'Job Circle' ),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Gallery Style', 'Adhividhayam'),
                    'param_name' => 'news',
                    'description' => __('Select Gallery Style', 'Adhividhayam'),
                    'value' => array(
                        'Select Style' => '',
                        'View Style 1' => 'news_style_one',
                        'View Style 2' => 'news_style_two',
                        'View Style 5' => 'news_style_five',
                        'View Style 6' => 'news_style_six',

                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Background Image' ),
                    'param_name' => 'bg_img',
                    'dependency' => array(
                    'element' => 'news',
                    'value' => array('news_style_five') 
                ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Title' ),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Sub Title' ),
                    'param_name' => 'sub_title',
                    'dependency' => array(
                        'element' => 'news',  //selection param name
                        'value' => array('news_style_one', 'news_style_two', 'news_style_five') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Description' ),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Button Text' ),
                    'param_name' => 'btn_text',
                    'dependency' => array(
                        'element' => 'news',  //selection param name
                        'value' => array('news_style_one', 'news_style_two', 'news_style_five') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Button Url' ),
                    'param_name' => 'btn_url',
                    'dependency' => array(
                        'element' => 'news',  //selection param name
                        'value' => array('news_style_one', 'news_style_two', 'news_style_five') // depend on selection 
                    ),
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
                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Checkbox Options'),
        		  'param_name' => 'checkbox_param',
        		  'value' => $job_types,
        		),
            )
        )
    );
}
add_action( 'vc_before_init', 'jobcircle_news_post' );

// popular category frontend
function jobcircle_news_post_frontend( $atts, $content ) {

    $atts = shortcode_atts(
        array(
          
            'bg_img' => '',
            'title' => '',
            'sub_title' => '',
            'desc' => '',
            'btn_text' => '',
            'btn_url' => '',
            'orderby' => '',
            'numofpost' => '',
            'checkbox_param' => '',
            'news' => '',
        ), $atts, 'jobcircle_news_post'
    );

    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $btn_text = isset($atts['btn_text']) ? $atts['btn_text'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
 $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
        $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    ob_start();

    if ($atts['news'] == 'news_style_one') {
    ?>
    <section class="section section-theme-2 recent-news-block bg-light-gray pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-120">
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                <?php
                if (!empty($title) && !empty($sub_title)) {
                    ?>
                    <h2><?php echo esc_html($title);?> <span class="text-outlined"><?php echo esc_html($sub_title);?></span></h2>
                    <?php
                }
                ?>
                <?php
                if (!empty($desc)) {
                    ?>
                    <p><?php echo esc_html($desc);?></p>
                    <?php
                }
                ?>
            </header>
            <div class="row">
                <?php
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                $catagory_slug = isset($atts['catagory_slug']) ? $atts['catagory_slug'] : '';

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
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;

                // Check that we have query results.
                if ($query->have_posts()) {
                    $counter = 0;
                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        global $post;
                        $query->the_post();
                        $postid = $post->ID;
                        $title = get_the_title($postid);
                        $excerpt = get_the_excerpt($postid);
                        $permalinkget = get_the_permalink($postid);
                        $date = Date('F d, Y');
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                      

                        if($counter == 0 ){
                            $div = '<div class="col-12 col-lg-6">';
                            $class = 'large';
                            $ending_div = '</div>';
                        }elseif($counter == 1){
                            $div = '<div class="col-12 col-lg-6">';
                            $class = '';
                            $ending_div = '';
                        }elseif($counter == 2){
                            $div = '';
                            $class = '';
                            $ending_div = '</div>';
                        }
                        ?>
                        <?php echo jobcircle_esc_the_html($div)?>
                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="news-article <?php echo jobcircle_esc_the_html($class)?>">
                            <div class="image-holder">
                                <?php if(!empty($image)){ ?>
                                <img src="<?php echo esc_url_raw($image[0]);?>" alt="Looking For A Highly Motivated Producer To Build">
                                <?php } ?>
                            </div>
                            <div class="textbox">
                                <?php if(!empty($date)){ ?>
                                <time class="date" datetime="2023-12-23"><?php echo jobcircle_esc_the_html($date) ?> </time>
                                <?php } ?>
                                <?php if(!empty($title)){ ?>
                                <h3 class="h5"><?php echo esc_html($title) ?></h3>
                                <?php } ?>
                                <?php if($counter==0){ ?>
                                <?php if(!empty($excerpt)){ ?>
                                <p><?php echo esc_html__($excerpt) ?></p>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </a>
                        <?php echo jobcircle_esc_the_html($ending_div)?>
                        <?php
                        $counter++;
                    }

                    wp_reset_postdata();
                }
                ?>
                
            </div>
            <div class="row pt-25 pt-md-50 pt-xl-70">
                <!-- Featured Category Button Block -->
                <div class="col-12 text-center btn-block">
                     <?php if(!empty($btn_url)){ ?>
                    <a href="<?php echo esc_html($btn_url)?>" class="btn btn-dark-yellow btn-sm"><span class="btn-text"><?php echo esc_html_e('View All News', 'jobcricle-frame')?></span></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
            
    <?php
    } elseif ($atts['news'] == 'news_style_two') {
        ob_start();
        ?>
       
       <section class="section section-news pt-35 pb-10 pt-md-50 pb-md-0 pt-lg-70 pb-lg-30 pb-xl-60">
           <div class="container">
               <!-- Section header -->
               <header class="section-header text-center mb-30 mb-md-45 mb-lg-50">
                   <?php 
                   if (!empty($title) || !empty($sub_title)) {
                   ?>
                   <h2><?php echo esc_html($title);?> <span class="text-primary"><?php echo esc_html($sub_title);?></span></h2>
       
                   <?php
                   }
                   ?>
                   <div class="seprator"></div>
                   <?php 
                   if (!empty($desc)){
                   ?>
                   <p> <?php echo esc_textarea($desc) ;?> </p>
                   <?php
                   }
                   ?>
               </header>
               <div class="row">
        <?php
        $include_category_ids = $job_type_arr;
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
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
                            ),
                        ),
                    );
            //   $args = array(
            //       'post_type' => 'post',
            //       'post_status' => 'publish',
            //       'posts_per_page' => $numofpost,
            //       'order' => 'DESC',
            //       'orderby' =>  $orderby,
            //       'tax_query' => array(
            //           array(
            //               'taxonomy' => 'category',
            //               'field'    => 'slug',
            //               'terms'    => 'latest-news',
            //           ),
            //       ),
            //   );
       
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
                       $comments_number = get_comments_number($post);
                       $title = get_the_title($post);
                       $content = get_the_content();
                       $excerpt = get_the_excerpt($post);
                       $date = get_the_date();       
                       $formatted_date = date('j F Y', strtotime($date));
                       $permalinkget = get_the_permalink($post);
                       $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                       $read_more = get_post_meta($post, 'jobcircle_field_read_more', true);
                       $read_more_url = get_post_meta($post, 'jobcircle_field_read_more_url', true);  
            $job_post = get_post($post);
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
        	 $admin =  get_the_author();
        	 $author_id = get_the_author_meta('ID');
                        $author_profile_link = get_author_posts_url($author_id);
                       ?>
                       <div class="col-12 col-md-4 mb-35 mb-md-55">
                           <!-- News Post -->
                           <article class="news-post">
                               <div class="image-holder">
                                <?php 
                   
                                if(!empty($permalinkget || $image[0])){
                                ?>
                                   <a href="<?php echo esc_html($permalinkget);?>">
                                       <img src="<?php echo esc_url_raw($image[0]);?>" width="482" height="315" alt="Image Description">
                                   </a>
                                   <?php  }?>
                               </div>
                               <div class="textbox">
                               <?php 
                                if(!empty($permalinkget || $title)){
                                ?>
                                   <h3 class="h4"> <a href="<?php echo esc_html($permalinkget);?>"><?php echo esc_html($title);?></a></h3>
                                   <?php 
                                }
                                ?>
                                   <ul class="post-meta">
                                       <li><i class="jobcircle-icon-calendar1 icon"></i>
                                       <?php 
                                         if(!empty($formatted_date)){
                                        ?>

                                           <time class="text" datetime="2023-03-20">&nbsp;&nbsp;<?php echo esc_html($formatted_date);?></time>
                                           <?php 
                                           }?>
                                       </li>
                                       <li><i class="jobcircle-icon-comments icon"></i> <span class="text">&nbsp;&nbsp;<?php echo esc_html($comments_number)?> <?php esc_html_e(' Comments', 'jobcircle_frame') ?></span></li>
                                       
                                   </ul>
                                   
                                   <?php 
                                        if(!empty($excerpt)){
                                    ?>
                                    <p><?php echo esc_html($excerpt)?></p>
                                    <?php 
                                        }
                                        ?>
                               </div>
                               <footer class="post-footer">
                                <?php if(!empty($permalinkget)){ ?>
                            <a href="<?php echo esc_html($permalinkget)?>" class="read-more"><?php echo esc_html_e('Read More','jobcircle-frame');?><i class="jobcircle-icon-arrow-right1 icon"></i></a>
                           <?php 
                                        }
                                        ?>
                                 <?php if(!empty($author_profile_link) || !empty($admin)){ ?>
                            <span class="post-author"><?php echo esc_html_e('By:' ,'jobcirlcle-frame');?><a href="<?php echo esc_html($author_profile_link) ?>"> <?php echo esc_html($admin);?></a></span>
                                                      <?php 
                                        }
                                        ?>
                        </footer>
                           </article>
                       </div>
                       <?php
                   }
                
               }
               // Restore original post data.

               wp_reset_postdata();
               ?>
               </div>
           </div>
       </section>
       <?php
    }
    elseif ($atts['news'] == 'news_style_five') {
        ob_start();
        if(!empty($bg_img)){
        ?>
       <section class="section section-theme-5 news-block bg-light-sky pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100" style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');">
           <?php } ?>
				<div class="container">
					<!-- Section header -->
					<header class="section-header d-flex flex-column text-center mb-20 mb-lg-40">
                        <?php 
                        if(!empty($title)) { ?>
						<h2 class="order-2"><?php echo esc_html($title);?></h2>
                        <?php } ?>
                        <?php 
                        if(!empty($desc)) { ?>
						<p class="order-1"><?php echo esc_html($desc);?></p>
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
                           'terms'    => 'recent-news	',
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
                       $comments_number = get_comments_number($post);
                       $title = get_the_title($post);
                       $content = get_the_content();
                       $excerpt = get_the_excerpt($post);
       
                       $permalinkget = get_the_permalink($post);
                       $posted = get_the_time('U');
                       $minut =  human_time_diff($posted,current_time( 'U' )). "";
                       $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                       $read_more = get_post_meta($post, 'jobcircle_field_read_more', true);
                       $read_more_url = get_post_meta($post, 'jobcircle_field_read_more_url', true);
                       $date = date('F j, Y');
                       ?>
                       <div class="news-post-box">
									<div class="image-holder">
									    <?php if(!empty($permalinkget && $image)){
									        ?>
									<a href="<?php echo jobcircle_esc_the_html($permalinkget)?>"><img src="<?php echo esc_url_raw($image[0])?>" alt="image"></a>
									<?php 
									    }
									    ?>
									</div>
									<div class="news-info">
										<div class="title-bar">
										    <?php
                                        $terms = get_terms(array(
                                            'taxonomy' => 'job_category',
                                            'post_type' => 'jobs',
                                            'hide_empty' => false,
                                            'parent' => 0,
                                        ));

                                        $counter = 0;
                                        foreach ($terms as $term) {
                                            $term_link = get_term_link($term);
                                            if ($counter <= 0) {
                                                // Query to get the post count for each term
                                                $args = array(
                                                    'post_type' => 'jobs',
                                                    'tax_query' => array(
                                                        array(
                                                            'taxonomy' => 'job_category',
                                                            'field' => 'term_id',
                                                            'terms' => $term->term_id,
                                                        ),
                                                    ),
                                                );
                                                
                                                ?>
											<span class="sub-title"><a class="text-dark" href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name)?></a></span>
											
											
											<?php 
											$counter++;
											
                                        }else{
                                            break;
                                        }
                                        }
                                            if(!empty($title) && !empty($permalinkget)){?>
											<h3><a href="<?php echo jobcircle_esc_the_html($permalinkget)?>"><?php echo esc_html($title)?></a></h3>
											<?php } ?>
										</div>
										<ul class="list-inline meta-links m-0">
											<li class="list-inline-item">
											    <?php if(!empty($date)){
										        ?>
												<time class="date" datetime="2024-12-31"><?php echo esc_html($date)?></time>
												<?php } ?>
											</li>
											<li class="list-inline-item">
											  
												<a href="<?php echo esc_html($permalinkget)?>"> <?php echo esc_html($comments_number)?> <?php esc_html_e(' Comments')?></a>
											
											</li>
										</ul>
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
    } elseif ($atts['news'] == 'news_style_six') {
        ob_start();
        ?>
 			<section class="section section-theme-3 news-block pt-35 pt-md-50 pt-lg-75 pt-xxl-100 pb-35 pb-md-50 pb-lg-65 pb-xxl-80">
				<div class="container">
					<!-- Section header -->
					<header class="section-header text-center mb-20 mb-lg-40">
                        <?php
                    if(!empty($title)){ ?>
						<h2><?php echo esc_html($title);?></h2>
                        <?php } ?>
                        <?php
                    if(!empty($desc)){ ?>
						<p><?php echo esc_html($desc);?></p>
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
                                if(!empty($image) && !empty($permalinkget)){ ?>
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
												<li><?php echo esc_html($posted_date) ?></li>
                                                <?php } ?>
											</ul>
                                             <?php
                                if(!empty($title) && !empty($permalinkget)){ ?>
											<h3><a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></h3>
                                            <?php } ?>
										</div>
                                        <?php if(!empty($excerpt)){ ?>
										<p><?php echo esc_html($excerpt) ?></p>
                                         <?php } ?>
                                        <?php if(!empty($permalinkget)){ ?>
										<a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-brown btn-sm"><span class="btn-text"><i class="jobcircle-icon-chevron-right"></i></span></a>
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
    }

    return ob_get_clean();
}

add_shortcode( 'jc_news_post', 'jobcircle_news_post_frontend' );
