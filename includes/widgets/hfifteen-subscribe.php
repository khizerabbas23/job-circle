<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hfifteen_jobcircle_subscribe')) {

    class hfifteen_jobcircle_subscribe extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hfifteen_jobcircle_subscribe',
                // jobcircle ID.
                __('Hfifteen Jbocircle Subscribe', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('Contact Us Checking', 'jobcircle-frame'))
            );
        }

        /**
         * Outputs the jobcircle-frame   widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $jobcircle_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

            $upload_image = isset($instance['upload_image']) ? esc_attr($instance['upload_image']) : '';
            $subscribe_tag = isset($instance['subscribe_tag']) ? esc_attr($instance['subscribe_tag']) : '';
            $subscribe_label = isset($instance['subscribe_label']) ? esc_attr($instance['subscribe_label']) : '';
            $facebook_url = isset($instance['facebook_url']) ? esc_attr($instance['facebook_url']) : '';
            $youtube_url = isset($instance['youtube_url']) ? esc_attr($instance['youtube_url']) : '';
            $instagram_url = isset($instance['instagram_url']) ? esc_attr($instance['instagram_url']) : '';
            $twitter_url = isset($instance['twitter_url']) ? esc_attr($instance['twitter_url']) : '';
            $form_id = isset($instance['form_id']) ? esc_attr($instance['form_id']) : '';
            $form_head = isset($instance['form_head']) ? esc_attr($instance['form_head']) : '';
            ?>


    <div class="jobcircle-frame-element-field text-widget-fields">
        <p>
            <label>
                <?php esc_html_e('Upload Image Url', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('upload_image')) ?>" value="<?php echo ($upload_image) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Jobcircle Subscribe Tag', 'jobcircle-frame') ?>
            </label>
            <input type="textfield" name="<?php echo ($this->get_field_name('subscribe_tag')) ?>" value="<?php echo ($subscribe_tag) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Jobcircle Subscribe Label', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('subscribe_label')) ?>" value="<?php echo ($subscribe_label) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Jobcircle Facebook Url', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('facebook_url')) ?>" value="<?php echo ($facebook_url) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Jobcircle Youtube Url', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('youtube_url')) ?>" value="<?php echo ($youtube_url) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Jobcircle Instagram Url', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('instagram_url')) ?>" value="<?php echo ($instagram_url) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Jobcircle Twitter Url', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('twitter_url')) ?>" value="<?php echo ($twitter_url) ?>">
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
            $instance['upload_image'] = $new_instance['upload_image'];
            $instance['subscribe_tag'] = $new_instance['subscribe_tag'];
            $instance['subscribe_label'] = $new_instance['subscribe_label'];
            $instance['facebook_url'] = $new_instance['facebook_url'];
            $instance['youtube_url'] = $new_instance['youtube_url'];
            $instance['instagram_url'] = $new_instance['instagram_url'];
            $instance['twitter_url'] = $new_instance['twitter_url'];
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

            $upload_image = isset($instance['upload_image']) ? esc_attr($instance['upload_image']) : '';            
            $subscribe_tag = isset($instance['subscribe_tag']) ? esc_attr($instance['subscribe_tag']) : '';
            $subscribe_label = isset($instance['subscribe_label']) ? esc_attr($instance['subscribe_label']) : '';
            $facebook_url = isset($instance['facebook_url']) ? esc_attr($instance['facebook_url']) : '';
            $youtube_url = isset($instance['youtube_url']) ? esc_attr($instance['youtube_url']) : '';
            $instagram_url = isset($instance['instagram_url']) ? esc_attr($instance['instagram_url']) : '';
            $twitter_url = isset($instance['twitter_url']) ? esc_attr($instance['twitter_url']) : '';
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
            
        <div class="subscription-holder">
            
            <div>
                <img class="icon" src="<?php echo jobcircle_esc_the_html($upload_image); ?>" alt="icon">
                <p class="lead"><?php echo jobcircle_esc_the_html($subscribe_tag); ?></p>
                
                    <?php
                    echo do_shortcode('[contact-form-7 id="' . esc_html($form_id) . '" title="' . esc_html($form_head) . '"]');
                    ?>
                
            </div>
            
            
            <ul class="list-inline social-networks">
                <li><a href="<?php echo jobcircle_esc_the_html($facebook_url); ?>"><i class="jobcircle-icon-facebook-with-circle"></i></a></li>
                <li><a href="<?php echo jobcircle_esc_the_html($youtube_url); ?>"><i class="jobcircle-icon-youtube"></i></a></li>
                <li><a href="<?php echo jobcircle_esc_the_html($instagram_url); ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                <li><a href="<?php echo jobcircle_esc_the_html($twitter_url); ?>"><i class="jobcircle-icon-twitter"></i></a></li>
            </ul>
        </div>
				
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hfifteen_jobcircle_subscribe");
});