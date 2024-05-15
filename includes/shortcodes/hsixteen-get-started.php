<?php

function jobcircle_get_started_hsixteen()
{
	vc_map(
		array(
			'name' => __('LET GET STARTED IT’S SIMPLE Hsixteen'),
			'base' => 'jobcircle_get_started_hsixteen',
			'category' => __('Job Circle'),
			'params' => array(
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
					'heading' => __('Sub Title'),
					'param_name' => 'sub_title',
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
					'heading' => __('Background Image'),
					'param_name' => 'bg_img',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Play Icon Image'),
					'param_name' => 'icn_img',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Image'),
					'param_name' => 'main_img',
				),
				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'info_multi',
					'params' => array(
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('List Text'),
							'param_name' => 'list_text',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Url'),
							'param_name' => 'lsit_ulr',
						),
					),
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Url'),
					'param_name' => 'video_ulr',
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
							'param_name' => 'titl',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'disce',
						),
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Image'),
							'param_name' => 'img',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Url'),
							'param_name' => 'url',
						),
					),
				)
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_get_started_hsixteen');
// Frontend Coding 
function jobcircle_get_started_hsixteen_front($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'title' => '',
			'sub_title' => '',
			'desc' => '',
			'bg_img' => '',
			'icn_img' => '',
			'main_img' => '',
			'video_ulr' => '',
			//For Multi 
			'info_multi' => '',
			'second_multi' => '',
		), $atts, 'jobcircle_get_started_hsixteen'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';
	$sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
	$desc = isset($atts['desc']) ? $atts['desc'] : '';
	$bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
	$icn_img = isset($atts['icn_img']) ? $atts['icn_img'] : '';
	$main_img = isset($atts['main_img']) ? $atts['main_img'] : '';
	$video_ulr = isset($atts['video_ulr']) ? $atts['video_ulr'] : '';

	ob_start();

	?>
	<?php if (!empty($bg_img)) { ?>
		<section class="section section-theme-16 get_started"
			style="background-image: url('<?php echo esc_url_raw($bg_img) ?>');">
		<?php } ?>
		<div class="container">
			<div class="row d-flex align-items-center mb-70">
				<div class="col-12 col-md-6 text-holder mb-30 mb-md-0">
					<!-- Section header -->
					<header class="section-header d-flex flex-column mb-15 mb-md-30 mb-xl-50">
						<?php if (!empty($sub_title)) { ?>
							<p>
								<?php echo esc_html($sub_title) ?>
							</p>
						<?php } ?>
						<?php if (!empty($title)) { ?>
							<h2>
								<?php echo esc_html($title) ?>
							</h2>
						<?php } ?>

						<?php if (!empty($desc)) { ?>
							<span class="text">
								<?php echo esc_textarea($desc) ?>
							</span>
						<?php } ?>
					</header>
					<ol class="steps_list">
						<?php
						$lm_team_list = vc_param_group_parse_atts($atts['info_multi']);

						foreach ($lm_team_list as $key => $value) {

							$list_text = isset($value['list_text']) ? $value['list_text'] : '';
							$lsit_ulr = isset($value['lsit_ulr']) ? $value['lsit_ulr'] : '';

							?>
							<li>
								<a href="<?php echo esc_html($lsit_ulr) ?>">
									<?php if (!empty($list_text)) {
										?>
										<strong class="h5">
											<?php echo esc_html($list_text) ?>
										</strong>
									<?php } ?>
								</a>
							</li>
							<?php
						}
						?>
					</ol>
				</div>
				<div class="col-12 col-md-6">
					<div class="image-holder">
						<?php if (!empty($video_ulr)) {
							?>
							<a href="<?php echo jobcircle_esc_the_html($video_ulr) ?>" class="play">
							<?php } ?>
							<?php if (!empty($icn_img)) { ?>
								<img src="<?php echo esc_url_raw($icn_img) ?>" alt="img">
							<?php } ?>
						</a>
						<?php if (!empty($main_img)) { ?>
							<img src="<?php echo esc_url_raw($main_img) ?>" alt="img">
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="row d-flex align-items-center">
				<?php

				$lm_team_list = vc_param_group_parse_atts($atts['second_multi']);

				if (!empty($lm_team_list)) {
					foreach ($lm_team_list as $key => $value) {

						$titl = isset($value["titl"]) ? $value["titl"] : '';
						$disce = isset($value["disce"]) ? $value["disce"] : '';
						$img = isset($value['img']) ? $value['img'] : '';
						$url = isset($value['url']) ? $value['url'] : '';

						?>
						<div class="col-12 col-lg-4 mb-30 mb-lg-30">
							<a href="<?php echo jobcircle_esc_the_html($url) ?>" class="link">
								<div class="icon-holder">
									<?php if (!empty($img)) { ?>
										<img src="<?php echo esc_url_raw($img) ?>" alt="img">
									<?php } ?>
								</div>
								<div class="txt-holder">
									<?php if (!empty($titl)) { ?>
										<strong class="h5">
											<?php echo esc_html($titl) ?>
										</strong>
									<?php } ?>
									<?php if (!empty($disce)) { ?>
										<p>
											<?php echo esc_textarea($disce) ?>
										</p>
									<?php } ?>
								</div>
							</a>
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
add_shortcode('jobcircle_get_started_hsixteen', 'jobcircle_get_started_hsixteen_front');