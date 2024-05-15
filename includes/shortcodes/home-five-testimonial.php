<?php
function jobcircle_testimonial_f()
{
	vc_map(
		array(
			'name' => __('Home Five Testimonial'),
			'base' => 'jc_testimonial_f',
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
					'heading' => __('Heading'),
					'param_name' => 'head',
				),
				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'profile',
					'params' => array(
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Upload Image'),
							'param_name' => 'upld_img',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'titl',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Designation'),
							'param_name' => 'desg',
						),
					),
				),
				//GROUP 2
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'info',
					'params' => array(
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'titlee',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'desc',
						),
					),
				)
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_testimonial_f');

// Frontend Coding 

function jobcircle_testimonial_f_front($atts, $content)
{
	$atts = shortcode_atts(
		array(

			'title' => '',
			'head' => '',
			//For Multi
			'profile' => '',
			'info' => '',

		), $atts, 'jobcircle_testimonial_f'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';
	$head = isset($atts['head']) ? $atts['head'] : '';
	$custom_plan_price = isset($atts['nb_Circletitle']) && !empty($atts['nb_Circletitle']) ? $atts['nb_Circletitle'] : '';
	
	ob_start();
	?>
	<section class="section section-theme-5 testimonials-block pt-0 pt-lg-20 pt-xxl-70">
		<div class="container">
			<!-- Section header -->
			<header class="section-header d-flex flex-column text-center mb-0 mb-md-20">
				<?php
				if (!empty($title)) { ?>
					<h2 class="order-2">
						<?php echo esc_html($title); ?>
					</h2>
				<?php } ?>
				<?php
				if (!empty($head)) { ?>
					<p class="order-1 home-5">
						<?php echo esc_html($head); ?>
					</p>
				<?php } ?>
				<div class="col-4 col-md-6 d-none d-md-flex align-items-end justify-content-end">
					<button type="button" class="slick-prev slick-arrow">
						<i class="jobcircle-icon-chevron-left"></i>
					</button>
					<button type="button" class="slick-next slick-arrow">
						<i class="jobcircle-icon-chevron-right"></i>
					</button>
				</div>
			</header>
			<div class="testimonials-carousel">
				<div class="carousel-nav mb-10 mb-md-30 mb-lg-50">
					<?php
					$lm_team_list = vc_param_group_parse_atts($atts['profile']);
					foreach ($lm_team_list as $key => $value) {

						$upld_img = isset($value['upld_img']) ? $value['upld_img'] : '';
						$titl = isset($value['titl']) ? $value['titl'] : '';
						$desg = isset($value['desg']) ? $value['desg'] : '';

						?>
						<div class="tumbnail-box">
							<div class="image">
								<?php
								if (!empty($upld_img)) { ?>
									<img src="<?php echo esc_url_raw($upld_img) ?>" alt="img">
								<?php } ?>
							</div>
							<div class="text-info">
								<?php
								if (!empty($titl)) { ?>
									<strong class="title-text">
										<?php echo esc_html($titl) ?>
									</strong>
								<?php } ?>
								<?php
								if (!empty($desg)) { ?>
									<span class="designation">
										<?php echo esc_html($desg) ?>
									</span>
								<?php } ?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="quotes-main">
					<?php
					$lm_team_list = vc_param_group_parse_atts($atts['info']);
					if (!empty($lm_team_list)) {
						foreach ($lm_team_list as $key => $value) {

							$titlee = isset($value["titlee"]) ? $value["titlee"] : '';
							$desc = isset($value['desc']) ? $value['desc'] : '';
							?>
							<div class="quote-box">
								<blockquote>
									<?php
									if (!empty($titlee)) { ?>
										<strong class="quote-title">
											<?php echo esc_html($titlee) ?>
										</strong>
									<?php } ?>
									<div class="ratings-box">
										<ul class="star-ratings">
											<li><i class="jobcircle-icon-star filled"></i></li>
											<li><i class="jobcircle-icon-star filled"></i></li>
											<li><i class="jobcircle-icon-star filled"></i></li>
											<li><i class="jobcircle-icon-star filled"></i></li>
											<li><i class="jobcircle-icon-star filled"></i></li>
										</ul>
									</div>
									<?php
									if (!empty($desc)) { ?>
										<p>
											<?php echo esc_textarea($desc) ?>
										</p>
									<?php } ?>
								</blockquote>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode('jc_testimonial_f', 'jobcircle_testimonial_f_front');