<?php
/*
 * widget for about us in footer
 */
if (!class_exists('footer_contact_us')) {

    class footer_contact_us extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'footer_contact_us',
                // jobcircle ID.
                __('FOOTER CONTACT', 'jobcircle-frame'),
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
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
            $socail_media_heading = isset($instance['socail_media_heading']) ? esc_attr($instance['socail_media_heading']) : '';
            $fb_url = isset($instance['fb_url']) ? esc_attr($instance['fb_url']) : '';
            $in_url = isset($instance['in_url']) ? esc_attr($instance['in_url']) : '';
            $tw_url = isset($instance['tw_url']) ? esc_attr($instance['tw_url']) : '';
            $Yutb_url = isset($instance['Yutb_url']) ? esc_attr($instance['Yutb_url']) : '';

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
                        <?php esc_html_e('Contact Us Email', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_email')) ?>" value="<?php echo ($contact_email) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Contact Phone No.', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('contact_phone')) ?>"
                        value="<?php echo ($contact_phone) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Social Media Heading', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('socail_media_heading')) ?>"
                        value="<?php echo ($socail_media_heading) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Facebook Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('fb_url')) ?>"
                        value="<?php echo ($fb_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Instagram Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('in_url')) ?>"
                        value="<?php echo ($in_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Youtube Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('Yutb_url')) ?>"
                        value="<?php echo ($Yutb_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Twitter Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('tw_url')) ?>"
                        value="<?php echo ($tw_url) ?>">
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
            $instance['contact_email'] = $new_instance['contact_email'];
            $instance['contact_phone'] = $new_instance['contact_phone'];
            $instance['socail_media_heading'] = $new_instance['socail_media_heading'];
            $instance['fb_url'] = $new_instance['fb_url'];
            $instance['in_url'] = $new_instance['in_url'];
            $instance['tw_url'] = $new_instance['tw_url'];
            $instance['Yutb_url'] = $new_instance['Yutb_url'];
            
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
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
            $socail_media_heading = isset($instance['socail_media_heading']) ? esc_attr($instance['socail_media_heading']) : '';
            $fb_url = isset($instance['fb_url']) ? esc_attr($instance['fb_url']) : '';
            $in_url = isset($instance['in_url']) ? esc_attr($instance['in_url']) : '';
            $tw_url = isset($instance['tw_url']) ? esc_attr($instance['tw_url']) : '';
            $Yutb_url = isset($instance['Yutb_url']) ? esc_attr($instance['Yutb_url']) : '';
        
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
   ?>         
   
      
								<!-- Contact Information -->
                                <div class="ms-xl-n50">
								<h5 class="h4 tension"><?php echo jobcircle_esc_the_html($contact_heading) ?></h5>
								<ul class="contact-list">
									<li>
										<i class="jobcircle-icon-map-pin"></i>
										<span class="text"><?php echo jobcircle_esc_the_html($contact_address) ?></span>
									</li>
									<li>
										<i class="jobcircle-icon-mail"></i>
										<span class="text"><a href="mailto:example@mail.com"><?php echo jobcircle_esc_the_html($contact_email) ?></a></span>
									</li>
									<li>
										<i class="jobcircle-icon-phone"></i>
										<span class="text"><a href="tel:111222333444"><?php echo jobcircle_esc_the_html($contact_phone) ?></a></span>
									</li>
								</ul>
								<!-- Social Networks -->
								<div class="social-box">
									<strong class="title"><?php echo jobcircle_esc_the_html($socail_media_heading) ?></strong>
									<ul class="social-networks">
										<li><a href="<?php echo jobcircle_esc_the_html($fb_url) ?>"><i class="jobcircle-icon-facebook"></i></a></li>
										<li><a href="<?php echo jobcircle_esc_the_html($in_url) ?>"><i class="jobcircle-icon-instagram"></i></a></li>
										<li><a href="<?php echo jobcircle_esc_the_html($tw_url) ?>"><i class="jobcircle-icon-twitter"></i></a></li>
										<li><a href="<?php echo jobcircle_esc_the_html($Yutb_url) ?>"><i class="jobcircle-icon-youtube-play"></i></a></li>
									</ul>
								</div>
								</div>

							
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("footer_contact_us");
});