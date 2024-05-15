<?php
/*
 * widget for about us in footer
 */
if (!class_exists('footer_logo_thirteen')) {

    class footer_logo_thirteen extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'footer_logo_thirteen',
                // jobcircle ID.
                __('FOOTER Logo HThirteen', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Logo Checking', 'jobcircle-frame'))
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

            $footer_logo = isset($instance['footer_logo']) ? esc_attr($instance['footer_logo']) : '';

            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Logo', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('footer_logo')) ?>"
                        value="<?php echo ($footer_logo) ?>">
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
            $instance['footer_logo'] = $new_instance['footer_logo'];

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

            $footer_logo = isset($instance['footer_logo']) ? esc_attr($instance['footer_logo']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>


            <strong class="footer-logo">
                <a href="<?php home_url()?>"><img src="<?php echo esc_url_raw($footer_logo) ?>" width="174" height="43" alt="Job Circle"></a>
            </strong>


            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("footer_logo_thirteen");
});