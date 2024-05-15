<?php
function jobcircle_candidate_banner(){
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
            'name' => __('Candidate Search Banner'),
            'base' => 'jobcircle_candidate_banner',
            'category' => __('Job Circle'),
            'params' => array(
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
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_candidate_banner');
function jobcircle_candidate_banner_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

        'bg_image' => '',
      'jobcircle_page' => '', 
        'banner_color' => '',
        ),
        $atts,
        'jobcircle_candidate_banner'
    );


    $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
    $banner_color = isset($atts['banner_color']) ? $atts['banner_color'] : '';
   
   $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
   
   global $jobcircle_framework_options;

    $select_job_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';

    $job_page_id = jobcircle_get_page_id_from_name($select_job_page);

    $job_page_url = '';
    if ($job_page_id > 0) {
        $job_page_url = get_permalink($job_page_id);
    }
    ob_start()
?>
 
 <div class="subvisual-block bg-dark-green mg-km d-flex align-items-center pt-100 pt-md-140 pt-xl-180 pt-xxl-230 pb-40 pb-md-70 pb-lg-50 pb-xl-65 text-white">
<?php if(!empty($banner_color)){ ?>
      <style>
.subvisual-block.bg-dark-green{
background-color:<?php echo jobcircle_esc_the_html($banner_color); ?>!important;
}
</style>
<?php } ?>
			<span class="shape top"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-shape-top.webp" width="93" height="241" alt="Banner Shape Top"></span>
			<span class="shape bottom"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-inner-bottom.png" width="979" height="249" alt="Banner Shape Bottom"></span>
			<div class="icons-image"><img src="<?php echo esc_url_raw($bg_image) ?>" width="1187" height="274" alt="Icons"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<?php 
						 $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						if($jobcircle_page !=''){
						     $job_select_page = $jobcircle_page;
						 }
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
						<!-- search form -->
						
						<form class="form-search form-inline" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
							<div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
								<div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>" name="keyword">
								</div>
								<div class="form-group">
              <span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
									<select class="select2 select2-hidden-accessible" name="job_category" data-placeholder="Choose Category">
										<option label="Placeholder"></option>
								<?php 
                                     $cat_terms = get_terms( array(
                                        'taxonomy'   => 'candidate_cat',                                       
                                    ) );
                                    if (!empty($cat_terms)) {                                       
                                    foreach ($cat_terms as $cat_term) {   ?>
                                    <option value="<?php echo jobcircle_esc_the_html($cat_term->slug) ?>"><?php echo jobcircle_esc_the_html($cat_term->name )?></option>
                            <?php                                       
                                        }
                                     }                                 
                                    ?>       
									</select>
								</div>
							</div>
							<button class="btn btn-primary" type="submit"><span class="btn-text"><?php echo esc_html_e('Search Now','jobcircle-frame');?></span></button>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
$html = ob_get_clean();
return $html;
}
add_shortcode('jobcircle_candidate_banner', 'jobcircle_candidate_banner_frontend');