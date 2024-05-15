<?php
/*
 * widget for about us in footer
 */
if (!class_exists('height_contact')) {

    class height_contact extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'height_contact',
                // Base ID.
                __('Height CONTACT', 'jobcircle-frame'),
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

            $contact_heading = isset($instance['contact_heading']) ? esc_attr($instance['contact_heading']) : '';
            $contact_location = isset($instance['contact_location']) ? esc_attr($instance['contact_location']) : '';
           
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
           
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';
                
            ?>
            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                    <?php esc_html_e('Contact Us Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_heading')) ?>"
                    value="<?php echo ($contact_heading) ?>">
                </p>

                 <p>
                    <label>
                    <?php esc_html_e('Contact Us Location', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_location')) ?>"
                     value="<?php echo ($contact_location) ?>">
                </p>

                

                <p>
                    <label>
                     <?php esc_html_e('Contact Us Number', 'jobcircle-frame') ?>
                    </label>
                <input type="text" name="<?php echo ($this->get_field_name('contact_phone')) ?>" value="<?php echo ($contact_phone) ?>">
                </p>
                
                 
                <p>
                    <label>
                     <?php esc_html_e('Contact Us Email', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_email')) ?>"
                     value="<?php echo ($contact_email) ?>">
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
            $instance['contact_heading'] = $new_instance['contact_heading'];
            $instance['contact_location'] = $new_instance['contact_location'];
           
            $instance['contact_phone'] = $new_instance['contact_phone'];
           
            $instance['contact_email'] = $new_instance['contact_email'];


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

            $contact_heading = isset($instance['contact_heading']) ? esc_attr($instance['contact_heading']) : '';
            $contact_location = isset($instance['contact_location']) ? esc_attr($instance['contact_location']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>

           
                <h5><?= $contact_heading ?></h5>
                <ul class="contact-list">
                    <li>
                        <i class="jobcircle-icon-map-pin"></i>
                        <span class="text"> <?php echo esc_html($contact_location) ?></span>
                    </li>
                    <li>
                        <i class="jobcircle-icon-phone"></i>
                        <span class="text"><a href="tel:4402079422000"><?php echo esc_html($contact_phone);?></a></span>
                    </li>
                    <li>
                        <i class="jobcircle-icon-mail"></i>
                        <span class="text"><a href="mailto:hello@username.ac.uk"> <?php echo esc_html($contact_email); ?></a></span>
                    </li>
                </ul>
            

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("height_contact");
});