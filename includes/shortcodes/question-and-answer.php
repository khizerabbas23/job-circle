<?php
function jobcircle_faq_panel_section()
{
    vc_map(
        array(
            'name' => __('Question & Answers'),
            'base' => 'jc_faq_panel_section',
            'category' => __('Job Circle'),
            'params' => array(
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'faq_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Question'),
                            'param_name' => 'question',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Answer'),
                            'param_name' => 'answer',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Answer'),
                            'param_name' => 'answr_one',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('ID'),
                            'param_name' => 'ids',
                        ),

                    ),
                )
            )


        )
    );
}
add_action('vc_before_init', 'jobcircle_faq_panel_section');


// Frontend Coding 

function jobcircle_faq_panel_section_front($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'faq_multi' => '',
        ),
        $atts,
        'jobcircle_faq_panel_section'
    );

    ob_start();
    ?>
    <section class="section section-theme-1 section-faqs pt-35 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-125 pb-35 pb-md-50 pb-lg-75 pb-xl-100 pb-xxl-125">
        <div class="container">
            <div class="accordion" id="faq-accordion">

                <?php
                $counter =0;
                $lm_team_list = vc_param_group_parse_atts($atts['faq_multi']);
                foreach ($lm_team_list as $key => $value) {
                    $question = isset($value["question"]) ? $value["question"] : '';
                    $answer = isset($value["answer"]) ? $value["answer"] : '';
                    $answr_one = isset($value["answr_one"]) ? $value["answr_one"] : '';
                    $ids = isset($value["ids"]) ? $value["ids"] : '';

                    // Check if it's the first item
                    if ($counter == 0) {
                        $cls = 'true';
                        $show = 'show';
                        $colape = '';
                    } else {
                        $cls = '';
                        $show = '';
                        $colape = 'collapsed';
                    }

                    ?>
                    <div class="accordion-item">
                        <?php 
                          if(!empty($ids) || !empty($colape) || !empty($question)){
                                            ?>
                        <h2 class="accordion-header" id="heading<?php echo jobcircle_esc_the_html($ids); ?>">
                            <button class="accordion-button <?php echo jobcircle_esc_the_html($colape) ?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?php echo jobcircle_esc_the_html($ids) ?>" aria-expanded="<?php echo jobcircle_esc_the_html($cls) ?>" aria-controls="<?php echo jobcircle_esc_the_html($ids) ?>">
                                <span class="bullet"></span>
                                <?php if (!empty($question)) { ?>
                                    <span class="title">
                                        <?php echo esc_html($question) ?>
                                    </span>
                                <?php } ?>
                            </button>
                        </h2>
                         <?php
                                        }
                                        ?>
                        <div id="collapse<?php echo jobcircle_esc_the_html($ids) ?>" class="accordion-collapse collapse <?php echo jobcircle_esc_the_html($show) ?> " aria-labelledby="heading<?php echo jobcircle_esc_the_html($ids) ?>"
                             data-bs-parent="#faq-accordion">
                            <div class="accordion-body">
                                <p>
                                    <?php if (!empty($answer)) { ?>
                                        <?php echo esc_textarea($answer) ?>
                                    <?php } ?>
                                </p>
                                <p>
                                    <?php if (!empty($answr_one)) { ?>
                                        <?php echo esc_textarea($answr_one) ?>
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php
                    $counter++;
                }
                ?>
            </div>
        </div>
    </section>

    <?php

    return ob_get_clean();
}
add_shortcode('jc_faq_panel_section', 'jobcircle_faq_panel_section_front');
