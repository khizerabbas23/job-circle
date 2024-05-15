<?php
/*
 * Widget for About Us in Footer
 */
if (!class_exists('jc_categories')) {
    class jc_categories extends WP_Widget {
        /**
         * Sets up a new base-frame widget instance.
         */
        public function __construct() {
            parent::__construct(
                'jc_categories',
                // Base ID.
                __('Custom Categories', 'base-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Blog Category', 'base-frame'))
            );
        }

        /**
         * Outputs the base-frame widget settings form.
         *
         * @param array $instance Current settings.
         */
        public function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

           

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';

            $number_of_categories = isset($instance['number_of_categories']) ? esc_attr($instance['number_of_categories']) : '';

            ?>
            <div class="base-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Post Heading', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo $this->get_field_name('post_heading'); ?>"
                        value="<?php echo jobcircle_esc_the_html($post_heading); ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Number Of Categories', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo $this->get_field_name('number_of_categories'); ?>"
                        value="<?php echo jobcircle_esc_the_html($number_of_categories); ?>">
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
        public function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['post_heading'] = $new_instance['post_heading'];
            $instance['number_of_categories'] = $new_instance['number_of_categories'];
            return $instance;
        }

        /**
         * Outputs the content for the current base-frame widget instance.
         *
         * @param array $args Display arguments including 'before_title', 'after_title',
         * 'before_widget', and 'after_widget'.
         * @param array $instance Settings for the current Text widget instance.
         */
        public function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';
            $number_of_categories = isset($instance['number_of_categories']) ? esc_attr($instance['number_of_categories']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo jobcircle_esc_the_html($before_widget);

            if ('' !== $title) {
                echo jobcircle_esc_the_html($before_title . esc_html($title) . $after_title);
            }
            ?>
<div class="sidebar"> 
            <div class="widget widget_categories">
            <?php if(!empty($post_heading)){
                                    ?>
									<h4 class="h5"><?php echo esc_html($post_heading) ?></h4>
                                <?php
                                }
                                ?>
								<ul>
                    <?php
                    $categories = get_terms([
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                    ]);
                    $counter = 0;
                    if (is_array($categories)) {
                        foreach ($categories as $category) {
                            $term_link = get_term_link($category);
                            //$posts_count = isset($category->count) ? $category->count : 0;

                            if ($counter >= 0) {
                                ?>
                               <li>
                               <?php if(!empty($term_link || $category || $category) ){
                                    ?>
								 <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($category->name); ?></a> (<?php echo $category->count ?>)
                                <?php
                                }
                                ?>
                               
                            </li>
                                <?php
                            }
                            $counter++;
                            if ($counter == $number_of_categories) {
                                break;
                            }
                        }
                    }
                    ?>
                         </ul>
							</div>
							</div>
             <?php
            echo jobcircle_esc_the_html($after_widget);
        }
    }
}

add_action('widgets_init', function () {
    register_widget("jc_categories");
});
