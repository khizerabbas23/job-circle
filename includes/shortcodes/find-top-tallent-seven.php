<?php
function jobcircle_find_top_talents()
{
	vc_map(
		array(
			'name' => __('Find Top Talents'),
			'base' => 'find_top_talents',
			'category' => __('job Circle'),
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
					'heading' => __('Description'),
					'param_name' => 'descriptionnn',
				),
				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'frst_multi',
					'params' => array(
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Question'),
							'param_name' => 'questions',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Answers'),
							'param_name' => 'answers',
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
							'heading' => __('Heading'),
							'param_name' => 'headung',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'descruption',
						),

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
							'heading' => __('Button'),
							'param_name' => 'btn',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Button Url'),
							'param_name' => 'btn_url',
						),
					),
				)
			)


		)
	);
}
add_action('vc_before_init', 'jobcircle_find_top_talents');

// Frontend Coding 

function jobcircle_find_top_talents_front($atts, $content)
{

	$atts = shortcode_atts(
		array(
			'title' => '',
			'descriptionnn' => '',

			'frst_multi' => '',
			'second_multi' => '',
		),
		$atts,
		'jobcircle_find_top_talents'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';
	$descriptionnn = isset($atts['descriptionnn']) ? $atts['descriptionnn'] : '';

	ob_start();

	?>
	<section class="top_companies_block section-theme-7 theme_sevenb">
		<div class="container">
			<header class="section-header">
				<?php
				if (!empty($descriptionnn)) { ?>
					<p>
						<?php echo esc_html($descriptionnn) ?>
					</p>
				<?php
				} ?>
				<?php
				if (!empty($title)) { ?>
					<h2>
						<?php echo esc_html($title) ?>
					</h2>
				<?php } ?>
			</header>
			<div class="top_talent_holder">
				<div class="left_align">
					<div class="accordion_holder" id="accordionExample">
						<ul class="accordion_list">
							<?php
							$lm_team_list = vc_param_group_parse_atts($atts['frst_multi']);
							$counter = 1;
							foreach ($lm_team_list as $key => $value) {

								if($counter == $counter ){
									$countercls = $counter;
									$showcls = '';		
									$collepse='collapsed';
									if($counter == 3){
									$showcls = 'show';
									$collepse='';
									}																		
								}
								
								$questions = isset($value["questions"]) ? $value["questions"] : '';
								$answers = isset($value["answers"]) ? $value["answers"] : '';					

								?>
	<li id="heading<?php echo jobcircle_esc_the_html($countercls); ?>">
	<?php if(!empty($questions)){ ?>
			<button type="button" class="<?php echo jobcircle_esc_the_html($collepse) ?>" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo jobcircle_esc_the_html($countercls); ?>" aria-expanded="true" aria-controls="collapse<?php echo jobcircle_esc_the_html($countercls); ?>">
					<i class="icon"></i>
				<strong class="title"><?php echo esc_html($questions);?></strong>
			</button>
			<?php } 
			if(!empty($answers)){ ?>
			<div id="collapse<?php echo jobcircle_esc_the_html($countercls); ?>" class="accordion-collapse collapse <?php echo jobcircle_esc_the_html($showcls); ?>" aria-labelledby="heading<?php echo jobcircle_esc_the_html($countercls); ?>" data-bs-parent="#accordionExample">
				<div class="acc-slide">
					<p><?php echo esc_html($answers);?></p>
				</div>
			</div>
			<?php } ?>
		</li>
								<?php
								$counter++;
							}
							?>
						</ul>
					</div>
				</div>
				<div class="right_align">
					<?php
					$lm_team_list = vc_param_group_parse_atts($atts['second_multi']);
					$counter = 1 ;
					if (!empty($lm_team_list)) {
						foreach ($lm_team_list as $key => $value) {
if($counter == 1){
	$employers = 'employers';
}
else{
	$employers = 'candidate';
}
							$headung = isset($value["headung"]) ? $value["headung"] : '';
							$descruption = isset($value["descruption"]) ? $value["descruption"] : '';
							$mlti_img = isset($value["mlti_img"]) ? $value["mlti_img"] : '';

							$btn = isset($value["btn"]) ? $value["btn"] : '';
							$btn_url = isset($value["btn_url"]) ? $value["btn_url"] : '';
							

							?>
							<div class="detail_box <?php echo jobcircle_esc_the_html($employers) ?>">
								<div class="text_wrap">
									<?php if (!empty($headung)) { ?>
										<strong class="h4">
											<?php echo esc_html($headung) ?>
										</strong>
									<?php } ?>
									<?php
									if (!empty($descruption)) { ?>
										<p>
											<?php echo esc_html($descruption) ?>
										</p>
									<?php } ?>
									<button class="btn btn-green btn-sm btnpend" type="submit">
										<?php
										if (!empty($btn || $btn_url)) { ?>
											<a href="<?php echo esc_html($btn_url); ?>"> <span class="btn-text">
													<?php echo esc_html($btn) ?>
												</span>
											</a>
										<?php } ?>
									</button>
								</div>
								<div class="img_wrap">
									<?php
									if (!empty($mlti_img)) { ?>
										<img src="<?php echo esc_url_raw($mlti_img) ?>" alt="img">
									<?php } ?>
								</div>
							</div>
							<?php
					$counter++;

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
add_shortcode('find_top_talents', 'jobcircle_find_top_talents_front');