<?php
/*
 * widget for about us in footer
 */
if (!class_exists('Jobcircle_instagram_gallery_widget')) {

    class Jobcircle_instagram_gallery_widget extends WP_Widget
    {
        /**
         * Sets up a new base-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'Jobcircle_instagram_gallery_widget',
                // Base ID.
                __('INSTAGRAM GALLERY', 'base-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Instagram gallery is here.', 'base-frame'))
            );
        }

        /**
         * Outputs the base-frame   widget settings form.
         *
         * @param array //$instance Current settings.
         */
        function form($instance)
        {

            global $base_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';
            $posts_per_page = isset($instance['posts_per_page']) ? esc_attr($instance['posts_per_page']) : '';
            $taxonomy = isset($instance['taxonomy']) ? esc_attr($instance['taxonomy']) : '';
            $terms = isset($instance['terms']) ? esc_attr($instance['terms']) : '';


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
                        <?php esc_html_e('Number Of Post', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('posts_per_page')) ?>"
                        value="<?php echo ($posts_per_page) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Taxonomy', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('taxonomy')) ?>" value="<?php echo ($taxonomy) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Terms', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('terms')) ?>" value="<?php echo ($terms) ?>">
                </p>

            </div>

            <?php
        }

        /**
         * Handles updating settings for the current base-frame   widget instance.
         *
         * @param array //$new_instance New settings for this instance as input by the user.
         * @param array // $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;
            $instance['post_heading'] = $new_instance['post_heading'];

            $instance['posts_per_page'] = $new_instance['posts_per_page'];

            $instance['taxonomy'] = $new_instance['taxonomy'];

            $instance['terms'] = $new_instance['terms'];



            return $instance;
        }

        /**
         * Outputs the content for the current base-frame   widget instance.
         *
         * @param array /$args Display arguments including 'before_title', 'after_title',
         * 'before_widget', and 'after_widget'.
         * @param array /$instance Settings for the current Text widget instance.
         */
        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';
            $posts_per_page = isset($instance['posts_per_page']) ? esc_attr($instance['posts_per_page']) : '';
            $taxonomy = isset($instance['taxonomy']) ? esc_attr($instance['taxonomy']) : '';
            $terms = isset($instance['terms']) ? esc_attr($instance['terms']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);

            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>
            <h5>
                <?php echo jobcircle_esc_the_html($post_heading) ?>
            </h5>
            <div class="insta-bosex">
                
                    <?php

                    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                    $categoryid = isset($atts['categoryid']) ? $atts['categoryid'] : '';
                    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';




                    $args = array(
                        'post_type' => $posttypename,
                        'post_status' => 'publish',
                        'posts_per_page' => $posts_per_page,
                        'order' => 'DESC',
                        'orderby' => $orderby,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field' => 'slug',
                                'terms' => array($terms)
                            )
                        )


                    );


                    $query = new WP_Query($args);


                    // Check that we have query results.
                    if ($query->have_posts()) {

                        // Start looping over the query results.
                        while ($query->have_posts()) {
                            $query->the_post();
                            global $post;
                            $postid = $post->ID;
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                            ?>

                            <!---->
                            <div class="insta-item">
                            <a href="<?php echo jobcircle_esc_the_html($image) ?>">
                                <span class="plus">
                                    <?php esc_html_e('+', 'jobcircle-frame') ?>
                                </span>
                                <img src="<?php echo jobcircle_esc_the_html($image[0]) ?>" alt="image">
                            </a>
                            </div>

                            <?php

                        }

                    }

                    // Restore original post data.
                    wp_reset_postdata();

                    ?>
                
                </div>


                <?php

                echo ($after_widget);
        }

    }

}
add_action('widgets_init', function () {
    return register_widget("Jobcircle_instagram_gallery_widget");
});