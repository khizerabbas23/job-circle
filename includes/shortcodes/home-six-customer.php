<?php
function jobcircle_customer()
{
    vc_map(
        array(
            'name' => __('JC Customers'),
            'base' => 'jc_customer',
            'category' => __('Job Circle'),
            'params' => array(

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
                    'param_name' => 'mlti_customers',
                    'params' => array(

                        //parameters for first multi group
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image Client'),
                            'param_name' => 'client_img',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Client Description'),
                            'param_name' => 'client_desc',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Client Name'),
                            'param_name' => 'client_name',
                        ),
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Image Client '),
                            'param_name' => 'client_imgg',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Client Description '),
                            'param_name' => 'client_descc',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Client Name'),
                            'param_name' => 'client_namee',
                        ),
                    ),
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_customer');


// Frontend Coding 

function jobcircle_customer_front($atts, $content)
{

    $atts = shortcode_atts(
        array(
            //single parameters
            'heading' => '',
            'disc' => '',
            //multi group parameter group name
            'mlti_customers' => '',

        ), $atts, 'jobcircle_customer'
    );
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';

    ob_start();
    ?>
    <section
        class="section section-theme-3 customers-reviews-block bg-light-gray pt-45 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-135  pb-35 pb-md-50 pb-lg-65 pb-xl-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-5 mb-15 mb-md-30 mb-lg-0">
                    <!-- Section header -->
                    <header class="section-header text-center text-lg-start ms-0 me-0 mb-40 mb-md-45">
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
                                <?php echo esc_html($disc); ?>
                            </p>
                            <?php
                        }
                        ?>
                    </header>
                    <div
                        class="slider-controller d-flex align-items-center justify-content-center justify-content-lg-start">
                        <button type="button" class="slick-prev slick-arrow">
                            <i class="jobcircle-icon-chevron-left"></i>
                        </button>
                        <button type="button" class="slick-next slick-arrow">
                            <i class="jobcircle-icon-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-lg-7 mb-15 mb-md-30 mb-lg-0">
                    <div class="customers-reviews-slider">
                        <?php
                        $lm_team_list = vc_param_group_parse_atts($atts['mlti_customers']);
                        foreach ($lm_team_list as $key => $value) {

                            $client_img = isset($value["client_img"]) ? $value["client_img"] : '';
                            $client_desc = isset($value["client_desc"]) ? $value["client_desc"] : '';
                            $client_name = isset($value["client_name"]) ? $value["client_name"] : '';
                            $client_imgg = isset($value["client_imgg"]) ? $value["client_imgg"] : '';
                            $client_descc = isset($value["client_descc"]) ? $value["client_descc"] : '';
                            $client_namee = isset($value["client_namee"]) ? $value["client_namee"] : '';

                            ?>
                            <div class="slick-slide">
                                <div class="quote-box">
                                    <div class="img-avatar">
                                        <?php if (!empty($client_img)) {
                                            ?>
                                            <img src="<?php echo esc_url_raw($client_img); ?>" width="130" height="130"
                                                alt="Image Description">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <blockquote>
                                        <?php if (!empty($client_desc)) {
                                            ?>
                                            <q>
                                                <?php echo esc_textarea($client_desc); ?>
                                            </q>
                                            <?php
                                        }
                                        ?>
                                        <cite>
                                            <?php if (!empty($client_name)) {
                                                ?>
                                                <?php echo esc_html($client_name); ?>
                                                <?php
                                            }
                                            ?>
                                        </cite>
                                        <ul class="star-ratings">
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star"></i></li>
                                        </ul>
                                    </blockquote>
                                </div>
                                <div class="quote-box">
                                    <div class="img-avatar">
                                        <?php if (!empty($client_imgg)) {
                                            ?>
                                            <img src="<?php echo esc_url_raw($client_imgg); ?>" width="130" height="130"
                                                alt="Image Description">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <blockquote>
                                        <?php if (!empty($client_descc)) {
                                            ?>
                                            <q>
                                                <?php echo esc_textarea($client_descc); ?>
                                            </q>
                                            <?php
                                        }
                                        ?>
                                        <cite>
                                            <?php if (!empty($client_namee)) {
                                                ?>
                                                <?php echo esc_html($client_namee); ?>
                                                <?php
                                            }
                                            ?>
                                        </cite>
                                        <ul class="star-ratings">
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star filled"></i></li>
                                            <li><i class="jobcircle-icon-star"></i></li>
                                        </ul>
                                    </blockquote>
                                </div>
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
    $html = ob_get_clean();
    return $html;
}
add_shortcode('jc_customer', 'jobcircle_customer_front');