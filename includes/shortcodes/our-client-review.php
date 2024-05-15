<?php
function jobcircle_our_client_reviews() {
    vc_map(
        array(
            'name' => __('Our Clients Reviews'),
            'base' => 'our_client_reviews',
            'category' => __('Job Circle'),
            'params' => array(
           
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
                    'heading' => __('Tag Line'),
                    'param_name' => 'tg_lline',
                ),
               //Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'recent_multi_our_client_reviews',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'image',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Author Name'),
                            'param_name' => 'author_name',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Author Designation'),
                            'param_name' => 'author_designation',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'desc',
                        ),
                       
                    ),
                ),
                  //Group
                  array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'recent_multi_clients_counter',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image'),
                            'param_name' => 'imagess',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Heading'),
                            'param_name' => 'headss',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Tag Line'),
                            'param_name' => 'tg_liness',
                        ),
                    
                       
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_our_client_reviews');


// Frontend Coding 

function jobcircle_our_client_reviews_front( $atts, $content ) {

   $atts = shortcode_atts(
   array(
       
    'titl' => '',
    'tg_lline' => '',
        
    'recent_multi_our_client_reviews' => '',
    'recent_multi_clients_counter' => '',

   ), $atts, 'jobcircle_our_client_reviews'
);

$titl = isset($atts['titl']) ? $atts['titl'] : '';
$tg_lline = isset($atts['tg_lline']) ? $atts['tg_lline'] : '';
 
ob_start();
?>

<section class="section section-theme-4 client-reviews-sec bg-white pt-30 pt-md-50 pt-xl-80 pt-xxl-100 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
				<div class="container">
        <div class="counter-bar">
        <?php

$lm_teamdfdgd_list = vc_param_group_parse_atts( $atts['recent_multi_clients_counter'] ); 
       
foreach ( $lm_teamdfdgd_list as $key => $value) {

	$imagess = isset($value["imagess"]) ? $value["imagess"] : '';
	$headss = isset($value["headss"]) ? $value["headss"] : '';

    $tg_liness = isset($value["tg_liness"]) ? $value["tg_liness"] : '';
    

?> 
						<div class="counter">
                                     <?php 
                                        if(!empty($imagess)){ ?>
							<div class="icon"><img src="<?php echo  esc_url_raw($imagess) ?>" alt="icon"></div>
                            <?php } ?>
                            <?php 
                                        if(!empty($headss) && !empty($tg_liness)){ ?>
							<p class="value"><strong><?php echo  esc_html($headss) ?></strong> <?php echo  esc_html($tg_liness) ?></p>
                            <?php } ?>
						</div>
                        <?php
                        }
                        ?>
					</div>

					<!-- Section header -->
					<header class="section-header d-flex flex-column mb-20 mb-md-45 mb-xl-60">
						<div class="row">
							<div class="col-12 col-md-8 d-flex flex-column">
                                       <?php 
                                        if(!empty($tg_lline)){ ?>
                            <strong class="sub-heading"><?php echo esc_html($tg_lline)  ?></strong>
                            <?php } ?>
                                         <?php 
                                        if(!empty($titl)){ ?>
								<h2><?php echo esc_html($titl)  ?></h2>
                                <?php } ?>
							</div>
							<div class="col-4 col-md-4 d-none d-md-flex align-items-end justify-content-end">
								<button type="button" class="slick-prev slick-arrow">
									<i class="jobcircle-icon-chevron-left"></i>
								</button>
								<button type="button" class="slick-next slick-arrow">
									<i class="jobcircle-icon-chevron-right"></i>
								</button>
							</div>
						</div>
					</header>
					
					<div class="client-reviews-carousel">
<?php

$lm_team_list = vc_param_group_parse_atts( $atts['recent_multi_our_client_reviews'] ); 
       
foreach ( $lm_team_list as $key => $value) {

	$image = isset($value["image"]) ? $value["image"] : '';
	$author_name = isset($value["author_name"]) ? $value["author_name"] : '';
    $desc = isset($value["desc"]) ? $value["desc"] : '';
    $author_designation = isset($value["author_designation"]) ? $value["author_designation"] : '';
    

?> 
                
                <div class="review-box">
                <blockquote><?php 
                                        if(!empty($desc)){ ?>
								<p><?php echo  esc_textarea($desc) ?></p>
                                <?php } ?>
								<cite class="d-flex">
                                <?php 
                                        if(!empty($image)){ ?>
									<img src="<?php echo  esc_url_raw($image) ?>" alt="icon">
                                    <?php } ?>
									<span class="info-row">
                                    <?php 
                                        if(!empty($author_name)){ ?>
										<strong class="title"><?php echo  esc_html($author_name) ?></strong>
                                        <?php } ?>
                                        <?php 
                                        if(!empty($author_designation)){ ?>
										<span><?php echo esc_html($author_designation) ?></span>
                                        <?php } ?>
									</span>
								</cite>
							</blockquote>
						</div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                    </div>
			</section>

<?php
$html =  ob_get_clean();
return $html;
}
add_shortcode( 'our_client_reviews', 'jobcircle_our_client_reviews_front');