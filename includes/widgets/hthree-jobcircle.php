<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hthree_jobcircle')) {

    class hthree_jobcircle extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hthree_jobcircle',
                // Base ID.
                __('Hthree JobCircle', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Newsletter Checking', 'jobcircle-frame'))
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

            $hthree_jobcircle = isset($instance['hthree_jobcircle']) ? esc_attr($instance['hthree_jobcircle']) : '';
            $hthree_shortdesc = isset($instance['hthree_shortdesc']) ? esc_attr($instance['hthree_shortdesc']) : '';
            $hthree_helpnum = isset($instance['hthree_helpnum']) ? esc_attr($instance['hthree_helpnum']) : '';
            $hthree_location = isset($instance['hthree_location']) ? esc_attr($instance['hthree_location']) : '';


            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('JobCircle', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_jobcircle')) ?>"
                        value="<?php echo ($hthree_jobcircle) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Short Description', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_shortdesc')) ?>"
                        value="<?php echo ($hthree_shortdesc) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Help Number', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_helpnum')) ?>"
                        value="<?php echo ($hthree_helpnum) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Location', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_location')) ?>"
                        value="<?php echo ($hthree_location) ?>">
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
            $instance['hthree_jobcircle'] = $new_instance['hthree_jobcircle'];
            $instance['hthree_shortdesc'] = $new_instance['hthree_shortdesc'];
            $instance['hthree_helpnum'] = $new_instance['hthree_helpnum'];
            $instance['hthree_location'] = $new_instance['hthree_location'];


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

            $hthree_jobcircle = isset($instance['hthree_jobcircle']) ? esc_attr($instance['hthree_jobcircle']) : '';
            $hthree_shortdesc = isset($instance['hthree_shortdesc']) ? esc_attr($instance['hthree_shortdesc']) : '';
            $hthree_helpnum = isset($instance['hthree_helpnum']) ? esc_attr($instance['hthree_helpnum']) : '';
            $hthree_location = isset($instance['hthree_location']) ? esc_attr($instance['hthree_location']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>    
            <!-- Footer Information -->
            <div class="footer-info">
                <strong class="logo">
                    <a href="<?php echo home_url();?>"><img src="<?php echo esc_url_raw($hthree_jobcircle);?>" width="224" height="62" alt="<?php esc_attr_e('Job Circle', 'jobcircle-frame');?>"></a>
                </strong>
                <p><?php echo esc_html($hthree_shortdesc);?></p>
                <p><?php esc_html_e('Need help? 24/7: ');?><a class="number" href="tel:<?php echo esc_html($hthree_helpnum);?>"><?php echo esc_html($hthree_helpnum);?></a></p>
                <p><i class="jobcircle-icon-map-pin"></i>&nbsp;<?php echo esc_html($hthree_location);?></p>
            </div>
						
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hthree_jobcircle");
});