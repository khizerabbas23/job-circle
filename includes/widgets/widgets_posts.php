<?php
/*
 * widget for about us in footer
 */
if (!class_exists('jc_widgets_posts')) {

    class jc_widgets_posts extends WP_Widget
    {
        /**
         * Sets up a new base-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jc_widgets_posts',
                // Base ID.
                __('Widgets Posts', 'base-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Blog details Widgets Posts.', 'base-frame'))
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

            $image = isset($instance['image']) ? esc_attr($instance['image']) : '';
            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';

            $posts_per_page = isset($instance['posts_per_page']) ? esc_attr($instance['posts_per_page']) : '';


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
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;
            $instance['post_heading'] = $new_instance['post_heading'];
            $instance['posts_per_page'] = $new_instance['posts_per_page'];
            $instance['terms'] = $new_instance['terms'];



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

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';
            $posts_per_page = isset($instance['posts_per_page']) ? esc_attr($instance['posts_per_page']) : '';
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
             <div class="sidebar"> 
                        <div class="widget_recent_posts widget">
                        <?php if(!empty($post_heading)){
                                    ?>
						   			<h4 class="h5"><?php echo esc_html($post_heading) ?></h4>
                                <?php
                                }
                                ?>
								<ul class="recent-posts">
                    <?php

                    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                    $categoryid = isset($atts['categoryid']) ? $atts['categoryid'] : '';
                    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

                    $args = array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'posts_per_page' => $posts_per_page,
                        'order' => 'DESC',
                        'orderby' => $orderby,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
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
                            $title = get_the_title($postid);
                            $permalinkget = get_the_permalink($postid);
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                            $posted = get_the_time('U');
                                $timeago =  human_time_diff($posted,current_time( 'U' )). "";
                            ?>
                                    <li>
										<div class="thumbnail">
                                        <?php if(!empty($permalinkget || $image) ){
                                    ?>
								<a href="<?php echo esc_html($permalinkget) ?>">
												<img src="<?php echo esc_url_raw($image[0]) ?>" width="66" height="66" alt="Aliquam ac orci nec mauris tristique pharetra">
											</a>
                                <?php
                                }
                                ?>
											
										</div>
										<div class="textbox">
                                        <?php if(!empty($permalinkget || $title) ){
                                    ?>
								<strong class="title"><a href="<?php echo esc_html($permalinkget) ?>"><?php echo esc_html($title) ?></a></strong>
                                <?php
                                }
                                ?>
									 <?php if(!empty($timeago)){
                                    ?>
						   <span class="date"><i class="jobcircle-icon-clock"></i> <span><?php echo esc_html($timeago) ?></span></span>
                                <?php
                                }
                                ?>		
											
										</div>
									</li>
                            <?php
                        }
                    }
                    // Restore original post data.
                    wp_reset_postdata();
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
    return register_widget("jc_widgets_posts");
});