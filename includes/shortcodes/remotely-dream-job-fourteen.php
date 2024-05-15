<?php
function jobcircle_dream_job_ccc() {
    vc_map(
        array(
            'name' => __('Hire Remotely Dream'),
            'base' => 'dream_job_ccc',
            'category' => __('job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image'),
                    'param_name' => 'mn_img',
                ),   array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Multi Image'),
                    'param_name' => 'mmm_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Play Button Image'),
                    'param_name' => 'play_button_img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Play Button Url'),
                    'param_name' => 'p_b_u',
                ),
             
               //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_sec',
                    'params' => array(
                    
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Designation'),
                            'param_name' => 'designation',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'title',
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
                            'heading' => __('Button Title'),
                            'param_name' => 'btn_title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Buttom Url'),
                            'param_name' => 'button_url_ccc',
                        ),
                       
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_dream_job_ccc');


// Frontend Coding 

function jobcircle_dream_job_ccc_front( $atts, $content ) {

   $atts = shortcode_atts(
   array(
       
    'mn_img' => '',
    'play_button_img' => '',
    'p_b_u' => '',
    'mmm_img' => '',

    'multi_sec' => '',

   ), $atts, 'jobcircle_dream_job_ccc'
);

$mn_img = isset($atts['mn_img']) ? $atts['mn_img'] : '';
$mmm_img = isset($atts['mmm_img']) ? $atts['mmm_img'] : '';
$play_button_img = isset($atts['play_button_img']) ? $atts['play_button_img'] : '';
$p_b_u = isset($atts['p_b_u']) ? $atts['p_b_u'] : '';

ob_start();
?>
<style>
    .candidate_block .jobs_post {
    background: url(<?php echo esc_html( $mmm_img )?>) no-repeat;
    background-size: cover;
    position: relative;

    padding: 30px 0;
    border-radius: 30px;
}
</style>
            <section class="section section-theme-14 featured_Jobs_Block remote_jobt">
			<div class="container">
					
            <div class="candidate_block">
                <?php if(!empty($mn_img)) { ?>
                <div class="video_holder" style="background-image: url(<?php echo esc_url_raw($mn_img) ?>);width: 100%;">
                <?php } 
                
                if(!empty($play_button_img) || !empty($p_b_u)) { ?>
                    <a class="play" href="<?php echo esc_html($p_b_u) ?>"><img src="<?php echo esc_url_raw($play_button_img) ?>" alt="icon"></a>
                <?php } ?>
                </div>
                <div class="jobs_post">
                    <div class="row posts_info">
<?php

$lm_team_list = vc_param_group_parse_atts( $atts['multi_sec'] ); 
       
foreach ( $lm_team_list as $key => $value) {

	$designation = isset($value["designation"]) ? $value["designation"] : '';
    $title = isset($value["title"]) ? $value["title"] : '';
    $description = isset($value["description"]) ? $value["description"] : '';
    $btn_title = isset($value["btn_title"]) ? $value["btn_title"] : '';
    $button_url_ccc = isset($value["button_url_ccc"]) ? $value["button_url_ccc"] : '';

?>
	<div class="col-12 col-md-6 info_hold">
        <?php if(!empty($designation)) { ?>
									<strong class="title_candidate"><?php echo esc_html($designation) ?></strong>
                                    <?php } 
                               if(!empty($title)) { ?>
									<strong class="h5"><?php echo esc_html($title) ?></strong>
                                    <?php } 
                               if(!empty($description)) { ?>
									<p><?php echo esc_textarea($description) ?></p>
                                    <?php } 
                               if(!empty($btn_title) || !empty($button_url_ccc)) { ?>
									<a class="btn btn-green btn-sm" href="<?php echo esc_html($button_url_ccc) ?>"><span class="btn-text"><?php echo esc_html($btn_title) ?></span></a>
                                    <?php } ?>
								</div>       
<?php
}
?>
                       </div>
					</div>
				</div>
				</div>

			</section>
<?php
$html =  ob_get_clean();
return $html;
}
add_shortcode( 'dream_job_ccc', 'jobcircle_dream_job_ccc_front');