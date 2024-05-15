<?php
/*
 * widget for about us in footer
 */
if (!class_exists('jc_footer_widget_info')) {

    class jc_footer_widget_info extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jc_footer_widget_info',
                // jobcircle ID.
                __('Jobcircle Info Hnine', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_info', 'description' => __('Footer Information', 'jobcircle-frame'))
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

            $image = isset($instance['image']) ? esc_attr($instance['image']) : '';
            $user_name = isset($instance['user_name']) ? esc_attr($instance['user_name']) : '';
            $phone_num = isset($instance['phone_num']) ? esc_attr($instance['phone_num']) : '';
            $address = isset($instance['address']) ? esc_attr($instance['address']) : '';

            ?>

            <div class="col-12 col-lg-4">
                <div class="jobcircle-frame-element-field text-widget-fields">
                    <p>
                        <label>
                            <?php esc_html_e('Enter Footer Job circle', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('image')) ?>" value="<?php echo ($image) ?>">
                    </p>

                    <p>
                        <label>
                            <?php esc_html_e('Enter Footer User name', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('user_name')) ?>"
                            value="<?php echo ($user_name) ?>">
                    </p>

                    <p>
                        <label>
                            <?php esc_html_e('Enter Phone number', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('phone_num')) ?>"
                            value="<?php echo ($phone_num) ?>">
                    </p>
                    <p>
                        <label>
                            <?php esc_html_e('Enter Address', 'jobcircle-frame') ?>
                        </label>
                        <input type="text" name="<?php echo ($this->get_field_name('address')) ?>" value="<?php echo ($address) ?>">
                    </p>




                </div>
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
            $instance['image'] = $new_instance['image'];
            $instance['user_name'] = $new_instance['user_name'];
            $instance['phone_num'] = $new_instance['phone_num'];
            $instance['address'] = $new_instance['address'];



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

            $image = isset($instance['image']) ? esc_attr($instance['image']) : '';
            $user_name = isset($instance['user_name']) ? esc_attr($instance['user_name']) : '';
            $phone_num = isset($instance['phone_num']) ? esc_attr($instance['phone_num']) : '';
            $address = isset($instance['address']) ? esc_attr($instance['address']) : '';



            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);

            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>

            <div class="contact_info_holder">
                <div class="footer-logo">
                    <img src="<?php echo esc_url_raw($image) ?>" alt="logo">
                </div>
                <ul class="contact-info-list">
                    <li>
                        <strong class="left-title">
                            <?php esc_html_e('Email:', 'jobcircle-frame') ?>
                        </strong>
                        <span class="sub-text"><a
                                href="<?php esc_html_e('mailto:', 'jobcircle-frame') ?><?php echo esc_html_e($user_name) ?>">
                                <?php echo esc_html_e($user_name) ?>
                            </a></span>
                    </li>
                    <li>
                        <strong class="left-title">
                            <?php esc_html_e('Phone:', 'jobcircle-frame') ?>
                        </strong>
                        <span class="sub-text"><a href="<?php esc_html_e('tel:', 'jobcircle-frame') ?><?php echo jobcircle_esc_the_html($phone_num) ?>">
                                <?php echo jobcircle_esc_the_html($phone_num) ?>
                            </a></span>
                    </li>
                    <li>
                        <strong class="left-title">
                            <?php esc_html_e('Location:', 'jobcircle-frame') ?>
                        </strong>
                        <span class="sub-text">
                            <?php echo jobcircle_esc_the_html($address) ?>
                        </span>
                    </li>
                </ul>
            </div>
            <?php

            echo jobcircle_esc_the_html($after_widget);
        }

    }

}
add_action('widgets_init', function () {
    return register_widget("jc_footer_widget_info");
});