<?php
   function jobcircle_recent_article_home7() {  
       $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => false,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map( 
       array(
             'name' => __( 'Recent Articles 7' ),
             'base' => 'recent_article_home7',
             'category' => __( 'job Circle' ),
             'params' => array(
              
                     
                     array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Description' ),
                    'param_name' => 'disc',
                   ),
                   array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Title' ),
                    'param_name' => 'head',
                   ),
             
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Button' ),
                    'param_name' => 'btn',
                   ),
                   array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Button Url' ),
                    'param_name' => 'btn_url',
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
        		  'heading' => __('Select Category For Post'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
        		),
          )
         )
        
      );
}
add_action( 'vc_before_init', 'jobcircle_recent_article_home7' );

// popular category frontend
function jobcircle_recent_article_home7_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
        'head' => '', 
        'disc' => '',
        'btn_url' => '',
        'btn' => '',
        'orderby' => '',
		'numofpost' => '',
	    'dropdown_param' => '',

    ), $atts, 'jobcircle_recent_article_home7');
    $head  = isset($atts['head']) ? $atts['head'] : '';
    $disc  = isset($atts['disc']) ? $atts['disc'] : '';
    $btn  = isset($atts['btn']) ? $atts['btn'] : '';
    $btn_url  = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    
    $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
    $job_type_arry = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
 
ob_start()
?>
<style>
.pedings {
    padding-top:90px !important;
}
</style>

<section class="recent_articles_block section-theme-7">
	<div class="container">
		<header class="section-header d-flex flex-column text-center mb-30 mb-md-45 mb-xl-25">
        <?php
                    if(!empty($disc)){ ?>
			<p><?php echo esc_textarea($disc)  ?></p>
            <?php } ?>
            <?php
                    if(!empty($head)){ ?>
			<h2><?php echo  esc_html($head) ?></h2>
            <?php } ?>
		</header>
		<div class="row mb-50">

<?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
//this one
        //this one
         $include_category_ids = $job_type_arry;

        
        $page_numbr = get_query_var('paged');
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $numofpost,
            'order' => 'DESC',
            'paged' => $page_numbr,
            'orderby' => $orderby,
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
        $query = new WP_Query( $args );
        $total_posts = $query->found_posts;
         
        // Check that we have query results.
        if ( $query->have_posts() ) {
        
            // Start looping over the query results.
            $count = 1;
            while ( $query->have_posts() ) {
                $query->the_post();
                global $post;
                $post =  get_post();   
                $postid =  $post->ID;       
                $title = get_the_title($postid);
                $excerpt = get_the_excerpt($postid);
                $permalinkget = get_permalink($postid);
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                $date = get_the_date('M, d, Y');


if(($count == $numofpost) && ($numofpost % 2 != 0)){ ?>
<div class="col-12 col-lg-4">
    <?php }else{ ?>
<div class="col-12 col-md-6 col-lg-4 mb-30 mb-lg-0">
    <?php }  ?>
				<div class="recent_article">
					<div class="img_holder">
                        <?php
                    if(!empty($image)){ ?>
					<a href="<?php echo the_permalink();?>"><img src="<?php echo esc_url_raw($image[0]) ?>" alt="jobcircle"></a>
                                    <?php } ?>
					</div>
					<div class="text_holder">
						<ul class="date_list">
                        <?php
                        $cat_terms = get_terms(array(
                            'taxonomy' => 'job_category',
                            'hide_empty' => false,
                        ));
                        
                        if (!empty($cat_terms)) {
                            $counter = 1;
                            foreach ($cat_terms as $cat_term) {
                                if ($counter == 1) {
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_term_link($cat_term)); ?>">
                                            <span class="text-green"><?php echo esc_html($cat_term->name); ?></span>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    break;
                                }
                                $counter++;
                            }
                        }
                        ?>
							<li>
							    <?php if (!empty($date)){ ?>
								<span><?php echo esc_html($date) ?></span>
							<?php } ?>
							</li>
						</ul>
						<?php if(!empty($title)  ||  !empty($excerpt)) { ?>
						<a href="<?php echo the_permalink(); ?>"><strong class="h5"><?php echo esc_html($title) ?></strong></a>
						<p><?php echo esc_html($excerpt)  ?></p>
						<?php } ?>
					</div>
				</div>
			</div>

<?php
            $count++;}
        }
       //also this one         
       
       wp_reset_postdata();
        ?>
</div>
		<div class="btn_wrap d-flex justify-content-center">
		    <?php if(!empty($btn_url) || !empty($btn)){ ?>
			<a href="<?php echo esc_html($btn_url)  ?>" class="btn btn-green btn-sm"><span class="btn-text"><?php echo  esc_html($btn) ?></span></a>
		<?php } ?> 
		</div>
	</div>
</section>
    <?php 
   
    return ob_get_clean();
}
add_shortcode( 'recent_article_home7', 'jobcircle_recent_article_home7_frontend' );