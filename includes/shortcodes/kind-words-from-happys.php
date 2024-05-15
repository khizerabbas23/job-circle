<?php
function kind_words_happys()
{
	vc_map(

		array(
			'name' => __('Kind Words From Happy'),
			'base' => 'kind_words_happys',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Image'),
					'param_name' => 'image',
				),
				array(
					'type' => 'textarea',
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
							'heading' => __('Icon Image'),
							'param_name' => 'icn_img',
						),
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Image'),
							'param_name' => 'mlti_img',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'description',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Name'),
							'param_name' => 'name',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Tag Line'),
							'param_name' => 'tg_line',
						),
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Rating Image'),
							'param_name' => 'rtg_img',
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
							'heading' => __('Url'),
							'param_name' => 'mlti_url',
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
add_action('vc_before_init', 'kind_words_happys');
// Frontend Coding 
function kind_words_happys_front($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'image' => '',
			'sub_title' => '',
			'title' => '',
			'frst_multi' => '',
			'second_multi' => '',
		),
		$atts,
		'kind_words_happys'
	);
	$image = isset($atts['image']) ? $atts['image'] : '';
	$sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';

	ob_start();
	?>
	<section class="section section-theme-13 happy-workers-block bg-white pt-0 pb-40 pb-md-50 pb-lg-80 pb-xl-100">
		<div class="container">
			<div class="row">
				<div class="col-12 d-none d-lg-block col-md-5">
					<?php if (!empty($image)) {
						?>
						<div class="image-holder"><img src="<?php echo esc_url_raw($image) ?>" alt="image"></div>
						<?php
					} ?>
				</div>
				<div class="col-12 col-lg-7">
					<div class="text-box">
						<?php if (!empty($sub_title)) {
							?>
							<p class="m-0">
								<?php echo esc_textarea($sub_title) ?>
							</p>
							<?php
						} ?>
						<?php if (!empty($title)) {
							?>
							<h2>
								<?php echo esc_html($title) ?>
							</h2>
							<?php
						} ?>
					</div>
					<div class="quotes-carousel">
						<?php
						$lm_team_list = vc_param_group_parse_atts($atts['frst_multi']);
						foreach ($lm_team_list as $key => $value) {
							$icn_img = isset($value["icn_img"]) ? $value["icn_img"] : '';
							$mlti_img = isset($value["mlti_img"]) ? $value["mlti_img"] : '';
							$description = isset($value["description"]) ? $value["description"] : '';
							$name = isset($value["name"]) ? $value["name"] : '';
							$tg_line = isset($value["tg_line"]) ? $value["tg_line"] : '';
							$rtg_img = isset($value["rtg_img"]) ? $value["rtg_img"] : '';
							?>
							<div class="slide-box">
								<div class="inner-slide">
									<div class="image-box">
										<div class="image-frame">
											<?php if (!empty($icn_img)) {
												?>
												<img class="quote-icon" src="<?php echo esc_url_raw($icn_img) ?>" alt="quote">
												<?php
											} ?>
											<?php if (!empty($mlti_img)) {
												?>
												<img src="<?php echo esc_url_raw($mlti_img) ?>" alt="image">
												<?php
											} ?>
										</div>
									</div>
									<div class="quote-box">
										<blockquote>
											<?php if (!empty($description)) {
												?>
												<p>
													<?php echo esc_textarea($description) ?>
												</p>
												<?php
											} ?>
											<cite>
												<strong class="title">
													<?php if (!empty($name)) {
														?>
														<?php echo esc_html($name) ?>
														<?php
													} ?>
												</strong>
												<span class="author">
													<span class="author-text">
														<?php if (!empty($tg_line)) {
															?>
															<?php echo esc_html($tg_line) ?>
															<?php
														} ?>
													</span>
													<?php if (!empty($rtg_img)) {
														?>
														<img src="<?php echo esc_url_raw($rtg_img) ?>" alt="stars">
														<?php
													} ?>
												</span>
											</cite>
										</blockquote>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<ul class="logos_list mt-40 mt-md-80 mt-lg-90 mt-xl-100 mt-xxl-120">
				<?php

				$lm_team_list = vc_param_group_parse_atts($atts['second_multi']);
				if (!empty($lm_team_list)) {
					foreach ($lm_team_list as $key => $value) {
						$mlti_url = isset($value["mlti_url"]) ? $value["mlti_url"] : '';
						$mlti_images = isset($value["mlti_images"]) ? $value["mlti_images"] : '';
						?>
						<li>
							<div class="logo-holder">
								<?php if (!empty($mlti_url) && !empty($mlti_images)) {
									?>
									<a href="<?php echo esc_html($mlti_url) ?>"><img src="<?php echo esc_url_raw($mlti_images) ?>"
											alt="img"></a>
									<?php
								} ?>
							</div>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode('kind_words_happys', 'kind_words_happys_front');