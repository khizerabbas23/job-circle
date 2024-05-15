<?php
/*
 * widget for about us in footer
 */
if (!class_exists('jobcircle_hsixty')) {

    class jobcircle_hsixty extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jobcircle_hsixty',
                // Base ID.
                __('Hsixty JobCircle', 'jobcircle-frame'),
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

            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';
            $shortdesc = isset($instance['shortdesc']) ? esc_attr($instance['shortdesc']) : '';
            $fb_url = isset($instance['fb_url']) ? esc_attr($instance['fb_url']) : '';
            $linkedin_url = isset($instance['linkedin_url']) ? esc_attr($instance['linkedin_url']) : '';
            $youtube_url = isset($instance['youtube_url']) ? esc_attr($instance['youtube_url']) : '';
            $instgrm_url = isset($instance['instgrm_url']) ? esc_attr($instance['instgrm_url']) : '';




            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('JobCircle Footer Logo', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('logo')) ?>"
                        value="<?php echo ($logo) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Short Description', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('shortdesc')) ?>"
                        value="<?php echo ($shortdesc) ?>">
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
                        <?php esc_html_e('LinkedIn Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('linkedin_url')) ?>"
                        value="<?php echo ($linkedin_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Youtube Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('youtube_url')) ?>"
                        value="<?php echo ($youtube_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Instagram Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('instgrm_url')) ?>"
                        value="<?php echo ($instgrm_url) ?>">
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
            $instance['logo'] = $new_instance['logo'];
            $instance['shortdesc'] = $new_instance['shortdesc'];
            $instance['fb_url'] = $new_instance['fb_url'];
            $instance['linkedin_url'] = $new_instance['linkedin_url'];
            $instance['youtube_url'] = $new_instance['youtube_url'];
            $instance['instgrm_url'] = $new_instance['instgrm_url'];




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

            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';
            $shortdesc = isset($instance['shortdesc']) ? esc_attr($instance['shortdesc']) : '';
            $fb_url = isset($instance['fb_url']) ? esc_attr($instance['fb_url']) : '';
            $linkedin_url = isset($instance['linkedin_url']) ? esc_attr($instance['linkedin_url']) : '';
            $youtube_url = isset($instance['youtube_url']) ? esc_attr($instance['youtube_url']) : '';
            $instgrm_url = isset($instance['instgrm_url']) ? esc_attr($instance['instgrm_url']) : '';



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
							<div class="contact-info-box">
								<strong class="logo d-none d-lg-block">
									<a href="<?php home_url()?>">
										<img src="<?php echo esc_url_raw($logo)?>" width="175" height="45" alt="Job Circle">
									</a>
								</strong>
								<p><?php echo esc_html($shortdesc)?></p>
								<ul class="social-networks no-bg d-flex flex-wrap justify-content-start">
									<li><a href="<?php echo esc_html($fb_url)?>"><i class="jobcircle-icon-facebook"></i></a></li>
									<li><a href="<?php echo esc_html($linkedin_url)?>"><i class="jobcircle-icon-linkedin"></i></a></li>
									<li><a href="<?php echo esc_html($youtube_url)?>"><i class="jobcircle-icon-youtube"></i></a></li>
									<li><a href="<?php echo esc_html($instgrm_url)?>"><i class="jobcircle-icon-instagram"></i></a></li>
								</ul>
							</div>
						
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("jobcircle_hsixty");
});