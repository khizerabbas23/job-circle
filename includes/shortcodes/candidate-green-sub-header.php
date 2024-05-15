<?php 
function candidate_green_sub_header() {
     $terms = get_terms(
		array(
			'taxonomy' => 'candidate_cat',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    $all_page = array( __('Select Page', 'jobcircle-frame'), '');
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    if (!empty($pages)) {
        foreach ($pages as $page) {
            $all_page[$page->post_title] = $page->post_name;
        }
    }
    vc_map(
        array(
            'name' => __( 'Candidate Green Sub Header' ),
            'base' => 'candidate_green_sub_header',
            'category' => __( 'Job Circle' ),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Jobcircle Style', 'jobcircle-frame'),
                    'param_name' => 'jobcircle_style',
                    'description' => __('Select Jobcircle Style', 'jobcircle-frame'),
                    'value' => array(
                        'Select Style' => '',
                        'Search Sub Header' => 'jobcircle_style_one',
                        'Sub Header' => 'jobcircle_style_two',
                        'Simple Search Sub Header' => 'jobcircle_style_three',
                    ),
              ),
                array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                'param_name' => 'jobcircle_page',
                'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                'value' =>  $all_page,
              ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Background Image' ),
                    'param_name' => 'bg_image',
                ),
                array(
                    'type' => 'colorpicker',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Select Banner Color' ),
                    'param_name' => 'banner_color',
                ),
				array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Paged Name' ),
                    'param_name' => 'page_name',
                ),
				array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Page Description' ),
                    'param_name' => 'page_desc',
                ),
            ),
			
            
        )
    );
}
add_action( 'vc_before_init', 'candidate_green_sub_header' );

