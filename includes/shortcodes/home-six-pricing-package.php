<?php
function jobcircle_pricing_package()
{
    vc_map(
        array(
            'name' => __('JC Pricing Package'),
            'base' => 'jc_pricing_package',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'img',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'mlti_price',
                    'params' => array(
                        //parameters for first multi group
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Package'),
                            'param_name' => 'pkg',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Package Price'),
                            'param_name' => 'pkg_price',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Recommended Package'),
                            'param_name' => 'recmnded_pkg',
                        ),
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Icon Image'),
                            'param_name' => 'icon_img',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Job Posting'),
                            'param_name' => 'job_posting',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Featured Job'),
                            'param_name' => 'featured_job',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Job Displayed'),
                            'param_name' => 'job_displayed',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Premium Support'),
                            'param_name' => 'premium_support',
                        ),
                       array(
                              'type' => 'textfield',
                              'holder' => 'div',
                              'class' => '',
                              'heading' => __('Product ID'),
                              'param_name' => 'product_id',
                            ),
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_pricing_package');
// Frontend Coding 

function jobcircle_pricing_package_front($atts, $content)
{

    $atts = shortcode_atts(
        array(
            //single parameters
            'img' => '',
            'heading' => '',
            'disc' => '',
            //multi group parameter group name
            'mlti_price' => '',
        ),
        $atts,
        'jobcircle_pricing_package'
    );

    $img = isset($atts['img']) ? $atts['img'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';

    ob_start();
    ?>
    <!-- HTML for first single shortcode -->
    <?php if (!empty($img)) {
        ?>
        <section
            class="section section-theme-3 packages-block bg-gray-darker pt-35 pt-md-50 pt-lg-65 pt-xl-85 pt-xxl-110 pb-35 pb-md-50 pb-lg-65 pb-xl-85 pb-xxl-110"
            style="background-image: url('<?php echo esc_url_raw($img); ?>');">
            <?php
    }
    ?>
        <div class="container">
            <!-- Section header -->
            <header class="section-header text-white text-center mb-30 mb-md-45 mb-xl-60">
                <?php if (!empty($heading)) {
                    ?>
                    <h2>
                        <?php echo esc_html($heading); ?>
                    </h2>
                    <?php
                }
                ?>
                <?php if (!empty($disc)) {
                    ?>
                    <p>
                        <?php echo esc_textarea($disc); ?>
                    </p>
                    <?php
                }
                ?>
            </header>
            <div class="row justify-content-center">
                <?php
                $lm_team_list = vc_param_group_parse_atts($atts['mlti_price']);
                $counter = 1;
                foreach ($lm_team_list as $key => $value) {

                    $pkg = isset($value["pkg"]) ? $value["pkg"] : '';
                    $pkg_price = isset($value["pkg_price"]) ? $value["pkg_price"] : '';
                    $recmnded_pkg = isset($value["recmnded_pkg"]) ? $value["recmnded_pkg"] : '';
                    $icon_img = isset($value["icon_img"]) ? $value["icon_img"] : '';
                    $job_posting = isset($value["job_posting"]) ? $value["job_posting"] : '';
                    $featured_job = isset($value["featured_job"]) ? $value["featured_job"] : '';
                    $job_displayed = isset($value["job_displayed"]) ? $value["job_displayed"] : '';
                    $premium_support = isset($value["premium_support"]) ? $value["premium_support"] : '';
                    $product_id = isset($value["product_id"]) ? $value["product_id"] : '';
if($counter==1){
$width='38';    
$hieght='34';
}else{
$width='55';    
$hieght='49';
}
                    ?>
                    <!-- HTML for first multi shortcode -->
                    <div class="col-12 col-md-6 col-lg-4 mb-15 mb-md-30">
                        <div class="package-box <?php echo ($counter == 2 ? 'bg-brown' : '') ?>">
                            <div class="box-head ">
                                <?php if (!empty($pkg)) {
                                    ?>
                                    <strong class="subtitle">
                                        <?php echo esc_html($pkg); ?>
                                    </strong>
                                <?php } ?>
                                <?php if (!empty($pkg_price)) {
                                    ?>
                                    <h3>
                                        <?php echo esc_html($pkg_price); ?>
                                    </h3>
                                <?php } ?>
                                <?php if (!empty($recmnded_pkg)) {
                                    ?>
                                    <strong class="recommended-tag">
                                        <?php echo esc_html($recmnded_pkg); ?>
                                    </strong>
                                <?php } ?>
                            </div>
                            <div class="box-inner">
                                <div class="icon">
                                    <?php if (!empty($icon_img)) {
                                        ?>
                                        <img src="<?php echo esc_url_raw($icon_img); ?>" width="<?php echo jobcircle_esc_the_html($width) ?>" height="<?php echo jobcircle_esc_the_html($hieght) ?>"
                                            alt="Image Description">
                                    <?php } ?>
                                </div>
                                <ul class="list-unstyled features-list">
                                    <?php if (!empty($job_posting)) {
                                        ?>
                                        <li>
                                            <?php echo esc_html($job_posting); ?>
                                        </li>
                                    <?php } ?>

                                    <?php if (!empty($featured_job)) {
                                        ?>
                                        <li>
                                            <?php echo esc_html($featured_job); ?>
                                        </li>
                                    <?php } ?>

                                    <?php if (!empty($job_displayed)) {
                                        ?>
                                        <li>
                                            <?php echo esc_html($job_displayed); ?>
                                        </li>
                                    <?php } ?>
                                    <?php if (!empty($premium_support)) {
                                        ?>
                                        <li>
                                            <?php echo esc_html($premium_support); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                                    <div class="pricing_wrap">
                                    <a class="btn <?php echo ($counter == 2 ? 'btn-brown' : 'btn-white') ?> btn-sm jobcircle-user-pkg-buybtn" data-id="<?php echo $product_id; ?>"><span
                                            class="btn-text">
                                            <?php esc_html_e('Select plan'); ?>
                                        </span></a>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $counter++;
                }
                ?>
                <!--Closing  HTML for multi shortcode -->
            </div>
        </div>
    </section>

    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_pricing_package', 'jobcircle_pricing_package_front');