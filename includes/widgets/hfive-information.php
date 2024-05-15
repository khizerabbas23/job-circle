<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hfive_information')) {

    class hfive_information extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hfive_information',
                // Base ID.
                __('Hfive Information', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_information', 'description' => __('Information Checking', 'jobcircle-frame'))
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

            $info_heading = isset($instance['info_heading']) ? esc_attr($instance['info_heading']) : '';
            $info_desc = isset($instance['info_desc']) ? esc_attr($instance['info_desc']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';
            $info_address = isset($instance['info_address']) ? esc_attr($instance['info_address']) : '';

            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Information Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('info_heading')) ?>"
                        value="<?php echo jobcircle_esc_the_html($info_heading) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Information Description', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo jobcircle_esc_the_html($this->get_field_name('info_desc')) ?>" value="<?php echo ($info_desc) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter Number', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_phone')) ?>"
                        value="<?php echo ($contact_phone) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter Email', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_email')) ?>"
                        value="<?php echo ($contact_email) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter Address', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('info_address')) ?>"
                        value="<?php echo ($info_address) ?>">
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
            $instance['info_heading'] = $new_instance['info_heading'];
            $instance['info_desc'] = $new_instance['info_desc'];
            $instance['contact_phone'] = $new_instance['contact_phone'];
            $instance['contact_email'] = $new_instance['contact_email'];
            $instance['info_address'] = $new_instance['info_address'];

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

            $info_heading = isset($instance['info_heading']) ? esc_attr($instance['info_heading']) : '';
            $info_desc = isset($instance['info_desc']) ? esc_attr($instance['info_desc']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';
            $info_address = isset($instance['info_address']) ? esc_attr($instance['info_address']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>

            <h5>
                <?php echo esc_html($info_heading) ?>
            </h5>
            <div class="contact-info-box">
                <span class="text">
                    <?php echo esc_textarea($info_desc); ?>
                </span>
                <strong class="phone">
                    <a href="<?php esc_html_e('tel: ','jobcircle-frame') ?><?php echo esc_html($contact_phone); ?>">
                        <?php echo esc_html($contact_phone); ?>
                    </a>
                </strong>
                <strong class="email">
                    <a href="<?php esc_html_e('mailto: ','jobcircle-frame') ?><?php echo esc_html($contact_email); ?>">
                        <?php echo esc_html($contact_email); ?>
                    </a>
                </strong>
                <address>
                    <?php echo esc_html($info_address); ?>
                </address>
            </div>

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hfive_information");
});