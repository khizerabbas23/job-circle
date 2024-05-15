<?php
/*
 * widget for about us in footer
 */
if (!class_exists('js_twitter_feeds')) {

    class js_twitter_feeds extends WP_Widget
    {
        /**
         * Sets up a new base-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'js_twitter_feeds',
                // Base ID.
                __('Twitter Feeds', 'base-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('widgets Twitter Feeds', 'base-frame'))
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

            $search_heading = isset($instance['search_heading']) ? esc_attr($instance['search_heading']) : '';
           
            ?>


            <div class="base-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Search Heading', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('search_heading')) ?>"
                        value="<?php echo ($search_heading) ?>">
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
            $instance['search_heading'] = $new_instance['search_heading'];            
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
        
            $search_heading = isset($instance['search_heading']) ? esc_attr($instance['search_heading']) : '';
        
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';
        
            // Define and populate $lm_team_list with your Twitter feeds or content
            $lm_team_list = array(
                array(
                    'content' => 'Tweet content 1',
                    'link' => 'https://example.com/tweet1',
                ),
                array(
                    'content' => 'Tweet content 2',
                    'link' => 'https://example.com/tweet2',
                ),
                // Add more items as needed
            );
        
            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?> 
            <div class="sidebar"> 
            <div class="widget widget_recent_tweets">
                <h4 class="h5">Twitter Feed</h4>
                <div class="tweets-slider">
                    <?php
                    foreach ($lm_team_list as $key => $value) {
                        ?>
                        <div class="slick-slide">
                            <div class="recent-tweets">
                                <span class="icon">
                                    <i class="jobcircle-icon-twitter"></i>
                                </span>
                                <div class="textbox">
                                    <p><?php echo esc_html($value['content']); ?> <a href="<?php echo esc_url($value['link']); ?>"><?php echo esc_html($value['link']); ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            </div>
            <?php
            echo ($after_widget);
        }
        
    }
}
add_action('widgets_init', function () {
    return register_widget("js_twitter_feeds");
});