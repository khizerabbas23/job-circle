<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hthree_company')) {

    class hthree_company extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hthree_company',
                // Base ID.
                __('Hthree Company', 'jobcircle-frame'),
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

            $hthree_company_title = isset($instance['hthree_company_title']) ? esc_attr($instance['hthree_company_title']) : '';

            $hthree_about = isset($instance['hthree_about']) ? esc_attr($instance['hthree_about']) : '';
            $hthree_about_url = isset($instance['hthree_about_url']) ? esc_attr($instance['hthree_about_url']) : '';

            $hthree_carrer = isset($instance['hthree_carrer']) ? esc_attr($instance['hthree_carrer']) : '';
            $hthree_carrer_url = isset($instance['hthree_carrer_url']) ? esc_attr($instance['hthree_carrer_url']) : '';

            $hthree_blogs = isset($instance['hthree_blogs']) ? esc_attr($instance['hthree_blogs']) : '';
            $hthree_blogs_url = isset($instance['hthree_blogs_url']) ? esc_attr($instance['hthree_blogs_url']) : '';

            $hthree_faqs = isset($instance['hthree_faqs']) ? esc_attr($instance['hthree_faqs']) : '';
            $hthree_faqs_url = isset($instance['hthree_faqs_url']) ? esc_attr($instance['hthree_faqs_url']) : '';

            $hthree_contact = isset($instance['hthree_contact']) ? esc_attr($instance['hthree_contact']) : '';
            $hthree_contact_url = isset($instance['hthree_contact_url']) ? esc_attr($instance['hthree_contact_url']) : '';

            ?>

            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Comapny Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_company_title')) ?>"
                        value="<?php echo ($hthree_company_title) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('About', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_about')) ?>"
                        value="<?php echo ($hthree_about) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('About URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_about_url')) ?>"
                        value="<?php echo ($hthree_about_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Carrer', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_carrer')) ?>"
                        value="<?php echo ($hthree_carrer) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Carrer URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_carrer_url')) ?>"
                        value="<?php echo ($hthree_carrer_url) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Blogs', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_blogs')) ?>"
                        value="<?php echo ($hthree_blogs) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Blogs URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_blogs_url')) ?>"
                        value="<?php echo ($hthree_blogs_url) ?>">
                </p>
                
                <p>
                    <label>
                        <?php esc_html_e('FAQS', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_faqs')) ?>"
                        value="<?php echo ($hthree_faqs) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('FAQS URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_faqs_url')) ?>"
                        value="<?php echo ($hthree_faqs_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Contact', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_contact')) ?>"
                        value="<?php echo ($hthree_contact) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Contact URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_contact_url')) ?>"
                        value="<?php echo ($hthree_contact_url) ?>">
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
            $instance['hthree_company_title'] = $new_instance['hthree_company_title'];

            $instance['hthree_about'] = $new_instance['hthree_about'];
            $instance['hthree_about_url'] = $new_instance['hthree_about_url'];

            $instance['hthree_carrer'] = $new_instance['hthree_carrer'];
            $instance['hthree_carrer_url'] = $new_instance['hthree_carrer_url'];


            $instance['hthree_blogs'] = $new_instance['hthree_blogs'];
            $instance['hthree_blogs_url'] = $new_instance['hthree_blogs_url'];

            $instance['hthree_faqs'] = $new_instance['hthree_faqs'];
            $instance['hthree_faqs_url'] = $new_instance['hthree_faqs_url'];

            $instance['hthree_contact'] = $new_instance['hthree_contact'];
            $instance['hthree_contact_url'] = $new_instance['hthree_contact_url'];


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

            $hthree_company_title = isset($instance['hthree_company_title']) ? esc_attr($instance['hthree_company_title']) : '';
            $hthree_about = isset($instance['hthree_about']) ? esc_attr($instance['hthree_about']) : '';
            $hthree_about_url = isset($instance['hthree_about_url']) ? esc_attr($instance['hthree_about_url']) : '';

            $hthree_carrer = isset($instance['hthree_carrer']) ? esc_attr($instance['hthree_carrer']) : '';
            $hthree_carrer_url = isset($instance['hthree_carrer_url']) ? esc_attr($instance['hthree_carrer_url']) : '';

            $hthree_blogs = isset($instance['hthree_blogs']) ? esc_attr($instance['hthree_blogs']) : '';
            $hthree_blogs_url = isset($instance['hthree_blogs_url']) ? esc_attr($instance['hthree_blogs_url']) : '';

            $hthree_faqs = isset($instance['hthree_faqs']) ? esc_attr($instance['hthree_faqs']) : '';
            $hthree_faqs_url = isset($instance['hthree_faqs_url']) ? esc_attr($instance['hthree_faqs_url']) : '';

            $hthree_contact = isset($instance['hthree_contact']) ? esc_attr($instance['hthree_contact']) : '';
            $hthree_contact_url = isset($instance['hthree_contact_url']) ? esc_attr($instance['hthree_contact_url']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>
                          
							<h5><?php echo esc_html($hthree_company_title);?></h5>
									<ul class="footer-links">
										<li><a href="<?php echo esc_html($hthree_about_url);?>"><?php echo esc_html($hthree_about);?></a></li>
										<li><a href="<?php echo esc_html($hthree_carrer_url);?>"><?php echo esc_html($hthree_carrer_url);?></a></li>
										<li><a href="<?php echo esc_html($hthree_blogs_url);?>"><?php echo esc_html($hthree_blogs);?></a></li>
										<li><a href="<?php echo esc_html($hthree_faqs_url);?>"><?php echo esc_html($hthree_faqs);?></a></li>
										<li><a href="<?php echo esc_html($hthree_contact_url);?>"><?php echo esc_html($hthree_contact);?></a></li>
									</ul>
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hthree_company");
});