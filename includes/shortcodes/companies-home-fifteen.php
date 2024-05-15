<?php
function companies_logo()
{
	vc_map(
		array(
			'name' => __('Companies H-15'),
			'base' => 'companies_logo',
			'category' => __('job Circle'),
			'params' => array(
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'companies_logo_multi',
					'params' => array(
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('image'),
							'param_name' => 'img',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Url'),
							'param_name' => 'url',
						),
					)
				)
			),
		)
	);
}
add_action('vc_before_init', 'companies_logo');
//welcome Massage frontend
function companies_logo_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'companies_logo_multi' => '',
		),
		$atts,
		'companies_logo'
	);
	ob_start()
?>
	<section class="section section-theme-15 brands-block bg-white pt-30 pt-md-30 pt-lg-60 pt-xl-80 pb-35 pb-md-50 pb-lg-80 pb-xl-90">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<ul class="brands-list">
						<?php
						$lm_team_list = vc_param_group_parse_atts($atts['companies_logo_multi']);
						if (!empty($lm_team_list)) {
							foreach ($lm_team_list as $key => $value) {
								$img = isset($value['img']) ? $value['img'] : '';
								$url = isset($value['url']) ? $value['url'] : '';
						?>
								<?php
								if (!empty($url) || !empty($img)) {
								?>
									<li><a href="<?php echo esc_html($url) ?>"><img src="<?php echo esc_url_raw($img) ?>" alt="logo"></a></li>
								<?php
								}
								?>
							<?php
							}
							?>
					</ul>
				</div>
			</div>
		</div>
	</section>
<?php
							return ob_get_clean();
						}
					}
					add_shortcode('companies_logo', 'companies_logo_frontend');
