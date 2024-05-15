<?php
/*
 * widget for about us in footer
 */
if (!class_exists('style_two_newslater')) {

    class style_two_newslater extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'style_two_newslater',
                // Base ID.
                __('NEWSLETTER STYLE 2', 'jobcircle-frame'),
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

            $newsletter_heading = isset($instance['newsletter_heading']) ? esc_attr($instance['newsletter_heading']) : '';
            $newsletter_desc = isset($instance['newsletter_desc']) ? esc_attr($instance['newsletter_desc']) : '';
            $news_btn = isset($instance['news_btn']) ? esc_attr($instance['news_btn']) : '';
            $form_id = isset($instance['form_id']) ? esc_attr($instance['form_id']) : '';
            $form_head = isset($instance['form_head']) ? esc_attr($instance['form_head']) : '';


            ?>

            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('newsletter_heading')) ?>"
                        value="<?php echo ($newsletter_heading) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Description', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('newsletter_desc')) ?>"
                        value="<?php echo ($newsletter_desc) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Button Text', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('news_btn')) ?>" value="<?php echo ($news_btn) ?>">
                </p>
                  <p>
                    <label>
                        <?php esc_html_e('Form Id', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('form_id')) ?>" value="<?php echo ($form_id) ?>">
                </p>
                  <p>
                    <label>
                        <?php esc_html_e('Form Head', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('form_head')) ?>" value="<?php echo ($form_head) ?>">
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
            $instance['newsletter_heading'] = $new_instance['newsletter_heading'];
            $instance['newsletter_desc'] = $new_instance['newsletter_desc'];
            $instance['news_btn'] = $new_instance['news_btn'];
             $instance['form_id'] = $new_instance['form_id'];
             $instance['form_head'] = $new_instance['form_head'];

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

            $newsletter_heading = isset($instance['newsletter_heading']) ? esc_attr($instance['newsletter_heading']) : '';
            $newsletter_desc = isset($instance['newsletter_desc']) ? esc_attr($instance['newsletter_desc']) : '';
            $news_btn = isset($instance['news_btn']) ? esc_attr($instance['news_btn']) : '';
            $form_id = isset($instance['form_id']) ? esc_attr($instance['form_id']) : '';
            $form_head = isset($instance['form_head']) ? esc_attr($instance['form_head']) : '';



            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>
            <h5><?php echo jobcircle_esc_the_html($newsletter_heading) ?></h5>
            <!-- Form Subscribe -->
            <div class="footer-info">
                <div class="form-subscribe">
                    <p><?php echo jobcircle_esc_the_html($newsletter_desc) ?></p>
                    <?php
                    echo do_shortcode('[contact-form-7 id="' . esc_html($form_id) . '" title="' . esc_html($form_head) . '"]');
                    ?>
                </div>
            </div>


            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("style_two_newslater");
});