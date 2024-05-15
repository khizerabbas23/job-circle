<?php
/*
 * widget for about us in footer
 */
if (!class_exists('jc_hnine_employe_widget')) {

    class jc_hnine_employe_widget extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jc_hnine_employe_widget',
                // jobcircle ID.
                __('Footer Employer Hnine', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_employer', 'description' => __('Footer Employers ', 'jobcircle-frame'))
            );
        }

        /**
         * Outputs the jobcircle-frame   widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $jobcircle_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

            $main_title = isset($instance['main_title']) ? esc_attr($instance['main_title']) : '';
            $expl = isset($instance['expl']) ? esc_attr($instance['expl']) : '';
            $button_url = isset($instance['button_url']) ? esc_attr($instance['button_url']) : '';
            $button = isset($instance['button']) ? esc_attr($instance['button']) : '';

            ?>

            <div class="col-12 col-lg-4">
                <div class="jobcircle-frame-element-field text-widget-fields">
                    <p>
                        <label>
                            <?php esc_html_e('Title', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('main_title')) ?>" value="<?php echo ($main_title) ?>">
                    </p>
                    <p>
                        <label>
                            <?php esc_html_e('Description', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('expl')) ?>" value="<?php echo ($expl) ?>">
                    </p>
                    <p>
                        <label>
                            <?php esc_html_e('Button Url', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('button_url')) ?>"
                            value="<?php echo ($button_url) ?>">
                    </p>
                    <p>
                        <label>
                            <?php esc_html_e('Button Text', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('button')) ?>" value="<?php echo ($button) ?>">

                    </p>

                </div>
            </div>

            <?php
        }

        /**
         * Handles updating settings for the current jobcircle-frame   widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;
            $instance['main_title'] = $new_instance['main_title'];
            $instance['expl'] = $new_instance['expl'];
            $instance['button_url'] = $new_instance['button_url'];
            $instance['button'] = $new_instance['button'];

            return $instance;
        }

        /**
         * Outputs the content for the current jobcircle-frame   widget instance.
         *
         * @param array $args Display arguments including 'before_title', 'after_title',
         * 'before_widget', and 'after_widget'.
         * @param array $instance Settings for the current Text widget instance.
         */
        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));

            $main_title = isset($instance['main_title']) ? esc_attr($instance['main_title']) : '';
            $expl = isset($instance['expl']) ? esc_attr($instance['expl']) : '';
            $button_url = isset($instance['button_url']) ? esc_attr($instance['button_url']) : '';
            $button = isset($instance['button']) ? esc_attr($instance['button']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);

            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>

            <div class="finder">
                <strong class="h3">
                    <?php echo jobcircle_esc_the_html($main_title) ?>
                </strong>
                <p>
                    <?php echo jobcircle_esc_the_html($expl) ?>
                </p>
                <a class="btn_upload" href="<?php echo jobcircle_esc_the_html($button_url) ?>">
                    <i class="jobcircle-icon-upload-cloud icon"></i>
                    <span class="text">
                        <?php echo jobcircle_esc_the_html($button) ?>
                    </span>
                </a>
            </div>

            <?php

            echo ($after_widget);
        }

    }

}
add_action('widgets_init', function () {
    return register_widget("jc_hnine_employe_widget");
});