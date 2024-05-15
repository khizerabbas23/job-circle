<?php
function jobcircle_most_viewed()
{
    vc_map(
        array(
            'name' => __('Most Viewed 60'),
            'base' => 'jobcircle_most_viewed',
            'category' => __('Job Circle'),
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
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'description',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List'),
                    'param_name' => 'list_one',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List'),
                    'param_name' => 'list_two',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('List'),
                    'param_name' => 'list_three',
                ),
                // Group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'section_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Upload Image'),
                            'param_name' => 'image',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Title'),
                            'param_name' => 'multi_title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Description'),
                            'param_name' => 'multi_description',
                        ),
                    ),
                )
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_most_viewed');

// Frontend Coding 

function jobcircle_most_viewed_front($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'description' => '',
            'list_one' => '',
            'list_two' => '',
            'list_three' => '',
            'section_multi' => '',
        ),
        $atts,
        'jobcircle_most_viewed'
    );
    $title = isset($atts["title"]) ? $atts["title"] : '';
    $heading = isset($atts["heading"]) ? $atts["heading"] : '';
    $description = isset($atts["description"]) ? $atts["description"] : '';
    $list_one = isset($atts["list_one"]) ? $atts["list_one"] : '';
    $list_two = isset($atts["list_two"]) ? $atts["list_two"] : '';
    $list_three = isset($atts["list_three"]) ? $atts["list_three"] : '';

    ob_start();
    ?>
    <section class="section section-theme-12 how-we-help-block pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-80 pb-xxl-100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6 txt-col">
                <?php if(!empty($title)){ ?>
                    <p class="mb-5 mb-lg-10"><?php echo esc_html($title) ?></p>
                    <?php } ?>
                    <?php if(!empty($heading)){ ?>
                    <h2 class=""><?php echo esc_html($heading) ?></h2>
                    <?php } ?>
                    <?php if(!empty($description)){ ?>
                    <p><?php echo esc_html($description) ?></p>
                    <?php } ?>
                    <ul class="list-unstyled help-list">
                    <?php if(!empty($list_one)){ ?>
                        <li><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bg-check.png" alt="image"><?php echo esc_html($list_one) ?></li>
                        <?php } ?>
                        <?php if(!empty($list_two)){ ?>
                        <li><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bg-check.png" alt="image"><?php echo esc_html($list_two) ?></li>
                        <?php } ?>
                        <?php if(!empty($list_three)){ ?>
                        <li><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bg-check.png" alt="image"><?php echo esc_html($list_three) ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-12 col-md-12 col-lg-6 img-col">
                    <div class="two-columns">
                        <?php
                        $section_multi = vc_param_group_parse_atts($atts['section_multi']);
                        if (!empty($section_multi)) {
                            foreach ($section_multi as $key => $value) {
                                $image = isset($value["image"]) ? $value["image"] : '';
                                $multi_title = isset($value["multi_title"]) ? $value["multi_title"] : '';
                                $multi_description = isset($value["multi_description"]) ? $value["multi_description"] : '';
                        ?>
                                <div class="column">
                                    <div class="img-box">
                                    <?php if(!empty($image)){ ?>
                                        <img src="<?php echo esc_url_raw($image) ?>" alt="image">
                                        <?php } ?>
                                    </div>
                                    <?php if(!empty($multi_title)){ ?>
                                    <strong><?php echo esc_html($multi_title) ?></strong>
                                    <?php } ?>
                                    <?php if(!empty($multi_description)){ ?>
                                    <p><?php echo esc_html($multi_description) ?></p>
                                    <?php } ?>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    return ob_get_clean();
}
add_shortcode('jobcircle_most_viewed', 'jobcircle_most_viewed_front');
