<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hseventeen_jobcircle')) {

    class hseventeen_jobcircle extends WP_Widget
    {
        /**
         * Sets up a new base-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hseventeen_jobcircle',
                // Base ID.
                __('HSeventeen Jobcircle', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_information', 'description' => __('Information Checking', 'jobcircle-frame'))
            );
        }

        /**
         * Outputs the base-frame   widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $base_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';
            $desc = isset($instance['desc']) ? esc_attr($instance['desc']) : '';
            
            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Footer Logo', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('logo')) ?>"
                        value="<?php echo ($logo) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Footer Description', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('desc')) ?>"
                        value="<?php echo ($desc) ?>">
                </p>                
            </div>

            <?php
        }

        /**
         * Handles updating settings for the current base-frame   widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;
            $instance['logo'] = $new_instance['logo'];
            $instance['desc'] = $new_instance['desc'];
        
            return $instance;
        }
        /**
         * Outputs the content for the current base-frame   widget instance.
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

            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';
            $desc = isset($instance['desc']) ? esc_attr($instance['desc']) : '';
           
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>
            
            <div class="social-links-holder">
                <div class="footer-logo">
                    <img src="<?php echo esc_url_raw($logo);?>" alt="logo">
                </div>
                <p><?php echo esc_html($desc);?></p>
            </div>
                           
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hseventeen_jobcircle");
});