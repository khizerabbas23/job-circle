<?php
/*
 * widget for about us in footer
 */
if (!class_exists('footer_need_help_six')) {

    class footer_need_help_six extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'footer_need_help_six',
                // jobcircle ID.
                __('FOOTER NEED HELP HSIX', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_need_help', 'description' => __('Need Help Checking', 'jobcircle-frame'))
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

            $phone_num = isset($instance['phone_num']) ? esc_attr($instance['phone_num']) : '';
            $location = isset($instance['location']) ? esc_attr($instance['location']) : '';

            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">

                <p>
                    <label>
                        <?php esc_html_e('Phone Number', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('phone_num')) ?>" value="<?php echo ($phone_num) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Location', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('location')) ?>" value="<?php echo ($location) ?>">
                </p>

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
            $instance['phone_num'] = $new_instance['phone_num'];
            $instance['location'] = $new_instance['location'];

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

            $phone_num = isset($instance['phone_num']) ? esc_attr($instance['phone_num']) : '';
            $location = isset($instance['location']) ? esc_attr($instance['location']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>


            <div class="contact-info">
                <p class="phone-number">
                    <?php esc_html_e('Need help? 24/7: ', 'jobcircle-frame') ?><a class="number" href="tel:<?php echo esc_html($phone_num)  ?>">
                        <?php echo jobcircle_esc_the_html($phone_num) ?>
                    </a>
                </p>
                <p class="address-info"><i class="jobcircle-icon-map-pin"></i> <?php echo esc_html($location) ?></p>
            </div>

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("footer_need_help_six");
});