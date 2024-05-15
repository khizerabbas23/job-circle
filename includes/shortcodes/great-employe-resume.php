<?php
function jobcircle_great_employers()
{
    vc_map(
        array(
            'name' => __('Great Employers'),
            'base' => 'jc_great_employers',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload image'),
                    'param_name' => 'upld_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'head',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_great_employers');
function jobcircle_great_employers_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'upld_img' => '',
            'head' => '',
            'desc' => '',
        ),
        $atts,
        'jobcircle_great_employers'
    );

    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';
    $head = isset($atts['head']) ? $atts['head'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    ob_start()
?>
<div class="container">
				<div class="row mb-50 mb-md-90 mb-xl-120">
					<div class="col-12 pt-35 pt-md-50 pt-lg-75 pt-xxl-120">
						<div class="matched-jobs-block section-theme-5">
							<div class="section-header text-white">
                                <?php
                                if(!empty($head)){ ?>
								<h2><?php echo esc_html($head); ?></h2>
								<?php }?>
                                <?php
                                if(!empty($desc)){ ?>
								<p><?php echo esc_textarea($desc)?></p>
								<?php }?>
								<a href="https://modern.miraclesoftsolutions.com/dashboard/?account_tab=my-resume" class="btn btn-green btn-sm"><span class="btn-text"><i class="jobcircle-icon-upload-cloud"></i><?php esc_html_e('Upload Your Resume', 'jobcircle-frame') ?></span></a>
							</div>
							<div class="image-holder">
                            <?php
                                if(!empty($upld_img)){ ?>
								<img src="<?php echo esc_url_raw($upld_img);?>" alt="Image Description">
								<?php }
                            ?>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
$html = ob_get_clean();
return $html;
}
add_shortcode('jc_great_employers', 'jobcircle_great_employers_frontend');