//welcome Massage frontend
function candidate_green_sub_header_frontend( $atts, $content ) {
 
    $atts = shortcode_atts(
    array(
   
        'bg_image' => '',
        'banner_color' => '',
        'page_name' => '',
		'page_desc' => '',
'jobcircle_page' => '',
		'jobcircle_style' => '',

    ), $atts, 'candidate_green_sub_header'
);

$bg_image  = isset($atts['bg_image']) ? $atts['bg_image'] : '';
$banner_color  = isset($atts['banner_color']) ? $atts['banner_color'] : '';
$page_name  = isset($atts['page_name']) ? $atts['page_name'] : '';
$page_desc  = isset($atts['page_desc']) ? $atts['page_desc'] : '';
$jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
$jobcircle_style  = isset($atts['jobcircle_style']) ? $atts['jobcircle_style'] : '';

 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 
 global $jobcircle_framework_options;

    $select_job_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';

    $job_page_id = jobcircle_get_page_id_from_name($select_job_page);

    $job_page_url = '';
    if ($job_page_id > 0) {
        $job_page_url = get_permalink($job_page_id);
    }

 if ($atts['jobcircle_style'] == 'jobcircle_style_one') {
    ob_start();
    ?>
    
<div class="subvisual-block subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white">
     <style>
.subvisual-theme-1.bg-dark-green{
background-color:<?php echo jobcircle_esc_the_html($banner_color); ?> !important;
}
<?php if(empty($banner_color)){ ?>
.subvisual-theme-1.bg-dark-green {
background-image: url(<?php echo Jobcircle_Plugin::root_url()?>/images/visual-inner-theme1.jpg);
background-repeat: no-repeat;
background-size: cover;
}
<?php } ?>
</style>

			<div class="pattern-image"><img src="<?php echo esc_url_raw($bg_image) ?>" width="1920" height="570" alt="Pattern"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<div class="subvisual-textbox">
						    <?php if(!empty($page_name)){ ?>
							<h1><?php echo jobcircle_esc_the_html($page_name)?></h1>
							<?php } ?>
							 <?php if(!empty($page_desc)){ ?>
							<p><?php echo jobcircle_esc_the_html($page_desc)?></p>
							<?php } ?>
						</div>
							<?php 
						 $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
                         if($jobcircle_page !=''){
                            $job_select_page = $jobcircle_page;
                        }
                         $job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
                        <form class="form-search form-inline" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
							<div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
								<div class="form-group">
									<label for="rel01"><?php echo esc_html_e('What are you looking for?' , 'jobcircle-frame')?></label>
									<div class="form-input">
		                        	<input class="form-control" type="search" placeholder="What are you looking for?" name="keyword">
									</div>
								</div>
								<div class="form-group">
									<label for="rel02"><?php echo esc_html_e('Category' , 'jobcircle-frame')?></label>
									<div class="form-input">
										<select id="rel02" class="select2" name="state" data-placeholder="Category">
											<option label="Placeholder"></option>
                                            <?php 
                                     $cat_terms = get_terms( array(
                                        'taxonomy'   => 'candidate_cat',
                                        'hide_empty' => false,
                                    ) );
                                    if (!empty($cat_terms)) {
                                        foreach ($cat_terms as $cat_term) {
                                            ?>
											  <option value="<?php echo jobcircle_esc_the_html($cat_term->slug) ?>"><?php echo jobcircle_esc_the_html($cat_term->name) ?></option>
											<?php 
                                        }
                                    }
                                        ?>
										</select>
									</div>
								</div>
							</div>
							<button class="btn btn-green btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Find Job' , 'jobcircle-frame')?></span></button>
						</form>
					</div>
				</div>
			</div>
		</div>
       <?php
    }
    elseif ($atts['jobcircle_style'] == 'jobcircle_style_two') {
        ob_start();
    ?>

<div class="subvisual-block contact-banner-pt subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white">
     <style>
.subvisual-theme-1.bg-dark-green{
background-color:<?php echo jobcircle_esc_the_html($banner_color); ?>!important;
}
<?php if(empty($banner_color)){ ?>
.subvisual-theme-1.bg-dark-green {
background-image: url(<?php echo Jobcircle_Plugin::root_url()?>/images/visual-inner-theme1.jpg);
background-repeat: no-repeat;
background-size: cover;
}
<?php } ?>
</style>
			<div class="pattern-image">
            <?php if(!empty($bg_image)){?>    
            <img src="<?php echo esc_url_raw($bg_image)?>" width="1920" height="570" alt="Pattern">
            <?php }?>
        </div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<div class="subvisual-textbox">
                            <?php if(!empty($page_name)){?>
							<h1><?php echo jobcircle_esc_the_html($page_name)?></h1>
                            <?php }?>
                            <?php if(!empty($page_desc)){?>
							<p><?php echo esc_textarea($page_desc)?></p>
                            <?php }?>
						</div>
                        <nav class="breadcrumb-nav text-white d-flex justify-content-center mt-20 mt-lg-40">
							<ul class="breadcrumb mb-0">
								<li class="breadcrumb-item"><a href="<?php echo home_url(); ?>"><?php echo esc_html_e('Home' , 'jobcircle-frame')?></a></li>
                                <?php if(!empty($page_name)){?>
                                <li class="breadcrumb-item active"><?php echo jobcircle_esc_the_html($page_name)?></li>
                                <?php } ?>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
    <?php 
    }
     elseif ($atts['jobcircle_style'] == 'jobcircle_style_three') {
    ob_start();
    ?>
    
<div class="subvisual-block subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white">
     <style>
.subvisual-theme-1.bg-dark-green{
background-color:<?php echo jobcircle_esc_the_html($banner_color); ?>!important;
}
<?php if(empty($banner_color)){ ?>
.subvisual-theme-1.bg-dark-green {
background-image: url(<?php echo Jobcircle_Plugin::root_url()?>/images/visual-inner-theme1.jpg);
background-repeat: no-repeat;
background-size: cover;
}
<?php } ?>
</style>
		<div class="pattern-image"><img src="<?php echo esc_url_raw($bg_image) ?>" width="1920" height="570" alt="Pattern"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<div class="subvisual-textbox">
						    <?php if(!empty($page_name)){ ?>
							<h1><?php echo jobcircle_esc_the_html($page_name)?></h1>
							<?php } ?>
							 <?php if(!empty($page_desc)){ ?>
							<p><?php echo jobcircle_esc_the_html($page_desc)?></p>
							<?php } ?>
						</div>
                        <div class="form-subscribe mt-20 mt-lg-40 mb-md-10">
							<form action="#">
								<input class="form-control" type="text" placeholder="Find Queries" name="s">
								<button class="btn btn-green btn-search btn-sm"><span class="btn-text"><i class="jobcircle-icon-search"></i> <?php esc_html_e('Search', 'jobcircle-frame') ?></span></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
       <?php
    }
    return ob_get_clean();
}
add_shortcode( 'candidate_green_sub_header', 'candidate_green_sub_header_frontend' );