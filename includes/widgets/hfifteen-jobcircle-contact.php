<?php
/*
 * widget for about us in footer
 */
if (!class_exists('hfifteen_jobcircle_contact')) {

    class hfifteen_jobcircle_contact extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'hfifteen_jobcircle_contact',
                // jobcircle ID.
                __('Hfifteen Jbocircle Contact', 'jobcircle-frame'),
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

            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';
            $job_cntct_exp = isset($instance['job_cntct_exp']) ? esc_attr($instance['job_cntct_exp']) : '';
            $contact_tag = isset($instance['contact_tag']) ? esc_attr($instance['contact_tag']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
            $contact_address = isset($instance['contact_address']) ? esc_attr($instance['contact_address']) : '';
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';
            $copy_right_tag = isset($instance['copy_right_tag']) ? esc_attr($instance['copy_right_tag']) : '';
          
            ?>


    <div class="jobcircle-frame-element-field text-widget-fields">
        <p>
            <label>
                <?php esc_html_e('Upload Logo Url', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('logo')) ?>" value="<?php echo ($logo) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Jobcircle Logo Description', 'jobcircle-frame') ?>
            </label>
            <input type="textarea" name="<?php echo ($this->get_field_name('job_cntct_exp')) ?>" value="<?php echo ($job_cntct_exp) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Contact Us Title', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('contact_tag')) ?>" value="<?php echo ($contact_tag) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Contact Phone No.', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('contact_phone')) ?>" value="<?php echo ($contact_phone) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Contact Address', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('contact_address')) ?>" value="<?php echo ($contact_address) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Contact Email', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('contact_email')) ?>" value="<?php echo ($contact_email) ?>">
        </p>
        <p>
            <label>
                <?php esc_html_e('Copy Right Tag', 'jobcircle-frame') ?>
            </label>
            <input type="text" name="<?php echo ($this->get_field_name('copy_right_tag')) ?>" value="<?php echo ($copy_right_tag) ?>">
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
            $instance['logo'] = $new_instance['logo'];
            $instance['job_cntct_exp'] = $new_instance['job_cntct_exp'];
            $instance['contact_tag'] = $new_instance['contact_tag'];
            $instance['contact_phone'] = $new_instance['contact_phone'];
            $instance['contact_address'] = $new_instance['contact_address'];
            $instance['contact_email'] = $new_instance['contact_email'];
            $instance['copy_right_tag'] = $new_instance['copy_right_tag'];
    
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

            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';            
            $job_cntct_exp = isset($instance['job_cntct_exp']) ? esc_attr($instance['job_cntct_exp']) : '';
            $contact_tag = isset($instance['contact_tag']) ? esc_attr($instance['contact_tag']) : '';
            $contact_phone = isset($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
            $contact_address = isset($instance['contact_address']) ? esc_attr($instance['contact_address']) : '';
            $contact_email = isset($instance['contact_email']) ? esc_attr($instance['contact_email']) : '';
            $copy_right_tag = isset($instance['copy_right_tag']) ? esc_attr($instance['copy_right_tag']) : '';
           
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
   ?>         
              <div class="row">
                <div class="col-12 col-md-6">
                    <strong class="logo d-block">
                        <a href="<?php echo home_url(); ?>">
                            <img src="<?php echo jobcircle_esc_the_html($logo); ?>" width="178" height="43" alt="Job Circle">
                        </a>
                    </strong>
                    <p><?php echo jobcircle_esc_the_html($job_cntct_exp); ?></p>
                </div>
                <div class="col-12 col-md-6">
                    <h5><?php echo jobcircle_esc_the_html($contact_tag); ?></h5>
                    <ul class="contact-list">
                        <li>
                            <i class="fa-solid fa-mobile-screen"></i>
                            <span class="text"><a href="tel:<?php echo jobcircle_esc_the_html($contact_phone); ?>"><?php echo jobcircle_esc_the_html($contact_phone); ?></a></span>
                        </li>
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            <span class="text"><?php echo jobcircle_esc_the_html($contact_address); ?></span>
                        </li>
                        <li>
                            <i class="fa-regular fa-envelope-open"></i>
                            <span class="text"><a href="mailto:<?php echo jobcircle_esc_the_html($contact_email); ?>"><?php echo jobcircle_esc_the_html($contact_email); ?></a></span>
                        </li>
                    </ul>
                </div>
            </div>
            <p class="copyright"><?php echo jobcircle_esc_the_html($copy_right_tag); ?></p>
      
            <?php
            echo jobcircle_esc_the_html($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("hfifteen_jobcircle_contact");
});