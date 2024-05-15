<?php
function jobcircle_hfifteen_client_saying()
{
	vc_map(
		array(
			'name' => __('Client Saying home 15'),
			'base' => 'jobcircle_hfifteen_client_saying',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('background Image'),
					'param_name' => 'bg_image',
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
					'heading' => __('Discription'),
					'param_name' => 'discription',
				),
				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'jobcircle_hfifteen_client_saying_multi',
					'params' => array(
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Logo image'),
							'param_name' => 'logo_image',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Paragraph'),
							'param_name' => 'para',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Client Name'),
							'param_name' => 'head',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Designation'),
							'param_name' => 'head_span',
						),
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Star Image'),
							'param_name' => 'star_img',
						),
					)
				)
			),
		)
	);
}
add_action('vc_before_init', 'jobcircle_hfifteen_client_saying');
//welcome Massage frontend
function jobcircle_hfifteen_client_saying_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'bg_image' => '',
			'title' => '',
			'discription' => '',
			'jobcircle_hfifteen_client_saying_multi' => '',
		),
		$atts,
		'jobcircle_hfifteen_client_saying'
	);
	$bg_image  = isset($atts['bg_image']) ? $atts['bg_image'] : '';
	$title  = isset($atts['title']) ? $atts['title'] : '';
	$discription  = isset($atts['discription']) ? $atts['discription'] : '';
	$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
	ob_start();
?>
	<?php
	if (!empty($bg_image)) {
	?>
		<section class="section section-theme-15 clients-testimonials-block pt-35 pt-md-50 pt-xl-90 pb-30 pb-md-50 pb-lg-80 pb-xxl-92" style="background-image: url(<?php echo esc_url_raw($bg_image) ?>);">
		<?php
	}
		?>
		<div class="container">
			<!-- Section header -->
			<header class="section-header d-flex flex-column-reverse text-center mb-20 mb-lg-30 mb-xl-45">
				<?php
				if (!empty($title) || !empty($discription)) {
				?>
					<h2> <?php echo esc_html($title) ?></h2>
					<p> <?php echo esc_html($discription) ?></p>
				<?php
				}
				?>
			</header>
			<div class="clients-testimonials-slider">
				<?php
				$lm_team_list = vc_param_group_parse_atts($atts['jobcircle_hfifteen_client_saying_multi']);
				if (!empty($lm_team_list))
					foreach ($lm_team_list as $key => $value) {
						$logo_image  = isset($value["logo_image"]) ? $value["logo_image"] : '';
						$para  = isset($value["para"]) ? $value["para"] : '';
						$head  = isset($value["head"]) ? $value["head"] : '';
						$head_span  = isset($value["head_span"]) ? $value["head_span"] : '';
						$star_img  = isset($value["star_img"]) ? $value["star_img"] : '';
				?>
					<div class="slide">
						<blockquote>
							<?php
							if (!empty($logo_image) || !empty($para)) {
							?>
								<img src="<?php echo esc_url_raw($logo_image) ?>" alt="logo" class="logo">
								<q> <?php echo esc_textarea($para) ?></q>
							<?php
							}
							?>
							<cite>
								<?php
								if (!empty($head) || !empty($head_span) || !empty($star_img)) {
								?>
									<strong class="title"> <?php echo esc_html($head) ?><span> <?php echo esc_html($head_span) ?></span></strong>
									<img src="<?php echo esc_url_raw($star_img) ?>" alt="stars">
								<?php
								}
								?>
							</cite>
						</blockquote>
					</div>
				<?php
					}
				?>
			</div>
		</div>
		</section>
	<?php
	return ob_get_clean();
}
add_shortcode('jobcircle_hfifteen_client_saying', 'jobcircle_hfifteen_client_saying_frontend');
