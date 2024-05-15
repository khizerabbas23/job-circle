<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hthree_support')) {

    class hthree_support extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hthree_support',
                // Base ID.
                __('Hthree Support', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Support Checking', 'jobcircle-frame'))
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

            $hthree_support_title = isset($instance['hthree_support_title']) ? esc_attr($instance['hthree_support_title']) : '';

            $hthree_privcy = isset($instance['hthree_privcy']) ? esc_attr($instance['hthree_privcy']) : '';
            $hthree_privcy_url = isset($instance['hthree_privcy_url']) ? esc_attr($instance['hthree_privcy_url']) : '';

            $hthree_terms = isset($instance['hthree_terms']) ? esc_attr($instance['hthree_terms']) : '';
            $hthree_terms_url = isset($instance['hthree_terms_url']) ? esc_attr($instance['hthree_terms_url']) : '';

            $hthree_help = isset($instance['hthree_help']) ? esc_attr($instance['hthree_help']) : '';
            $hthree_help_url = isset($instance['hthree_help_url']) ? esc_attr($instance['hthree_help_url']) : '';

            $hthree_updates = isset($instance['hthree_updates']) ? esc_attr($instance['hthree_updates']) : '';
            $hthree_updates_url = isset($instance['hthree_updates_url']) ? esc_attr($instance['hthree_updates_url']) : '';

            $hthree_document = isset($instance['hthree_document']) ? esc_attr($instance['hthree_document']) : '';
            $hthree_document_url = isset($instance['hthree_document_url']) ? esc_attr($instance['hthree_document_url']) : '';


            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Support Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_support_title')) ?>"
                        value="<?php echo ($hthree_support_title) ?>">
                </p>

                
                <p>
                    <label>
                        <?php esc_html_e('Privacy', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_privcy')) ?>"
                        value="<?php echo ($hthree_privcy) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Privacy URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_privcy_url')) ?>"
                        value="<?php echo ($hthree_privcy_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Terms', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_terms')) ?>"
                        value="<?php echo ($hthree_terms) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Terms URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_terms_url')) ?>"
                        value="<?php echo ($hthree_terms_url) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Help', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_help')) ?>"
                        value="<?php echo ($hthree_help) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Help URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_help_url')) ?>"
                        value="<?php echo ($hthree_help_url) ?>">
                </p>
                
                <p>
                    <label>
                        <?php esc_html_e('Updates', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_updates')) ?>"
                        value="<?php echo ($hthree_updates) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Updates URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_updates_url')) ?>"
                        value="<?php echo ($hthree_updates_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Document', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_document')) ?>"
                        value="<?php echo ($hthree_document) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Document URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_document_url')) ?>"
                        value="<?php echo ($hthree_document_url) ?>">
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
            $instance['hthree_support_title'] = $new_instance['hthree_support_title'];

            $instance['hthree_privcy'] = $new_instance['hthree_privcy'];
            $instance['hthree_privcy_url'] = $new_instance['hthree_privcy_url'];

            $instance['hthree_terms'] = $new_instance['hthree_terms'];
            $instance['hthree_terms_url'] = $new_instance['hthree_terms_url'];


            $instance['hthree_help'] = $new_instance['hthree_help'];
            $instance['hthree_help_url'] = $new_instance['hthree_help_url'];

            $instance['hthree_updates'] = $new_instance['hthree_updates'];
            $instance['hthree_updates_url'] = $new_instance['hthree_updates_url'];

            $instance['hthree_document'] = $new_instance['hthree_document'];
            $instance['hthree_document_url'] = $new_instance['hthree_document_url'];

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

            $hthree_support_title = isset($instance['hthree_support_title']) ? esc_attr($instance['hthree_support_title']) : '';
            $hthree_privcy = isset($instance['hthree_privcy']) ? esc_attr($instance['hthree_privcy']) : '';
            $hthree_privcy_url = isset($instance['hthree_privcy_url']) ? esc_attr($instance['hthree_privcy_url']) : '';

            $hthree_terms = isset($instance['hthree_terms']) ? esc_attr($instance['hthree_terms']) : '';
            $hthree_terms_url = isset($instance['hthree_terms_url']) ? esc_attr($instance['hthree_terms_url']) : '';

            $hthree_help = isset($instance['hthree_help']) ? esc_attr($instance['hthree_help']) : '';
            $hthree_help_url = isset($instance['hthree_help_url']) ? esc_attr($instance['hthree_help_url']) : '';

            $hthree_updates = isset($instance['hthree_updates']) ? esc_attr($instance['hthree_updates']) : '';
            $hthree_updates_url = isset($instance['hthree_updates_url']) ? esc_attr($instance['hthree_updates_url']) : '';

            $hthree_document = isset($instance['hthree_document']) ? esc_attr($instance['hthree_document']) : '';
            $hthree_document_url = isset($instance['hthree_document_url']) ? esc_attr($instance['hthree_document_url']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>
                            
									<h5><?php echo esc_html($hthree_support_title);?></h5>
									<ul class="footer-links">
										<li><a href="<?php echo esc_html($hthree_privcy_url);?>"><?php echo esc_html($hthree_privcy);?></a></li>
										<li><a href="<?php echo esc_html($hthree_terms_url);?>"><?php echo esc_html($hthree_terms);?></a></li>
										<li><a href="<?php echo esc_html($hthree_help_url);?>"><?php echo esc_html($hthree_help);?></a></li>
										<li><a href="<?php echo esc_html($hthree_updates_url);?>"><?php echo esc_html($hthree_updates);?></a></li>
										<li><a href="<?php echo esc_html($hthree_document_url);?>"><?php echo esc_html($hthree_document);?></a></li>
									</ul>
								

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hthree_support");
});