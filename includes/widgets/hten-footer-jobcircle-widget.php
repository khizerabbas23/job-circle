<?php
/*
 * widget for about us in footer
 */
if (!class_exists('Jobcircle_footer_home_ten')) {

    class Jobcircle_footer_home_ten extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'Jobcircle_footer_home_ten',
                // jobcircle ID.
                __('JOBCIRCLE FOOTER HTEN', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_home_ten', 'description' => __('Jobcircle Footer', 'jobcircle-frame'))
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

            $img = isset($instance['img']) ? esc_attr($instance['img']) : '';
            $desc = isset($instance['desc']) ? esc_attr($instance['desc']) : '';
            $icn_img = isset($instance['icn_img']) ? esc_attr($instance['icn_img']) : '';
            $adress = isset($instance['adress']) ? esc_attr($instance['adress']) : '';
            $phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';

        
?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Logo', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('img')) ?>" value="<?php echo ($img) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Description', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('desc')) ?>" value="<?php echo ($desc) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Pin Icon', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('icn_img')) ?>" value="<?php echo ($icn_img) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Address', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('adress')) ?>" value="<?php echo ($adress) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Phone Number', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('phone')) ?>" value="<?php echo ($phone) ?>">
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
            $instance['img'] = $new_instance['img'];
            $instance['desc'] = $new_instance['desc'];
            $instance['adress'] = $new_instance['adress'];
            $instance['phone'] = $new_instance['phone'];
            $instance['icn_img'] = $new_instance['icn_img'];

            
            


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


            $img = isset($instance['img']) ? esc_attr($instance['img']) : '';
            $desc = isset($instance['desc']) ? esc_attr($instance['desc']) : '';
            $adress = isset($instance['adress']) ? esc_attr($instance['adress']) : ''; 
            $phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';      
            $icn_img = isset($instance['icn_img']) ? esc_attr($instance['icn_img']) : '';      


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);

            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
        ?>
	
							
    <div class="contact-info-box">
								<strong class="logo d-none d-lg-block">
									<a href="<?php echo home_url(); ?>">
										<img src="<?php echo jobcircle_esc_the_html($img) ?>" width="175" height="45" alt="Job Circle">
									</a>
								</strong>
								<p><?php echo esc_html($desc) ?></p>
								<address>
									<img class="icon" src="<?php echo jobcircle_esc_the_html($icn_img) ?>" alt="location pin">
									<p><?php echo esc_html($adress) ?></p>
									<strong class="phone">
										<a href="tel:<?php echo esc_html($phone) ?>"><?php echo esc_html($phone) ?></a>
									</strong>
								</address>
							</div>
						
						

<?php

            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("Jobcircle_footer_home_ten");
});