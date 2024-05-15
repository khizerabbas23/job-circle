<?php
/*
 * widget for about us in footer
 */
if (!class_exists('jobcircle_candidate_theme')) {

    class jobcircle_candidate_theme extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jobcircle_candidate_theme',
                // Base ID.
                __('Candidate Detail Page Sidebar Widget', 'jobcircle-frame'),
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

            $image = isset($instance['image']) ? esc_attr($instance['image']) : '';
            $titl = isset($instance['titl']) ? esc_attr($instance['titl']) : '';
            $designation = isset($instance['designation']) ? esc_attr($instance['designation']) : '';
            $employ = isset($instance['employ']) ? esc_attr($instance['employ']) : '';
            $salary = isset($instance['salary']) ? esc_attr($instance['salary']) : '';
            $btn_txt = isset($instance['btn_txt']) ? esc_attr($instance['btn_txt']) : '';



            ?>


            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Enter The Image Path', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('image')) ?>"
                        value="<?php echo ($image) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('titl')) ?>"
                        value="<?php echo ($titl) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter Designation', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('designation')) ?>"
                        value="<?php echo ($designation) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Enter Employe Text', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('employ')) ?>"
                        value="<?php echo ($employ) ?>">
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Enter Salary Text', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('salary')) ?>"
                        value="<?php echo ($salary) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Button Text', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('btn_txt')) ?>"
                        value="<?php echo ($btn_txt) ?>">
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
            $instance['image'] = $new_instance['image'];
            $instance['titl'] = $new_instance['titl'];
            $instance['designation'] = $new_instance['designation'];
            $instance['employ'] = $new_instance['employ'];
            $instance['salary'] = $new_instance['salary'];
            $instance['btn_txt'] = $new_instance['btn_txt'];



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
            $titl = isset($instance['titl']) ? esc_attr($instance['titl']) : '';
            $designation = isset($instance['designation']) ? esc_attr($instance['designation']) : '';
            $employ = isset($instance['employ']) ? esc_attr($instance['employ']) : '';
            $salary = isset($instance['salary']) ? esc_attr($instance['salary']) : '';
            $btn_txt = isset($instance['btn_txt']) ? esc_attr($instance['btn_txt']) : '';


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);
            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }
            ?>    
							<div class="company-info-head">
									<div class="company-logo">
										<img src="<?php echo esc_url_raw($image)?>" width="108" height="108" alt="Develpersoft">
									</div>
									<div class="textbox">
										<h4><?php echo esc_html($titl)?></h4>
										<p><?php echo esc_html($designation)?></p>
										<p><?php echo esc_html($employ)?></p>
										<p><?php echo esc_html($salary)?></p>
										<div class="btn-wrap pt-15 pb-25">
											<a href="#" class="btn btn-green btn-sm"><span class="btn-text"><?php echo esc_html($btn_txt)?></span></a>
										</div>
									</div>
								</div>
						
            <?php
            echo ($after_widget);
        }
    }
}
add_action('widgets_init', function () {
    return register_widget("jobcircle_candidate_theme");
});