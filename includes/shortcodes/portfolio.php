<?php
function jobcircle_portfolio()
{
    vc_map(

		array(
			'name' => __('Portfolio'),
			'base' => 'jobcircle_portfolio',
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
add_action('vc_before_init', 'jobcircle_portfolio');


// Frontend Coding 

function jobcircle_portfolio_front($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'main_title' => '',

			'multi_section' => '',


		),
		$atts,
		'jobcircle_portfolio'
	);

	$main_title = isset($atts['main_title']) ? $atts['main_title'] : '';

	ob_start();
	?>
						<div class="gallery-block">
						    	    <?php if (!empty($main_title)) {
                                ?>
							<h2 class="h5"><?php echo jobcircle_esc_the_html($main_title)  ?></h2>
								<?php
                                } ?>
							<div class="slideglery gallery-slider bg-light-gray">
			<?php
			$lm_team_list = vc_param_group_parse_atts($atts['multi_section']);

			foreach ($lm_team_list as $key => $value) {

				$image = isset($value["image"]) ? $value["image"] : '';
				?>
                <div class="slick-slide">
                    	    <?php if (!empty($image)) {
                                ?>
                <div class="gallery-image"><img src="<?php echo jobcircle_esc_the_html($image) ?>" width="283" height="231" alt="Portfolioy"></div>
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

add_shortcode('jobcircle_portfolio', 'jobcircle_portfolio_front');