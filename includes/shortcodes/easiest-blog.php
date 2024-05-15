<?php
   function jobcircle_easiest_blog() {  
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
             'name' => __( 'Easiest Blog' ),
             'base' => 'jobcircle_easiest_blog',
             'category' => __( 'job Circle' ),
             'params' => array(
                    array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Post Title FontSize'),
                    'param_name' => 'font_size',
                    ),
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
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Blog Columns Style', 'jobcircle-frame'),
                    'param_name' => 'jobcircle_style',
                    'description' => __('Select Jobcircle Style', 'jobcircle-frame'),
                    'value' => array(
                        'Select Style' => '',
                        'Blog Full Width' => 'blog_full_width',
                        'Blog Columns 2' => 'blog_column_2',
                        'Blog Columns 3' => 'blog_column_3',
                        'Blog Columns 4' => 'blog_column_4',
                    ),
                    ),
                    array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Title' ),
                    'param_name' => 'head',
                    ),
                    array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Description' ),
                    'param_name' => 'disc',
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
add_action( 'vc_before_init', 'jobcircle_easiest_blog' );

// popular category frontend
function jobcircle_easiest_blog_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
        'head' => '', 
        'disc' => '',
    	'checkbox_param' => '',
    	'font_size' => '',
        'orderby' => '',
		'numofpost' => '',
		'jobcircle_style' => '',
        'blog_page_style' => '',

    ), $atts, 'jobcircle_easiest_blog');
        $head  = isset($atts['head']) ? $atts['head'] : '';
        $disc  = isset($atts['disc']) ? $atts['disc'] : '';
        $jobcircle_style  = isset($atts['jobcircle_style']) ? $atts['jobcircle_style'] : '';
        $blog_page_style  = isset($atts['blog_page_style']) ? $atts['blog_page_style'] : '';
        $font_size = isset($atts['font_size']) ? $atts['font_size'] : '';
        $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
        $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';

 
ob_start();

if ($atts['blog_page_style'] == 'blog_full_width') {
         $container ='container-fluid';
     }else{
         $container ='container';
     }
?>
<style>
.pedings {
    padding-top:90px !important;
}
</style>

<section class="recent_articles_block section-theme-7">
	<div class="<?php echo $container ?>">
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
		<div class="row mb-0">

<?php
        $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
//this one
        $page_numbr = get_query_var('paged');
        $include_category_ids = $job_type_arr;

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
                $date = get_the_date('M, d, Y');
                
                if ($atts['jobcircle_style'] == 'blog_column_2') {
                     $columns='col-12 col-md-6 col-lg-6 mb-30 mb-lg-70';
                 }elseif ($atts['jobcircle_style'] == 'blog_column_3') {
                     $columns='col-12 col-md-6 col-lg-4 mb-30 mb-lg-70';
                 }elseif ($atts['jobcircle_style'] == 'blog_column_4') {
                     $columns='col-12 col-md-6 col-lg-3 mb-30 mb-lg-70';
                 }else{
                     $columns='col-12 col-md-6 col-lg-4 mb-30 mb-lg-70';
                 }

?>
<div class="<?php echo $columns ?>">
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
						<a href="<?php echo the_permalink(); ?>"><strong class="h5" style="font-size:<?php echo $font_size ?>px;"><?php echo esc_html($title) ?></strong></a>
						<p><?php echo esc_html($excerpt)  ?></p>
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
add_shortcode( 'jobcircle_easiest_blog', 'jobcircle_easiest_blog_frontend' );