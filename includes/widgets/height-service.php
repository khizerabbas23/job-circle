<?php
/*
 * widget for about us in footer
 */
if (!class_exists('height_service')) {

    class height_service extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'height_service',
                // Base ID.
                __('Height Service', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Contact Us Checking', 'jobcircle-frame'))
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

            $service_heading = isset($instance['contact_heading']) ? esc_attr($instance['contact_heading']) : '';
            $services_url_one = isset($instance['services_url_one']) ? esc_attr($instance['services_url_one']) : '';
            $services_one = isset($instance['services_one']) ? esc_attr($instance['services_one']) : '';
            $services_url_two = isset($instance['services_url_two']) ? esc_attr($instance['services_url_two']) : '';
            $services_two = isset($instance['services_two']) ? esc_attr($instance['services_two']) : '';
            $services_url_three = isset($instance['services_url_three']) ? esc_attr($instance['services_url_three']) : '';
            $services_three = isset($instance['services_three']) ? esc_attr($instance['services_three']) : '';
            $services_url_four = isset($instance['services_url_four']) ? esc_attr($instance['services_url_four']) : '';
            $services_four = isset($instance['services_four']) ? esc_attr($instance['services_four']) : '';

            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Service Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('service_heading')) ?>"
                        value="<?php echo ($service_heading) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_one')) ?>"
                        value="<?php echo ($services_url_one) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_one')) ?>"
                        value="<?php echo ($services_one) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_two')) ?>"
                        value="<?php echo ($services_url_two) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_two')) ?>"
                        value="<?php echo ($services_two) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_three')) ?>"
                        value="<?php echo ($services_url_three) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_three')) ?>"
                        value="<?php echo ($services_three) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Service Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_url_four')) ?>"
                        value="<?php echo ($services_url_four) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Services', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('services_four')) ?>"
                        value="<?php echo ($services_four) ?>">
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
            $instance['service_heading'] = $new_instance['service_heading'];
            $instance['services_url_one'] = $new_instance['services_url_one'];
            $instance['services_one'] = $new_instance['services_one'];
            $instance['services_url_two'] = $new_instance['services_url_two'];
            $instance['services_two'] = $new_instance['services_two'];
            $instance['services_url_three'] = $new_instance['services_url_three'];
            $instance['services_three'] = $new_instance['services_three'];
            $instance['services_url_four'] = $new_instance['services_url_four'];
            $instance['services_four'] = $new_instance['services_four'];

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

            $service_heading = isset($instance['service_heading']) ? esc_attr($instance['service_heading']) : '';
            $services_url_one = isset($instance['services_url_one']) ? esc_attr($instance['services_url_one']) : '';
            $services_one = isset($instance['services_one']) ? esc_attr($instance['services_one']) : '';
            $services_url_two = isset($instance['services_url_two']) ? esc_attr($instance['services_url_two']) : '';
            $services_two = isset($instance['services_two']) ? esc_attr($instance['services_two']) : '';
            $services_url_three = isset($instance['services_url_three']) ? esc_attr($instance['services_url_three']) : '';
            $services_three = isset($instance['services_three']) ? esc_attr($instance['services_three']) : '';
            $services_url_four = isset($instance['services_url_four']) ? esc_attr($instance['services_url_four']) : '';
            $services_four = isset($instance['services_four']) ? esc_attr($instance['services_four']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>
                <h5><?= $service_heading ?></h5>
                 <ul class="footer-links">
                    <li><a href=" <?php echo esc_html($services_url_one); ?>"> <?php echo esc_html($services_one); ?></a></li>
                    <li><a href=" <?php echo esc_html($services_url_two); ?>"> <?php echo esc_html($services_two); ?></a></li>
                    <li><a href=" <?php echo esc_html($services_url_three); ?>"> <?php echo esc_html($services_three); ?></a></li>
                    <li><a href=" <?php echo esc_html($services_url_four); ?>"> <?php echo esc_html($services_four); ?></a></li>
                </ul>
            

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("height_service");
});