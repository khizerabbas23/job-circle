<?php
/*
 * widget for about us in footer
 */
if (!class_exists('jobcircle_blog_meta')) {

    class jobcircle_blog_meta extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jobcircle_blog_meta',
                // Base ID.
                __('Blog Meta', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_newsletter', 'description' => __('Blog Page Meta', 'jobcircle-frame'))
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

            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            $login_url = isset($instance['login_url']) ? esc_attr($instance['login_url']) : '';
            $entires_feeds = isset($instance['entires_feeds']) ? esc_attr($instance['entires_feeds']) : '';
            $comments_feeds = isset($instance['comments_feeds']) ? esc_attr($instance['comments_feeds']) : '';
            $wordpress_org = isset($instance['wordpress_org']) ? esc_attr($instance['wordpress_org']) : '';


            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('title')) ?>"
                        value="<?php echo ($title) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Login Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('login_url')) ?>"
                        value="<?php echo ($login_url) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Entries feed Url', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('entires_feeds')) ?>"
                        value="<?php echo ($entires_feeds) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Comments Feeds', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('comments_feeds')) ?>" value="<?php echo ($comments_feeds) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Wordpress.Org Url ', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('wordpress_org')) ?>" value="<?php echo ($wordpress_org) ?>">
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
            $instance['title'] = $new_instance['title'];
            $instance['login_url'] = $new_instance['login_url'];
            $instance['entires_feeds'] = $new_instance['entires_feeds'];
            $instance['comments_feeds'] = $new_instance['comments_feeds'];
            $instance['wordpress_org'] = $new_instance['wordpress_org'];

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

            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            $login_url = isset($instance['login_url']) ? esc_attr($instance['login_url']) : '';
            $entires_feeds = isset($instance['entires_feeds']) ? esc_attr($instance['entires_feeds']) : '';
            $comments_feeds = isset($instance['comments_feeds']) ? esc_attr($instance['comments_feeds']) : '';
            $wordpress_org = isset($instance['wordpress_org']) ? esc_attr($instance['wordpress_org']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            // if ('' !== $title) {
            //     echo ($before_title) . esc_html($title) . ($after_title);
            // }
            ?>
<div class="sidebar sidebar-theme-1">
    <div class="widget widget_meta widmarn">
								<h4 class="h5"><?php echo esc_html( $title) ?></h4>
								<ul>
									<li><a  class="user-link" data-bs-toggle="modal" data-bs-target="#login" ><?php esc_html_e('Log in', 'jobcircle-frame') ?></a></li>
									<li><a href="<?php echo esc_html( $entires_feeds) ?>"><?php esc_html_e('Entries feed', 'jobcircle-frame') ?></a></li>
									<li><a href="<?php echo esc_html( $comments_feeds) ?>"><?php esc_html_e('Comments feed', 'jobcircle-frame') ?></a></li>
									<li><a href="<?php echo esc_html( $wordpress_org) ?>"><?php esc_html_e('WordPress.org', 'jobcircle-frame') ?></a></li>
								</ul>
							</div></div>
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("jobcircle_blog_meta");
});