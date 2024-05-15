<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hseventeen_footer_contact')) {

    class hseventeen_footer_contact extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hseventeen_footer_contact',
                // jobcircle ID.
                __('HSeventeen Footer Contact', 'jobcircle-frame'),
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

            global $jobcircle_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

            $contact_heading = isset($instance['contact_heading']) ? esc_attr($instance['contact_heading']) : '';
            $contact_address = isset($instance['contact_address']) ? esc_attr($instance['contact_address']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
           
            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Contact Us Heading', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_heading')) ?>"
                        value="<?php echo ($contact_heading) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Contact Us Address', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_address')) ?>"
                        value="<?php echo ($contact_address) ?>">
                </p>         
                <p>
                    <label>
                        <?php esc_html_e('Contact Phone No.', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_phone')) ?>"
                        value="<?php echo ($contact_phone) ?>">
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
            $instance['contact_address'] = $new_instance['contact_address'];
            $instance['contact_phone'] = $new_instance['contact_phone'];
            
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
            $contact_address = isset($instance['contact_address']) ? esc_attr($instance['contact_address']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
        
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
   ?>         
   
                    <div class="contact_info_holder">
							<strong class="h5"><?php echo jobcircle_esc_the_html($contact_heading); ?></strong>
							<ul class="contact-info-list">
								<li>
									<div class="icon-left">
										<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icon_location.svg" alt="icon">
									</div>
									<span class="sub-text address">
										<?php echo jobcircle_esc_the_html($contact_address); ?>
										<a href="tel:<?php echo jobcircle_esc_the_html($contact_phone); ?>"><?php echo jobcircle_esc_the_html($contact_phone); ?></a>
									</span>
								</li>
							</ul>
						</div>
      
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hseventeen_footer_contact");
});