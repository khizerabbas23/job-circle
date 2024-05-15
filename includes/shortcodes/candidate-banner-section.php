<?php
function jobcircle_banner_candidate()
{
        vc_map(
        array(
            'name' => __('Candidate Main Banner'),
            'base' => 'jobcircle_banner_candidate',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'back_img',
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
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Text'),
                    'param_name' => 'btn_txt',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_banner_candidate');
function jobcircle_banner_candidate_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'back_img' => '',
            'title' => '',
            'desc' => '',
            'btn_url' => '',
            'btn_txt' => '',
        ),
        $atts,
        'jobcircle_banner_candidate'
    );

    $back_img = isset($atts['back_img']) ? $atts['back_img'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $btn_txt = isset($atts['btn_txt']) ? $atts['btn_txt'] : '';

    ob_start();
?>
    <div class="subvisual-block cndi-bn-pd subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white">
        <?php if (!empty($back_img)) { ?>
            <div class="pattern-image"><img src="<?php echo esc_url_raw($back_img) ?>" width="1920" height="570" alt="Pattern">
            <?php } ?>
            </div>
            <div class="container position-relative text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="subvisual-textbox">
                            <?php if (!empty($title)) {
                            ?>
                                <h1>
                                    <?php jobcircle_esc_the_html($title) ?>
                                </h1>
                            <?php
                            } ?>
                            <?php if (!empty($desc)) {
                            ?>
                                <p>
                                    <?php echo esc_textarea($desc) ?>
                                </p>
                            <?php
                            } ?>
                        </div>
                        <!-- search form -->
                        <form class="form-search form-inline" action="#">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group">
                                    <label for="rel01">
                                        <?php esc_html_e('What are you looking for?', 'jobcircle-frame') ?>
                                    </label>
                                    <div class="form-input">
                                        <select id="rel01" class="select2" name="state" data-placeholder="What are you looking for?">
                                            <option label="Placeholder"></option>
                                            <option><?php esc_html_e('Web Developer', 'jobcircle-frame') ?></option>
                                            <option><?php esc_html_e('Web Developer', 'jobcircle-frame') ?></option>
                                            <option><?php esc_html_e('Web Developer', 'jobcircle-frame') ?></option>
                                            <option><?php esc_html_e('Web Developer', 'jobcircle-frame') ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="rel02">
                                        <?php esc_html_e('Category', 'jobcircle-frame') ?>
                                    </label>

                                    <div class="form-input">
                                        <select id="rel02" class="select2" name="state" data-placeholder="Category">
                                            <option label="Placeholder"></option>
                                            <?php
                                            // Fetch the terms for the custom taxonomy 'job_featured'
                                            $terms = get_terms(array(
                                                'taxonomy' => 'job_category',
                                                'post_type' => 'jobs',
                                                'hide_empty' => false,
                                            ));

                                            $counter = 0;
                                            foreach ($terms as $term) {
                                                if ($counter < 4) {
                                                    // Query to get the post count for each term
                                                    $args = array(
                                                        'post_type' => 'jobs',
                                                        'tax_query' => array(
                                                            array(
                                                                'taxonomy' => 'job_category',
                                                                'field'    => 'term_id',
                                                                'terms'    => $term->term_id,
                                                            ),
                                                        ),
                                                    );
                                            ?>
                                                    <option><?php echo jobcircle_esc_the_html($term->name ); ?></option>
                                            <?php
                                                    $counter++;
                                                } else {
                                                    break; // Break the loop after 9 categories
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <?php if (!empty($btn_url) || !empty($btn_txt)) { ?>
                                <a href="<?php jobcircle_esc_the_html($btn_url) ?>"><button class="btn btn-green btn-sm" type="submit"><span class="btn-text">
                                            <?php jobcircle_esc_the_html($btn_txt) ?>
                                        </span></button></a>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    <?php
    ?>
<?php
    return ob_get_clean();
}
add_shortcode('jobcircle_banner_candidate', 'jobcircle_banner_candidate_frontend');
