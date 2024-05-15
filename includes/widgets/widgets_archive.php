<?php
/*
 * Widget for About Us in Footer
 */
if (!class_exists('jc_archives')) {

    class jc_archives extends WP_Widget
    {
        /**
         * Sets up a new base-frame widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jc_archives',
                // Base ID.
                __('JobCircle Archives', 'base-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Jobcircle Widgets Archive.', 'base-frame'))
            );
        }

        /**
         * Outputs the base-frame widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $base_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';
            $number_of_categories = isset($instance['number_of_post']) ? esc_attr($instance['number_of_post']) : '';


            ?>


            <div class="base-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Post Heading', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('post_heading')) ?>"
                           value="<?php echo ($post_heading) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Number Of Categories', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('number_of_post')) ?>"
                           value="<?php echo ($number_of_categories) ?>">
                </p>
            </div>

            <?php
        }

        /**
         * Handles updating settings for the current base-frame widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;
            $instance['post_heading'] = $new_instance['post_heading'];
            $instance['number_of_post'] = $new_instance['number_of_post'];
            return $instance;
        }

        /**
         * Outputs the content for the current base-frame widget instance.
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

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';
            $number_of_categories = isset($instance['number_of_post']) ? esc_attr($instance['number_of_post']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);

            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }

            ?>
            <div class="sidebar"> 
                <div class="widget widget_archive">
                <?php if(!empty($post_heading)){
                                    ?>
						  		<h4 class="h5"><?php echo esc_html($post_heading) ?></h4>
                                <?php
                                }
                                ?>
								<ul>
                    <?php
                    $args = array(
                        'type' => 'monthly',    // Display monthly archives
                        'limit' => $number_of_categories,  // Limit the number of months to display
                        'show_post_count' => true,  // Show the number of posts in each month
                    );

                    $archives = wp_get_archives($args);
                    if (!empty($archives)) {
                        $archives = explode('</li> <a href="#">', $archives);
                        $archives = array_filter($archives);
                        foreach ($archives as $archive) {
                            $archive = str_replace('icon icon-folder', '', $archive);
                            $archive = str_replace('num', 'num hidden-xs', $archive);
                            echo jobcircle_esc_the_html($archive) . ' </a> </li>';
                        }
                    }
                    ?>
                    </ul>
					</div>
					</div>
            <?php

            echo ($after_widget);
        }
    }
}

add_action('widgets_init', function () {
    return register_widget("jc_archives");
});