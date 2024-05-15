<?php
function jobcircle_our_office_gallery()
{

	vc_map(

		array(
			'name' => __('Our Office Gallery'),
			'base' => 'jobcircle_our_office_gallery',
			'category' => __('Job Circle'),
			'params' => array(


				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title'),
					'param_name' => 'main_title',
				),

				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'multi_section',
					'params' => array(


						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Image'),
							'param_name' => 'image',
						),
					),
				),

			)


		)
	);
}
add_action('vc_before_init', 'jobcircle_our_office_gallery');


// Frontend Coding 

function jobcircle_our_office_gallery_front($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'main_title' => '',

			'multi_section' => '',


		),
		$atts,
		'jobcircle_our_office_gallery'
	);

	$main_title = isset($atts['main_title']) ? $atts['main_title'] : '';

	ob_start();
	?>
	<div class="gallery-block">
		<?php if (!empty($main_title)) {
			?>
			<h2 class="h3">
				<?php echo esc_html($main_title) ?>
			</h2>
		<?php
		} ?>
		<div class="gallery-slider bg-light-gray">
			<?php
			$lm_team_list = vc_param_group_parse_atts($atts['multi_section']);

			foreach ($lm_team_list as $key => $value) {

				$image = isset($value["image"]) ? $value["image"] : '';
				?>
				<div class="slick-slide">
					<?php if (!empty($image)) {
						?>
						<div class="gallery-image"><img src="<?php echo esc_url_raw($image) ?>" width="283" height="231"
								alt="Our office Gallery"></div>
					<?php
					} ?>
				</div>
				<?php
			} ?>

		</div>
	</div>
		
	<?php

	$html = ob_get_clean();
	return $html;
}

add_shortcode('jobcircle_our_office_gallery', 'jobcircle_our_office_gallery_front');