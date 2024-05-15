<?php
function jobcircle_main_banner_faq()
{
    vc_map(
        array(
            'name' => __('Faq Banner'),
            'base' => 'jc_main_banner_faq',
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
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
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
                    'param_name' => 'desc',
                ),
            ),
        )
    );
}
add_action('vc_before_init', 'jobcircle_main_banner_faq');
function jobcircle_main_banner_faq_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'back_img' => '',
            'bg_img' => '',
            'title' => '',
            'desc' => '',


        ),
        $atts,
        'jobcircle_main_banner_faq'
    );

    $back_img = isset($atts['back_img']) ? $atts['back_img'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';

    ob_start();
    ?>
    <?php
    if (!empty($back_img)) {
        ?>
        <div class="subvisual-block theme-faq-banner subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white"
            style="<?php echo esc_url_raw($back_img) ?>">
            <?php
    } ?>
        <div class="pattern-image"><img src="
        <?php
        if (!empty($bg_img)) {
            ?>
        <?php echo esc_url_raw($bg_img) ?>
        <?php
        } ?>
        " width="1920" height="570" alt="Pattern">
        </div>
        <div class="container position-relative text-center">
            <div class="row">
                <div class="col-12">
                    <div class="subvisual-textbox">
                        <?php
                        if (!empty($title)) {
                            ?>
                            <h1>
                                <?php echo esc_html($title) ?>
                            </h1>
                            <?php
                        } ?>
                        <?php
                        if (!empty($desc)) {
                            ?>
                            <p>
                                <?php echo esc_html($desc) ?>
                            </p>
                            <?php
                        } ?>
                    </div>
                    <div class="form-subscribe mt-20 mt-lg-40 mb-md-10">
                        <form action="#">
                            <input class="form-control" name="s" type="text"
                                placeholder="<?php esc_html_e('Find Queries', 'jobcircle-frame') ?>">
                            <button class="btn btn-green btn-search btn-sm"><span class="btn-text"><i
                                        class="jobcircle-icon-search  th-pdfont"></i>
                                    <?php esc_html_e('Search', 'jobcircle-frame') ?>
                                </span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    ?>

    <?php

    return ob_get_clean();
}
add_shortcode('jc_main_banner_faq', 'jobcircle_main_banner_faq_frontend');