<?php
/*
 * widget for about us in footer
 */
if (!class_exists('footer_icons_thirteen')) {

    class footer_icons_thirteen extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'footer_icons_thirteen',
                // jobcircle ID.
                __('FOOTER ICON HThirteen', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Icon Checking', 'jobcircle-frame'))
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

            $fb_url = isset($instance['fb_url']) ? esc_attr($instance['fb_url']) : '';
            $linkedin = isset($instance['linkedin']) ? esc_attr($instance['linkedin']) : '';
            $youtube = isset($instance['youtube']) ? esc_attr($instance['youtube']) : '';
            $instagram = isset($instance['instagram']) ? esc_attr($instance['instagram']) : '';

            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Facebook Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('fb_url')) ?>"
                        value="<?php echo ($fb_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Linkedin Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('linkedin')) ?>"
                        value="<?php echo ($linkedin) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Youtube Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('youtube')) ?>"
                        value="<?php echo ($youtube) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Instagram Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('instagram')) ?>"
                        value="<?php echo ($instagram) ?>">
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
            $instance['fb_url'] = $new_instance['fb_url'];
            $instance['linkedin'] = $new_instance['linkedin'];
            $instance['youtube'] = $new_instance['youtube'];
            $instance['instagram'] = $new_instance['instagram'];


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

            $fb_url = isset($instance['fb_url']) ? esc_attr($instance['fb_url']) : '';
            $linkedin = isset($instance['linkedin']) ? esc_attr($instance['linkedin']) : '';
            $youtube = isset($instance['youtube']) ? esc_attr($instance['youtube']) : '';
            $instagram = isset($instance['instagram']) ? esc_attr($instance['instagram']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>

            <ul class="social-networks no-bg">
                <li><a href="<?php echo esc_html($fb_url) ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                <li><a href="<?php echo esc_html($linkedin) ?>"><i class="jobcircle-icon-linkedin"></i></a></li>
                <li><a href="<?php echo esc_html($youtube) ?>"><i class="jobcircle-icon-youtube-play"></i></a></li>
                <li><a href="<?php echo esc_html($instagram) ?>"><i class="jobcircle-icon-instagram"></i></a></li>
            </ul>


            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("footer_icons_thirteen");
});