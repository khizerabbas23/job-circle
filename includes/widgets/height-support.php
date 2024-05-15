<?php
/*
 * widget for about us in footer
 */
if (!class_exists('height_support')) {

    class height_support extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'height_support',
                // Base ID.
                __('Height SUPPORT', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Support Us Checking', 'jobcircle-frame'))
            );
        }

        /**
         * Outputs the jobcircle-frame   widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $base_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

            $support_heading = isset($instance['support_heading']) ? esc_attr($instance['support_heading']) : '';
            $support_url_one = isset($instance['support_url_one']) ? esc_attr($instance['support_url_one']) : '';
            $support_one = isset($instance['support_one']) ? esc_attr($instance['support_one']) : '';
            $support_url_two = isset($instance['support_url_two']) ? esc_attr($instance['support_url_two']) : '';
            $support_two = isset($instance['support_two']) ? esc_attr($instance['support_two']) : '';
            $support_url_three = isset($instance['support_url_three']) ? esc_attr($instance['support_url_three']) : '';
            $support_three = isset($instance['support_three']) ? esc_attr($instance['support_three']) : '';
            $support_url_four = isset($instance['support_url_four']) ? esc_attr($instance['support_url_four']) : '';
            $support_four = isset($instance['support_four']) ? esc_attr($instance['support_four']) : '';

            ?>
            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Service Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('service_heading')) ?>"
                        value="<?php echo ($support_heading) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_one')) ?>"
                        value="<?php echo ($support_url_one) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_one')) ?>"
                        value="<?php echo ($support_one) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_two')) ?>"
                        value="<?php echo ($support_url_two) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_two')) ?>"
                        value="<?php echo ($support_two) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_three')) ?>"
                        value="<?php echo ($support_url_three) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_three')) ?>"
                        value="<?php echo ($support_three) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_four')) ?>"
                        value="<?php echo ($support_url_four) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_four')) ?>"
                        value="<?php echo ($support_four) ?>">
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
            $instance['support_heading'] = $new_instance['support_heading'];
            $instance['support_url_one'] = $new_instance['support_url_one'];
            $instance['support_one'] = $new_instance['support_one'];
            $instance['support_url_two'] = $new_instance['support_url_two'];
            $instance['support_two'] = $new_instance['support_two'];
            $instance['support_url_three'] = $new_instance['support_url_three'];
            $instance['support_three'] = $new_instance['support_three'];
            $instance['support_url_four'] = $new_instance['support_url_four'];
            $instance['support_four'] = $new_instance['support_four'];

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

            $support_heading = isset($instance['support_heading']) ? esc_attr($instance['support_heading']) : '';
            $support_url_one = isset($instance['support_url_one']) ? esc_attr($instance['support_url_one']) : '';
            $support_one = isset($instance['support_one']) ? esc_attr($instance['support_one']) : '';
            $support_url_two = isset($instance['support_url_two']) ? esc_attr($instance['support_url_two']) : '';
            $support_two = isset($instance['support_two']) ? esc_attr($instance['support_two']) : '';
            $support_url_three = isset($instance['support_url_three']) ? esc_attr($instance['support_url_three']) : '';
            $support_three = isset($instance['support_three']) ? esc_attr($instance['support_three']) : '';
            $support_url_four = isset($instance['support_url_four']) ? esc_attr($instance['support_url_four']) : '';
            $support_four = isset($instance['support_four']) ? esc_attr($instance['support_four']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>

                <h5><?= $support_heading ?></h5>
                <ul class="footer-links">
                    <li><a href=" <?php echo esc_html($support_url_one); ?>"> <?php echo esc_html($support_one); ?></a></li>
                    <li><a href=" <?php echo esc_html($support_url_two); ?>"> <?php echo esc_html($support_two); ?></a></li>
                    <li><a href=" <?php echo esc_html($support_url_three); ?>"> <?php echo esc_html($support_three); ?></a></li>
                    <li><a href=" <?php echo esc_html($support_url_four); ?>"> <?php echo esc_html($support_four); ?></a></li>
                </ul>
            </div>

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("height_support");
});