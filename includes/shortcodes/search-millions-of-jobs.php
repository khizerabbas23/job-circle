<?php
function jobcircle_search_millions_jobs()
{

	vc_map(

		array(
			'name' => __('Search Millions Of Jobs'),
			'base' => 'jobcircle_search_millions_jobs',
			'category' => __('Job Circle'),
			'params' => array(


				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Sub Title'),
					'param_name' => 'sub_title',
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
					'heading' => __('Highlight Title'),
					'param_name' => 'hig_title',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __(' Span Title'),
					'param_name' => 'span_title',
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Description'),
					'param_name' => 'desc',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Image'),
					'param_name' => 'img',
				),


				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'frst_multi',
					'params' => array(


						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Image'),
							'param_name' => 'mlti_img',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'multi_title',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'description',
						),
					),
				),

				//GROUP 2
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'second_multi',
					'params' => array(


						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'mlti_tit',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'mlti_desc',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Button Text'),
							'param_name' => 'btn_txt',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Button URL'),
							'param_name' => 'btn_url',
						),

						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Image'),
							'param_name' => 'mlti_images',
						),


					),
				)
			)


		)
	);
}
add_action('vc_before_init', 'jobcircle_search_millions_jobs');


// Frontend Coding 

function jobcircle_search_millions_jobs_front($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'sub_title' => '',
			'title' => '',
			'hig_title' => '',
			'span_title' => '',
			'desc' => '',
			'img' => '',


			'frst_multi' => '',
			'second_multi' => '',

		),
		$atts,
		'jobcircle_search_millions_jobs'
	);

	$sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$hig_title = isset($atts['hig_title']) ? $atts['hig_title'] : '';
	$span_title = isset($atts['span_title']) ? $atts['span_title'] : '';
	$desc = isset($atts['desc']) ? $atts['desc'] : '';
	$img = isset($atts['img']) ? $atts['img'] : '';

	ob_start();

	?>
	
	<section
		class="section section-theme-13 search-jobs-block bg-white pt-20 pt-lg-40 pt-xl-0 pb-0 pb-md-50 pb-lg-65 pb-xxl-100">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12 col-md-6">
					<div class="text">
					    <?php if(!empty($sub_title)) { ?>
						<strong class="sub-heading"><?php echo esc_html($sub_title) ?></strong><?php  } ?>
						<?php if((!empty($sub_title) || !empty($hig_title)) && !empty($span_title)) { ?>
						<h2><?php echo esc_html($title) ?> <strong><?php echo esc_html($hig_title) ?></strong> <?php echo esc_html($span_title) ?></h2> <?php } ?>
					<?php if(!empty($desc)) { ?>
						<p><?php echo esc_textarea($desc) ?></p> <?php } ?>
						<ul class="list-unstyled list">
							<?php

							$lm_team_list = vc_param_group_parse_atts($atts['frst_multi']);

							foreach ($lm_team_list as $key => $value) {

								$mlti_img = isset($value["mlti_img"]) ? $value["mlti_img"] : '';
								$multi_title = isset($value["multi_title"]) ? $value["multi_title"] : '';
								$description = isset($value["description"]) ? $value["description"] : '';

								?>
								<li>
								    <?php if(!empty($mlti_img) || !empty($multi_title) || !empty($description)) { ?>
									<div class="icon"><img src="<?php echo esc_url_raw($mlti_img) ?>" alt="icon"></div>
									<h3><?php echo esc_html($multi_title) ?></h3>
									<p><?php echo esc_textarea($description) ?></p>
									<?php } ?>
								</li>
								<?php

							}
							?>

						</ul>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="image-holder">
					    <?php if(!empty($img)){ ?>
						<img src="<?php echo esc_url_raw($img) ?>" alt="image">
					<?php } ?>
					</div>
				</div>
			</div>
			<div class="row align-items-center mt-30 mt-md-50 mt-xl-80 mt-xxl-90">
				<?php


				$lm_team_list = vc_param_group_parse_atts($atts['second_multi']);
				if (!empty($lm_team_list)) {
					foreach ($lm_team_list as $key => $value) {

						$mlti_tit = isset($value["mlti_tit"]) ? $value["mlti_tit"] : '';
						$mlti_desc = isset($value["mlti_desc"]) ? $value["mlti_desc"] : '';
						$btn_txt = isset($value["btn_txt"]) ? $value["btn_txt"] : '';
						$btn_url = isset($value["btn_url"]) ? $value["btn_url"] : '';
						$mlti_images = isset($value["mlti_images"]) ? $value["mlti_images"] : '';

						?>

						<div class="col-12 col-lg-6">
							<div class="job-frame">
								<div class="text-box">
								    <?php if(!empty($mlti_tit) || !empty($mlti_desc) || !empty($btn_txt) || !empty($btn_url)) { ?>
									<h3><?php echo esc_html($mlti_tit) ?></h3>
									<p><?php echo esc_textarea($mlti_desc) ?></p>
									<a href="<?php echo esc_html($btn_url); ?>">
									<button class="btn btn-green"><span><?php echo esc_html($btn_txt) ?></span></button> 
									</a>
									<?php } ?>
								</div>
								<?php if(!empty($mlti_images)){ ?>
								<div class="image-holder"><img src="<?php echo esc_url_raw($mlti_images) ?>" alt="image"></div>
                               <?php } ?>				
							</div>
						</div>
						<?php
					}
				}

				?>
			</div>
		</div>
	</section>
	<?php

	return ob_get_clean();
}
add_shortcode('jobcircle_search_millions_jobs', 'jobcircle_search_millions_jobs_front');