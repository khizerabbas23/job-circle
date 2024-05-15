<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hthree_candidates')) {

    class hthree_candidates extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hthree_candidates',
                // Base ID.
                __('Hthree Candidates', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Candidates Checking', 'jobcircle-frame'))
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

            $hthree_candidates_title = isset($instance['hthree_candidates_title']) ? esc_attr($instance['hthree_candidates_title']) : '';

            $hthree_browse = isset($instance['hthree_browse']) ? esc_attr($instance['hthree_browse']) : '';
            $hthree_browse_url = isset($instance['hthree_browse_url']) ? esc_attr($instance['hthree_browse_url']) : '';

            $hthree_categorry = isset($instance['hthree_categorry']) ? esc_attr($instance['hthree_categorry']) : '';
            $hthree_categorry_url = isset($instance['hthree_categorry_url']) ? esc_attr($instance['hthree_categorry_url']) : '';

            $hthree_dashboard = isset($instance['hthree_dashboard']) ? esc_attr($instance['hthree_dashboard']) : '';
            $hthree_dashboard_url = isset($instance['hthree_dashboard_url']) ? esc_attr($instance['hthree_dashboard_url']) : '';

            $hthree_alerts = isset($instance['hthree_alerts']) ? esc_attr($instance['hthree_alerts']) : '';
            $hthree_alerts_url = isset($instance['hthree_alerts_url']) ? esc_attr($instance['hthree_alerts_url']) : '';

            $hthree_bookmark = isset($instance['hthree_bookmark']) ? esc_attr($instance['hthree_bookmark']) : '';
            $hthree_bookmark_url = isset($instance['hthree_bookmark_url']) ? esc_attr($instance['hthree_bookmark_url']) : '';

            ?>

            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Comapny Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_candidates_title')) ?>"
                        value="<?php echo ($hthree_candidates_title) ?>">
                </p>
    
                <p>
                    <label>
                        <?php esc_html_e('Browse Jobs', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_browse')) ?>"
                        value="<?php echo ($hthree_browse) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Browse URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_browse_url')) ?>"
                        value="<?php echo ($hthree_browse_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Browse Categories', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_categorry')) ?>"
                        value="<?php echo ($hthree_categorry) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Categories URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_categorry_url')) ?>"
                        value="<?php echo ($hthree_categorry_url) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Dashboard', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_dashboard')) ?>"
                        value="<?php echo ($hthree_dashboard) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Dashboard URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_dashboard_url')) ?>"
                        value="<?php echo ($hthree_bhthree_dashboard_urllogs) ?>">
                </p>
                
                <p>
                    <label>
                        <?php esc_html_e('Job Alerts', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_alerts')) ?>"
                        value="<?php echo ($hthree_alerts) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Alerts URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_alerts_url')) ?>"
                        value="<?php echo ($hthree_alerts_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Mu BookMark', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_bookmark')) ?>"
                        value="<?php echo ($hthree_bookmark) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Bookmark URL', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('hthree_bookmark_url')) ?>"
                        value="<?php echo ($hthree_bookmark_url) ?>">
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
            $instance['hthree_candidates_title'] = $new_instance['hthree_candidates_title'];

            $instance['hthree_browse'] = $new_instance['hthree_browse'];
            $instance['hthree_browse_url'] = $new_instance['hthree_browse_url'];

            $instance['hthree_categorry'] = $new_instance['hthree_categorry'];
            $instance['hthree_categorry_url'] = $new_instance['hthree_categorry_url'];

            $instance['hthree_dashboard'] = $new_instance['hthree_dashboard'];
            $instance['hthree_dashboard_url'] = $new_instance['hthree_dashboard_url'];

            $instance['hthree_alerts'] = $new_instance['hthree_alerts'];
            $instance['hthree_alerts_url'] = $new_instance['hthree_alerts_url'];

            $instance['hthree_bookmark'] = $new_instance['hthree_bookmark'];
            $instance['hthree_bookmark_url'] = $new_instance['hthree_bookmark_url'];

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

            $hthree_candidates_title = isset($instance['hthree_candidates_title']) ? esc_attr($instance['hthree_candidates_title']) : '';
            $hthree_browse = isset($instance['hthree_browse']) ? esc_attr($instance['hthree_browse']) : '';
            $hthree_browse_url = isset($instance['hthree_browse_url']) ? esc_attr($instance['hthree_browse_url']) : '';

            $hthree_categorry = isset($instance['hthree_categorry']) ? esc_attr($instance['hthree_categorry']) : '';
            $hthree_categorry_url = isset($instance['hthree_categorry_url']) ? esc_attr($instance['hthree_categorry_url']) : '';

            $hthree_dashboard = isset($instance['hthree_dashboard']) ? esc_attr($instance['hthree_dashboard']) : '';
            $hthree_dashboard_url = isset($instance['hthree_dashboard_url']) ? esc_attr($instance['hthree_dashboard_url']) : '';

            $hthree_alerts = isset($instance['hthree_alerts']) ? esc_attr($instance['hthree_alerts']) : '';
            $hthree_alerts_url = isset($instance['hthree_alerts_url']) ? esc_attr($instance['hthree_alerts_url']) : '';

            $hthree_bookmark = isset($instance['hthree_bookmark']) ? esc_attr($instance['hthree_bookmark']) : '';
            $hthree_bookmark_url = isset($instance['hthree_bookmark_url']) ? esc_attr($instance['hthree_bookmark_url']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>

									<h5><?php echo esc_html($hthree_candidates_title);?></h5>
									<ul class="footer-links">
										<li><a href="<?php echo esc_html($hthree_browse_url);?>"><?php echo esc_html($hthree_browse);?></a></li>
										<li><a href="<?php echo esc_html($hthree_categorry_url);?>"><?php echo esc_html($hthree_categorry);?></a></li>
										<li><a href="<?php echo esc_html($hthree_dashboard_url);?>"><?php echo esc_html($hthree_dashboard);?></a></li>
										<li><a href="<?php echo esc_html($hthree_alerts_url);?>"><?php echo esc_html($hthree_alerts);?></a></li>
										<li><a href="<?php echo esc_html($hthree_bookmark_url);?>"><?php echo esc_html($hthree_bookmark);?></a></li>
									</ul>

            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hthree_candidates");
});