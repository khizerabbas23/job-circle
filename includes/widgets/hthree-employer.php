<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hthree_employers')) {

    class hthree_employers extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'htree Employers',
                // Base ID.
                __('Hthree Employers', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Employer Checking', 'jobcircle-frame'))
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

            $hthree_employers_title = isset($instance['hthree_employers_title']) ? esc_attr($instance['hthree_employers_title']) : '';

            $hthree_candidates = isset($instance['hthree_candidates']) ? esc_attr($instance['hthree_candidates']) : '';
            $hthree_candidates_url = isset($instance['hthree_candidates_url']) ? esc_attr($instance['hthree_candidates_url']) : '';

            $hthree_employer  = isset($instance['hthree_employer ']) ? esc_attr($instance['hthree_employer ']) : '';
            $hthree_employer_url = isset($instance['hthree_employer _url']) ? esc_attr($instance['hthree_employer _url']) : '';

            $hthree_add_job = isset($instance['hthree_add_job']) ? esc_attr($instance['hthree_add_job']) : '';
            $hthree_add_job_url = isset($instance['hthree_add_job_url']) ? esc_attr($instance['hthree_add_job_url']) : '';

            $hthree_packages = isset($instance['hthree_packages']) ? esc_attr($instance['hthree_packages']) : '';
            $hthree_packages_url = isset($instance['hthree_packages_url']) ? esc_attr($instance['hthree_packages_url']) : '';

            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Comapny Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_employers_title')) ?>"
                        value="<?php echo ($hthree_employers_title) ?>">
                </p>  

                <p>
                    <label>
                        <?php esc_html_e('Browse Jobs', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_candidates')) ?>"
                        value="<?php echo ($hthree_candidates) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Browse URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_candidates_url')) ?>"
                        value="<?php echo ($hthree_candidates_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Browse Categories', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_employer ')) ?>"
                        value="<?php echo ($hthree_employer ) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Categories URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_employer _url')) ?>"
                        value="<?php echo ($hthree_employer_url) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Dashboard', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_add_job')) ?>"
                        value="<?php echo ($hthree_add_job) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Dashboard URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_add_job_url')) ?>"
                        value="<?php echo ($hthree_bhthree_add_job_urllogs) ?>">
                </p>
                
                <p>
                    <label>
                        <?php esc_html_e('Job Alerts', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_packages')) ?>"
                        value="<?php echo ($hthree_packages) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Alerts URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_packages_url')) ?>"
                        value="<?php echo ($hthree_packages_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Mu BookMark', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_bookmark')) ?>"
                        value="<?php echo ($hthree_bookmark) ?>">
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
            $instance['hthree_employers_title'] = $new_instance['hthree_employers_title'];

            $instance['hthree_candidates'] = $new_instance['hthree_candidates'];
            $instance['hthree_candidates_url'] = $new_instance['hthree_candidates_url'];

            $instance['hthree_employer '] = $new_instance['hthree_employer '];
            $instance['hthree_employer _url'] = $new_instance['hthree_employer _url'];


            $instance['hthree_add_job'] = $new_instance['hthree_add_job'];
            $instance['hthree_add_job_url'] = $new_instance['hthree_add_job_url'];

            $instance['hthree_packages'] = $new_instance['hthree_packages'];
            $instance['hthree_packages_url'] = $new_instance['hthree_packages_url'];

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

            $hthree_employers_title = isset($instance['hthree_employers_title']) ? esc_attr($instance['hthree_employers_title']) : '';
            $hthree_candidates = isset($instance['hthree_candidates']) ? esc_attr($instance['hthree_candidates']) : '';
            $hthree_candidates_url = isset($instance['hthree_candidates_url']) ? esc_attr($instance['hthree_candidates_url']) : '';

            $hthree_employer  = isset($instance['hthree_employer ']) ? esc_attr($instance['hthree_employer ']) : '';
            $hthree_employer_url = isset($instance['hthree_employer _url']) ? esc_attr($instance['hthree_employer _url']) : '';

            $hthree_add_job = isset($instance['hthree_add_job']) ? esc_attr($instance['hthree_add_job']) : '';
            $hthree_add_job_url = isset($instance['hthree_add_job_url']) ? esc_attr($instance['hthree_add_job_url']) : '';

            $hthree_packages = isset($instance['hthree_packages']) ? esc_attr($instance['hthree_packages']) : '';
            $hthree_packages_url = isset($instance['hthree_packages_url']) ? esc_attr($instance['hthree_packages_url']) : '';

        
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>
									<h5><?php echo esc_html($hthree_employers_title);?></h5>
									<ul class="footer-links">
										<li><a href="<?php echo esc_html($hthree_candidates_url);?>"><?php echo esc_html($hthree_candidates);?></a></li>
										<li><a href="<?php echo esc_html($hthree_candidates_url);?>"><?php echo esc_html($hthree_candidates);?></a></li>
										<li><a href="<?php echo esc_html($hthree_add_job_url);?>"><?php echo esc_html($hthree_add_job);?></a></li>
										<li><a href="<?php echo esc_html($hthree_packages_url);?>"><?php echo esc_html($hthree_packages);?></a></li>
									</ul>		

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hthree_employers");
});