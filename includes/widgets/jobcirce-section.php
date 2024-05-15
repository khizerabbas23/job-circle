<?php
/*
 * widget for about us in footer
 */
if (!class_exists('Baeetth_duis_job')) {

    class Baeetth_duis_job extends WP_Widget
    {
        /**
         * Sets up a new base-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'Baeetth_duis_job',
                // Base ID.
                __('Job Circle', 'base-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('JobCircle Us Checking', 'base-frame'))
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
            $heading = isset($instance['heading']) ? esc_attr($instance['heading']) : '';
            $heading_two = isset($instance['heading_two']) ? esc_attr($instance['heading_two']) : '';
            $google_button = isset($instance['google_button']) ? esc_attr($instance['google_button']) : '';
            $google_url = isset($instance['google_url']) ? esc_attr($instance['google_url']) : '';
            $appstore_button = isset($instance['appstore_button']) ? esc_attr($instance['appstore_button']) : '';
            $appstore_url = isset($instance['appstore_url']) ? esc_attr($instance['appstore_url']) : '';

            ?>


            <div class="base-frame-element-field text-widget-fields">
            <p>
                    <label>
                        <?php esc_html_e('Logo', 'base-frame') ?>
                    </label>
                    <input type="textarea" name="<?php echo ($this->get_field_name('logo')) ?>"
                        value="<?php echo ($logo) ?>">
                </p>
                <p>
                          <label>
                                       <?php esc_html_e('Heading', 'base-frame') ?>
                              </label>
                                      <textarea name="<?php echo esc_attr($this->get_field_name('heading')); ?>" rows="8" cols="50">
                                              <?php echo esc_textarea($heading); ?>
                                        </textarea>
                               </p>

                               <p>
                          <label>
                                       <?php esc_html_e('Heading Two', 'base-frame') ?>
                              </label>
                                      <textarea name="<?php echo esc_attr($this->get_field_name('heading_two')); ?>" rows="8" cols="50">
                                              <?php echo esc_textarea($heading_two); ?>
                                        </textarea>
                               </p>

                <p>
                    <label>
                        <?php esc_html_e('Goodle Play', 'base-frame') ?>
                    </label>
                    <input type="Contact Us Heading" name="<?php echo ($this->get_field_name('google_button')) ?>" value="<?php echo ($google_button) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Google Play Url', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('google_url')) ?>"
                        value="<?php echo ($google_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('AppStore', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('appstore_button')) ?>"
                        value="<?php echo ($appstore_button) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('AppStore Url', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('appstore_url')) ?>"
                        value="<?php echo ($appstore_url) ?>">
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
            $instance['logo_url'] = $new_instance['logo_url'];
            $instance['heading'] = $new_instance['heading'];
            $instance['heading_two'] = $new_instance['heading_two'];
            $instance['google_button'] = $new_instance['google_button'];
            $instance['google_url'] = $new_instance['google_url'];
            $instance['appstore_button'] = $new_instance['appstore_button'];
            $instance['appstore_url'] = $new_instance['appstore_url'];
            

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
            $logo_url = isset($instance['logo_url']) ? esc_attr($instance['logo_url']) : '';
            $heading = isset($instance['heading']) ? esc_attr($instance['heading']) : '';
            $heading_two = isset($instance['heading_two']) ? esc_attr($instance['heading_two']) : '';
            $google_button = isset($instance['google_button']) ? esc_attr($instance['google_button']) : '';
            $google_url = isset($instance['google_url']) ? esc_attr($instance['google_url']) : '';
            $appstore_button = isset($instance['appstore_button']) ? esc_attr($instance['appstore_button']) : '';
            $appstore_url = isset($instance['appstore_url']) ? esc_attr($instance['appstore_url']) : '';
        

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
									<a href="<?php echo home_url(); ?>"><img src="<?php echo jobcircle_esc_the_html($logo)?>" width="224" height="62" alt="Job Circle"></a>
								</strong>
								<p><?php echo jobcircle_esc_the_html($heading)?></p>
								<p><?php echo jobcircle_esc_the_html($heading_two)?></p>
								<!-- App Buttons -->
								<ul class="app-buttons">
									<li><a href="<?php echo jobcircle_esc_the_html($google_url) ?>"><img src="<?php echo jobcircle_esc_the_html($google_button) ?>" width="218" height="67" alt="Google Play"></a></li>
									<li><a href="<?php echo jobcircle_esc_the_html($appstore_url) ?>"><img src="<?php echo jobcircle_esc_the_html($appstore_button)?>" width="218" height="67" alt="App Store"></a></li>
								</ul>
							</div>
						
            <?php

            echo ($after_widget);
        }

    }

}
add_action('widgets_init', function () {
    return register_widget("Baeetth_duis_job");
});