<?php
function jobcircle_banner_two(){
       $terms = get_terms(
		array(
			'taxonomy' => 'job_category',
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
            'name' => __('Home Banners'),
            'base' => 'jc_banner_two',
            'category' => __('Job Circle'),
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
                        'Banner Home' => 'jobcircle_style_one',
                        'Banner Home Theme 2' => 'jobcircle_style_two',
                        'Banner Home Theme 3' => 'jobcircle_style_three',
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
		  'type' => 'checkbox',
		  'holder' => 'div',
		  'class' => '',
		  'heading' => __('Checkbox Options'),
		  'param_name' => 'checkbox_param',
		  'value' => $job_types,
          'dependency' => array(
            'element' => 'jobcircle_style',  //selection param name
            'value' => array('jobcircle_style_two' , 'jobcircle_style_three') // depend on selection 
        ),
		),
              array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Banner Top'),
                'param_name' => 'banner_top',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_one') // depend on selection 
                ),
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Banner Bottom'),
                'param_name' => 'banner_bottom',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_one') // depend on selection 
                ),
            ),
            array(
                'type' => 'jobcircle_browse_img',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Banner Icon'),
                'param_name' => 'banner_icon',
                'dependency' => array(
                    'element' => 'jobcircle_style',  //selection param name
                    'value' => array('jobcircle_style_one') // depend on selection 
                ),
            ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'main_titl',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Short Description'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Job Button'),
                    'param_name' => 'btn',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'banner_img',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one','jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'recruiter_img',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'recruiter_title',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img_1',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one','jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img_2',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one','jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img_3',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one','jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img_4',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one','jobcircle_style_three') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'pop_txt',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three' , 'jobcircle_style_two') // depend on selection 
                    ),
                ),


                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Afinity Label'),
                    'param_name' => 'afinity_label',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one',) // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Developer Designation'),
                    'param_name' => 'devel_desig',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one') // depend on selection 
                    ),
                ),
                
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'bus_txt',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one',) // depend on selection 
                    )
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img_cursor',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_one') // depend on selection 
                    ),
                ),
               array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'pat_img',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'ban_img',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
              
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'icon1_img',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'icon2_img',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_two') // depend on selection 
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sb_titl',
                    'dependency' => array(
                        'element' => 'jobcircle_style',  //selection param name
                        'value' => array('jobcircle_style_three') // depend on selection 
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_banner_two');
function jobcircle_banner_two_frontend($atts, $content)
{

	global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(
            'banner_top' => '',
            'banner_bottom' => '',
            'banner_icon' => '',
            'main_titl' => '',
            'disc' => '',
            'btn' => '',
            'banner_img' => '',
            'recruiter_img' => '',
            'recruiter_title' => '',
            'img_1' => '',
            'img_2' => '',
            'img_3' => '',
            'img_4' => '',
            'afinity_label' => '',
            'devel_desig' => '',            
            'bus_txt' => '',
            'img_cursor' => '',
            'video_txt' => '',
            'pat_img' => '',
            'ban_img' => '',
            'icon1_img' => '',
            'icon2_img' => '',
            'sb_titl' => '',   
    		'checkbox_param' => '',


		    'jobcircle_page' => '',        
                               
            'jobcircle_style' => '',           
            
        ),
        $atts,
        'jobcircle_banner_two');

    $banner_top = isset($atts['banner_top']) ? $atts['banner_top'] : '';
    $banner_bottom = isset($atts['banner_bottom']) ? $atts['banner_bottom'] : '';
    $banner_icon = isset($atts['banner_icon']) ? $atts['banner_icon'] : '';
    $main_titl = isset($atts['main_titl']) ? $atts['main_titl'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $btn = isset($atts['btn']) ? $atts['btn'] : '';
    $banner_img = isset($atts['banner_img']) ? $atts['banner_img'] : '';
    $recruiter_img = isset($atts['recruiter_img']) ? $atts['recruiter_img'] : '';
    $recruiter_title = isset($atts['recruiter_title']) ? $atts['recruiter_title'] : '';
    $img_1 = isset($atts['img_1']) ? $atts['img_1'] : '';
    $img_2 = isset($atts['img_2']) ? $atts['img_2'] : '';
    $img_3 = isset($atts['img_3']) ? $atts['img_3'] : '';
    $img_4 = isset($atts['img_4']) ? $atts['img_4'] : '';
    $afinity_label = isset($atts['afinity_label']) ? $atts['afinity_label'] : '';
    $devel_desig = isset($atts['devel_desig']) ? $atts['devel_desig'] : '';
    $bus_txt = isset($atts['bus_txt']) ? $atts['bus_txt'] : '';
    $img_cursor = isset($atts['img_cursor']) ? $atts['img_cursor'] : '';
    $video_txt = isset($atts['video_txt']) ? $atts['video_txt'] : '';
    $pat_img = isset($atts['pat_img']) ? $atts['pat_img'] : '';
    $ban_img = isset($atts['ban_img']) ? $atts['ban_img'] : '';
    $icon1_img = isset($atts['icon1_img']) ? $atts['icon1_img'] : '';
    $icon2_img = isset($atts['icon2_img']) ? $atts['icon2_img'] : '';
    $sb_titl = isset($atts['sb_titl']) ? $atts['sb_titl'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
  


 $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';


    global $jobcircle_framework_options;

    $select_job_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';

    $job_page_id = jobcircle_get_page_id_from_name($select_job_page);

    $job_page_url = '';
    if ($job_page_id > 0) {
        $job_page_url = get_permalink($job_page_id);
    }

if ($atts['jobcircle_style'] == 'jobcircle_style_two') {
    ob_start();
    ?>
<div class="visual-block visual-theme-1 banner_sixm bg-dark-green pt-40 pt-md-65 pb-40 pb-md-65 pb-xl-85 text-white">
			<div class="container position-relative">
				<div class="row justify-content-between">
					<div class="col-12 col-lg-7 col-xl-6 position-relative">
						<!-- visual textbox -->
						<div class="visual-textbox">
                            <?php
                            if(!empty($main_titl)) {
                            ?>
							<h1><?php echo esc_html($main_titl); ?></h1>
                            <?php 
                            } 
                            if(!empty($disc)){
                                ?>
							<p><?php echo esc_textarea($disc); ?></p>
                            <?php
                            }
                        $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
                            ?>
							<!-- search form -->
							<?php if(!empty($job_page_url)){ ?>
							<form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get" ">
							    <?php } ?>
							    <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
								<div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
								</div>
									<div class="form-group  jc-form-marg">
									<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
									<select class="select2" name="job_category"
										data-placeholder="<?php esc_html_e('Choose Category', 'jobcircle-frame') ?>">
										<option label="Placeholder"></option>
										<?php
										$cat_terms = get_terms(
											array(
												'taxonomy' => 'job_category',
											)
										);
										if (!empty($cat_terms)) {
											foreach ($cat_terms as $cat_term) {
												?>
												<option value="<?php echo esc_html($cat_term->slug) ?>"
													id="cat-<?php echo esc_html($cat_term->term_id) ?>">
													<?php echo esc_attr($cat_term->name) ?>
												</option>
												<?php
											}
											;
										}
										?>
									</select>
								</div>
								</div>
								<button class="btn btn-green btn-sm" type="submit"><span class="btn-text"><?php esc_html_e('Find Job','jobcircle-frame') ?></span></button>
							</form>
							<div class="popular-searches">
								<strong class="subtitle"><?php echo esc_html_e('Popular Searches:' , 'jobcircle-frame'); ?></strong>
								<ul>
                                <?php
                            // $counter = 0;
                        //   $include_category_ids = $job_type_arr;
                              
                                 $args = array(
                        'taxonomy' => 'job_category',
                        'post_type' => 'jobs',
                        'hide_empty' => true,
                        'parent' => 0,
                        'orderby' => 'term_id',
                    );
                    if(isset($job_type_arr) && !empty($job_type_arr)){
                        $args['include'] = $job_type_arr ;
                    }else{
                 
                    }
                    $cat_terms = get_terms($args); 
                            if (!empty($cat_terms)) {
 $counter = 0;
                            foreach ($cat_terms as $cat_term) {
                                if($counter < 3 || !empty($job_type_arr)){
                                $term_link = get_term_link( $cat_term );
                                $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                            
                                $jobcircle_page_url = home_url('/');
                                if ($jobcircle_page_id > 0) {
                                    $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                }
                                if(!empty($jobcircle_page_url)){
                                ?>
									<li><a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo esc_html($cat_term->slug) ?>"><?php echo esc_html($cat_term->name) ?></a></li>
                                <?php
                                }
                            }
                             $counter++;}
                            }
                            ?>        
								</ul>
							</div>
							<div class="bg-patterns">
                                <?php 
                                if(!empty($pat_img)){?>
								<img src="<?php echo esc_url_raw($pat_img); ?>" width="242" height="423" alt="Icons">
                                <?php 
                                }
                                ?>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-5 col-xl-6 d-flex justify-content-center align-items-center">
						<!-- visual Image -->
						<div class="visual-image position-relative">
                            <?php 
                            if(!empty($ban_img)){
                                ?>
							<img src="<?php echo esc_url_raw($ban_img); ?>" width="642" height="494" alt="Find The Perfect Job For You">
                            <?php 
                            }
                            ?>
							<div class="icons-black">
                                <?php 
                            if(!empty($icon1_img)){
                                ?>
								<img src="<?php echo esc_url_raw($icon1_img); ?>" width="306" height="321" alt="Icons">
                                <?php } ?>
							</div>
							<div class="icon-circle">
                                <?php 
                                if(!empty($icon2_img)){
                                ?>
								<img src="<?php echo esc_url_raw($icon2_img); ?>" width="95" height="95" alt="Icons">
                                <?php 
                                }
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    
<?php
    }
    elseif ($atts['jobcircle_style'] == 'jobcircle_style_one') {
        ob_start();
    ?>
    <div class="visual-block bg-blue pt-100 pt-md-140 pt-xl-180 pt-xxl-230 pb-25 pb-md-45 text-white">
    <?php
        if(!empty($banner_top)){
            ?>
			<span class="shape top"><img src="<?php echo esc_url_raw($banner_top); ?>" width="93" height="241" alt="Banner Shape Top"></span>
            <?php
        }
        ?>
                 <?php
        if(!empty($banner_bottom)){
            ?>
			<span class="shape bottom"><img src="<?php echo esc_url_raw($banner_bottom); ?>" width="1115" height="347" alt="Banner Shape Bottom"></span>
            <?php
        }
        ?>
			<div class="container position-relative">
				<div class="row justify-content-between">
					<div class="col-12 col-lg-7 position-relative">
                    <?php
        if(!empty($banner_icon)){
            ?>
			<div class="icons-image"><img src="<?php echo esc_url_raw($banner_icon); ?>" width="446" height="638" alt="Icons"></div>
         <?php
        }
        ?>
	<!-- visual textbox -->
				<div class="visual-textbox">
                 <?php
              if(!empty($main_titl)){
               ?>
				<h1><?php echo esc_html($main_titl) ?></h1>
                 <?php
                  }
                 ?>
                 <?php
        if(!empty($disc)){
            ?>
							<p><?php echo esc_textarea($disc) ?></p>
                            <?php
        }
    	                $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
        ?>
							<!-- search form -->

                            <form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get">

							<div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
								<div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
								</div>
								<div class="form-group jc-form-marg">
									<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
									<select class="select2" name="job_category"
										data-placeholder="<?php esc_html_e('Choose Category', 'jobcircle-frame') ?>">
										<option label="Placeholder"></option>
										<?php
										$cat_terms = get_terms(
											array(
												'taxonomy' => 'job_category',
											)
										);
										if (!empty($cat_terms)) {
											foreach ($cat_terms as $cat_term) {
												?>
												<option value="<?php echo esc_html($cat_term->slug) ?>"
													id="cat-<?php echo esc_html($cat_term->term_id) ?>">
													<?php echo esc_attr($cat_term->name) ?>
												</option>
												<?php
											}
											;
										}
										?>
									</select>
								</div>
								</div>
                                <?php
                                if(!empty($btn)){
                                    ?>
								<button class="btn btn-primary" type="submit"><span class="btn-text"><?php echo esc_html($btn) ?></span></button>
                                <?php
                                    }
                                    ?>  
							</form>
						</div>
					</div>
					<div class="col-12 col-lg-5 d-flex justify-content-center justify-content-lg-end">
						<!-- visual Image -->
						<div class="visual-image position-relative">
                        <?php
                            if(!empty($banner_img)){
                                ?>
							<img src="<?php echo esc_url_raw($banner_img) ?>" width="563" height="733" alt="Finding a Job Has Never Been This Easy">
                            <?php
                                }
                                ?>
    							<!-- recruiter box -->
							<div class="recruiter-box">
								<div class="recruiter-image">
                                <?php
                                    if(!empty($recruiter_img)){
                                        ?>
									<img src="<?php echo esc_url_raw($recruiter_img) ?>" alt="Recruiter">
                                    <?php
                                    }
                                    ?>
								</div>
                                <?php
                                    if(!empty($recruiter_title)){
                                        ?>
								<strong class="title"><?php echo esc_html($recruiter_title) ?></strong>
                                <?php
                                }
                                ?>
							</div>
							<!-- users box -->
							<div class="users-box">
								<strong class="title"><?php esc_html_e('20000+ User','jobcircle-frame')?></strong>
								<ul class="users-list">
                                <?php
                                    if(!empty($img_1)){
                                        ?>
									<li><img src="<?php echo esc_url_raw($img_1) ?>" width="60" height="60" alt="User"></li>
                                    <?php
                                        }
                                if(!empty($img_2)){
                                    ?>
									<li><img src="<?php echo esc_url_raw($img_2) ?>" width="60" height="60" alt="User"></li>
                                    <?php
                                        }
                                    if(!empty($img_3)){
                                        ?>
									<li><img src="<?php echo esc_url_raw($img_3) ?>" width="60" height="60" alt="User"></li>
                                    <?php
                                    }
                                    if(!empty($img_4)){
                                        ?>
									<li><img src="<?php echo esc_url_raw($img_4) ?>" width="60" height="60" alt="User"></li>
                                    <?php
                                    }
                                    ?>
									<li><i class="jobcircle-icon-plus"></i></li>
								</ul>
							</div>
							<!-- Vacancy Box -->
							<div class="vacancy-box">
								<div class="vacancy-wrap d-flex align-items-end justify-content-between position-relative">
                               

                            <strong class="title">
                                <?php 
                                if(!empty($afinity_label || $devel_desig)){
                                    ?>
                                <span><?php echo esc_html($afinity_label) ?></span>
                                <?php echo esc_html($devel_desig); ?>
                                <?php 
                                }
                                ?>
                            </strong>
                        <?php
                        if(!empty($bus_txt)){
                        ?>
						<a href="<?php echo esc_html($bus_txt) ?>" class="btn btn-info"><span class="btn-text"><?php echo esc_html_e('Apply' ,'jobcircle-frame')?></span></a>
                        <?php
                        }
                        ?>
         <?php
        if(!empty($img_cursor)){
        ?>
		<div class="cursor"><img src="<?php echo esc_url_raw($img_cursor) ?>" alt="Cursor"></div>
        <?php
        }
        ?>
								</div>
								<!-- Star Ratings -->
								<ul class="star-ratings">
									<li><i class="jobcircle-icon-star filled"></i></li>
									<li><i class="jobcircle-icon-star filled"></i></li>
									<li><i class="jobcircle-icon-star filled"></i></li>
									<li><i class="jobcircle-icon-star filled"></i></li>
									<li><i class="jobcircle-icon-star"></i></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
    }
    elseif ($atts['jobcircle_style'] == 'jobcircle_style_three') {
        ob_start();
        ?>
         <div class="visual-block visual-theme-3 bg-dark-blue pt-100 pt-md-140 pt-xl-180 pb-45 pb-md-80 pb-lg-60 text-white">
			<div class="container position-relative">
				<div class="row justify-content-between">
					<div class="col-12 col-lg-7 col-xl-6 position-relative">
						<!-- visual textbox -->
						<div class="visual-textbox">
                        <?php
        if(!empty($main_titl) || !empty($sb_titl) ){
            ?>
				<h1><?php echo esc_html($main_titl) ?><span class="text-outlined"><?php echo esc_html($sb_titl) ?></span></h1>
            <?php
        }
        ?>
		<?php
        if(!empty($disc)){
        ?>
		<p><?php echo esc_textarea($disc) ?></p>
        <?php
        }
        ?>
							
							<!-- search form -->
							<?php if(!empty($job_page_url)){
							    ?>
							<form class="form-search" method="get" action="<?php echo esc_html($job_page_url) ?> ">
							    <?php
							}?>
								<div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
									<div class="form-group">
										<i class="jobcircle-icon-search icon"></i>
										<input class="form-control" type="search" placeholder="<?php echo esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
									</div>
									<div class="form-group">
									<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
										<select class="select2" name="job_category" data-placeholder="Select Category">
                                <option label="Placeholder"></option>
                                    <?php 
                                     $cat_terms = get_terms( array(
                                        'taxonomy'   => 'job_category',
                                        'hide_empty' => false,
                                    ) );
                                    if (!empty($cat_terms)) {
                                        foreach ($cat_terms as $cat_term) {
                                            ?>
                                            <option value="<?php echo esc_html($cat_term->slug) ?>"><?php echo esc_html($cat_term->name) ?></option>
                                            <?php
                                        }
                                    }
                                    ?>                                   
                                </select>
									</div>
								</div>
                                <?php
                                if(!empty($btn)){
                                    ?>
								<button class="btn btn-dark-yellow btn-sm" type="submit"><span class="btn-text"><?php echo esc_html($btn) ?></span></button>
                                <?php
                                }
                                ?> 
								
							</form>
							<!-- users box -->
							<div class="users-box">
								<strong class="title"><?php esc_html_e('14k active candidate','jobcircle-frame')?></strong>
								<ul class="users-list">
                                        <?php
                                            if(!empty($img_1)){
                                        ?>
                                				<li><img src="<?php echo esc_url_raw($img_1) ?>" width="60" height="60" alt="User"></li>
                                         <?php
                                            }
                                            ?>
                                		<?php
                                        if(!empty($img_2)){
                                            ?>
                                			<li><img src="<?php echo esc_url_raw($img_2) ?>" width="60" height="60" alt="User"></li>
                                         <?php
                                        }
                                        ?>
                                		<?php
                                        if(!empty($img_3)){
                                            ?>
                                				<li><img src="<?php echo esc_url_raw($img_3) ?>" width="60" height="60" alt="User"></li>
                                                 <?php
                                        }
                                        ?>
                                		<?php
                                        if(!empty($img_4)){
                                        ?>
                                				<li><img src="<?php echo esc_url_raw($img_4) ?>" width="60" height="60" alt="User"></li>
                                        <?php
                                        }
                                        ?>
									
									<li><i class="jobcircle-icon-plus"></i></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-5 col-xl-6 d-flex justify-content-center justify-content-lg-end">
						<!-- visual Image -->
						<div class="visual-image position-relative">
                        <?php
                    if(!empty($banner_img)){
                        ?>
				<img src="<?php echo esc_url_raw($banner_img) ?>" width="638" height="704" alt="Find the dream job that suit your talent here.">
                 <?php
                        }
                        ?>
							
						</div>
					</div>
				</div>
			</div>
		</div>
        <?php 
    }
$html = ob_get_clean();
return $html;

}
add_shortcode('jc_banner_two', 'jobcircle_banner_two_frontend');