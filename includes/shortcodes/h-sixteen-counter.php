<?php
function jobcircle_counter_h16()
{
	vc_map(
		array(
			'name' => __('Counter H16'),
			'base' => 'jobcircle_counter_h16',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Bg Image'),
					'param_name' => 'bg_image',
				),
				//GROUP 1
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'multi_portion',
					'params' => array(
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Number'),
							'param_name' => 'number',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Counter Category'),
							'param_name' => 'counter_category',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Counter Heading'),
							'param_name' => 'counter_heading',
						),
					),
				)
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_counter_h16');
// Frontend Coding 

function jobcircle_counter_h16_front($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'bg_image' => '',
			'multi_portion' => '',

		),
		$atts,
		'jobcircle_counter_h16'
	);

	$bg_image = isset($atts["bg_image"]) ? $atts["bg_image"] : '';

	ob_start();
	?>
	<section class="section section-theme-16 info_area theme_seven_sec remote_jobt">
		<div class="container">
			<?php if (!empty($bg_image)) {
				?>
				<div class="counter_holder" style="background: url(<?php echo jobcircle_esc_the_html($bg_image) ?>) no-repeat;">
				<?php }
			?>
				<div class="wrap_counters">
					<?php
					$lm_team_list = vc_param_group_parse_atts($atts['multi_portion']);

					foreach ($lm_team_list as $key => $value) {

						$number = isset($value["number"]) ? $value["number"] : '';
						$counter_category = isset($value["counter_category"]) ? $value["counter_category"] : '';
						$counter_heading = isset($value["counter_heading"]) ? $value["counter_heading"] : '';

						?>
						<div class="counter-box">
							<div class="counter-stats">
								<strong class="numbers h2">
									<span data-purecounter-duration="1" data-purecounter-start="0"
										data-purecounter-end="<?php echo esc_html($number) ?>" data-purecounter-once="true"
										class="purecounter"><?php echo esc_html($number) ?></span><?php if(!empty($counter_category)) {?><?php echo esc_html($counter_category) ?><?php } ?>
								</strong><?php if(!empty($counter_heading)){?><span class="subtext"><?php echo esc_html($counter_heading) ?></span>
								<?php }
								?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php

	return ob_get_clean();
}
add_shortcode('jobcircle_counter_h16', 'jobcircle_counter_h16_front');