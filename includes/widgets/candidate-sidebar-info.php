<?php
/*
 * widget for about us in footer
 */
if (!class_exists('jobcircle_candidate_theme_info')) {

    class jobcircle_candidate_theme_info extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jobcircle_candidate_theme_info',
                // Base ID.
                __('Candidate Detail Page Info Sidebar Widget', 'jobcircle-frame'),
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

            $numb = isset($instance['numb']) ? esc_attr($instance['numb']) : '';
            $email = isset($instance['email']) ? esc_attr($instance['email']) : '';
            $location = isset($instance['location']) ? esc_attr($instance['location']) : '';
            $facebook_url = isset($instance['facebook_url']) ? esc_attr($instance['facebook_url']) : '';
            $instagram_url = isset($instance['instagram_url']) ? esc_attr($instance['instagram_url']) : '';
            $twitter_url = isset($instance['twitter_url']) ? esc_attr($instance['twitter_url']) : '';



            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Number', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('numb')) ?>"
                        value="<?php echo ($numb) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Email', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('email')) ?>"
                        value="<?php echo ($email) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter location', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('location')) ?>"
                        value="<?php echo ($location) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter Facebook Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('facebook_url')) ?>"
                        value="<?php echo ($facebook_url) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Enter Instagram Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('instagram_url')) ?>"
                        value="<?php echo ($instagram_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter Twitter Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('twitter_url')) ?>"
                        value="<?php echo ($twitter_url) ?>">
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
            $instance['numb'] = $new_instance['numb'];
            $instance['email'] = $new_instance['email'];
            $instance['location'] = $new_instance['location'];
            $instance['facebook_url'] = $new_instance['facebook_url'];
            $instance['instagram_url'] = $new_instance['instagram_url'];
            $instance['twitter_url'] = $new_instance['twitter_url'];



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

            $numb = isset($instance['numb']) ? esc_attr($instance['numb']) : '';
            $email = isset($instance['email']) ? esc_attr($instance['email']) : '';
            $location = isset($instance['location']) ? esc_attr($instance['location']) : '';
            $facebook_url = isset($instance['facebook_url']) ? esc_attr($instance['facebook_url']) : '';
            $instagram_url = isset($instance['instagram_url']) ? esc_attr($instance['instagram_url']) : '';
            $twitter_url = isset($instance['twitter_url']) ? esc_attr($instance['twitter_url']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>    
							<div class="company-contact-info">
									<ul class="company-contact-list">
										<li>
											<i class="jobcircle-icon-phone"></i>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Phone No:', 'jobcircle-frame')?></strong>
												<span class="text"><a href="<?php esc_html_e('tel:', 'jobcircle-frame')?><?php echo esc_html($numb)?>"><?php echo esc_html($numb)?></a></span>
											</div>
										</li>
										<li>
											<i class="jobcircle-icon-mail"></i>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Email Address:', 'jobcircle-frame')?></strong>
												<span class="text"><a href="<?php esc_html_e('mailto:', 'jobcircle-frame')?><?php echo esc_html($email)?>"><?php echo esc_html($email)?></a></span>
											</div>
										</li>
										<li>
											<i class="jobcircle-icon-map-pin"></i>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Location:', 'jobcircle-frame')?>	</strong>
												<address class="text"><?php echo esc_html($location)?></address>
											</div>
										</li>
										<li>
											<div class="textinfo">
												<strong class="title"><?php esc_html_e('Social Media Profiles:', 'jobcircle-frame')?></strong>
												<ul class="social-networks d-flex flex-wrap">
													<li><a href="<?php echo esc_html($facebook_url)?>"><i class="jobcircle-icon-facebook"></i></a></li>
													<li><a href="<?php echo esc_html($instagram_url)?>"><i class="jobcircle-icon-instagram"></i></a></li>
													<li><a href="<?php echo esc_html($twitter_url)?>"><i class="jobcircle-icon-twitter"></i></a></li>
												</ul>
											</div>
										</li>
									</ul>
								</div>
						
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("jobcircle_candidate_theme_info");
});