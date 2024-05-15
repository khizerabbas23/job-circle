<?php
/*
 * widget for Nav Menu in footer
 */
if (!class_exists('jc_footer_sixty_menu')) {

    class jc_footer_sixty_menu extends WP_Widget
    {
        /**
         * Sets up a new jobcircle-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'jc_footer_sixty_menu',
                // Base ID.
                __('Hsixty Menu Links', 'jobcircle-frame'),
                // Name.
                array('classname' => 'widget_footer_nav', 'description' => __('Nav Menu Widget.', 'jobcircle-frame'))
            );
        }

        /**
         * Outputs the jobcircle-frame   widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $jobcircle_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));

            $title = $instance['title'];
            $nav_itm = isset($instance['nav_itm']) ? esc_attr($instance['nav_itm']) : '';
            $scnd_title = isset($instance['scnd_title']) ? esc_attr($instance['scnd_title']) : '';
            $scnd_nav_itm = isset($instance['scnd_nav_itm']) ? esc_attr($instance['scnd_nav_itm']) : '';


            $wp_menus = wp_get_nav_menus();
            ?>
            <div class="jobcircle-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('title')) ?>" value="<?php echo ($title) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Menu', 'jobcircle-frame') ?>
                    </label>
                    <select name="<?php echo ($this->get_field_name('nav_itm')) ?>">
                        <option value="">
                            <?php esc_html_e('Select Menu', 'jobcircle-frame') ?>
                        </option>
                        <?php
                        if (!empty($wp_menus)) {
                            foreach ($wp_menus as $menu_itm) {
                                ?>
                                <option value="<?php echo ($menu_itm->slug) ?>" <?php echo ($nav_itm == $menu_itm->slug ? ' selected' : '') ?>>
                                    <?php echo ($menu_itm->name) ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('2nd Title', 'jobcircle-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('scnd_title')) ?>" value="<?php echo ($scnd_title) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('2ND Menu', 'jobcircle-frame') ?>
                    </label>
                    <select name="<?php echo ($this->get_field_name('scnd_nav_itm')) ?>">
                        <option value="">
                            <?php esc_html_e('Select Menu', 'jobcircle-frame') ?>
                        </option>
                        <?php
                        if (!empty($wp_menus)) {
                            foreach ($wp_menus as $menu_itm) {
                                ?>
                                <option value="<?php echo ($menu_itm->slug) ?>" <?php echo ($scnd_nav_itm == $menu_itm->slug ? ' selected' : '') ?>>
                                    <?php echo ($menu_itm->name) ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
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
            $instance['title'] = $new_instance['title'];
            $instance['nav_itm'] = $new_instance['nav_itm'];
            $instance['scnd_title'] = $new_instance['scnd_title'];
            $instance['scnd_nav_itm'] = $new_instance['scnd_nav_itm'];
           
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
            $nav_itm = isset($instance['nav_itm']) ? esc_attr($instance['nav_itm']) : '';
            $scnd_title = isset($instance['scnd_title']) ? esc_attr($instance['scnd_title']) : '';
            $scnd_nav_itm = isset($instance['scnd_nav_itm']) ? esc_attr($instance['scnd_nav_itm']) : '';
           


            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);

            ?>

<div class="row">
										<div class="col-6">
											<h5><?php echo esc_html($title) ?></h5>
            <?php

            if ($nav_itm != '') {
                $menu_links = wp_get_nav_menu_items($nav_itm);
                //var_dump($menu_links);
                if (!empty($menu_links)) {
                    ?>

<ul class="footer-links">
                        <?php
                        foreach ($menu_links as $menu_link_itm) {
                            ?>
                            <li><a href="<?php echo ($menu_link_itm->url) ?>">
                                    <?php echo ($menu_link_itm->title) ?>
                                </a></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                }
            }
            ?>
                    </div>
                    <div class="col-6">
                    <h5><?php echo esc_html($scnd_title) ?></h5>
											
                                        <?php
                                        if ($nav_itm != '') {
                $menu_links = wp_get_nav_menu_items($scnd_nav_itm);
                //var_dump($menu_links);
                if (!empty($menu_links)) {
                    ?>
                   <ul class="footer-links">
                    <?php
                        foreach ($menu_links as $menu_link_itm) {
                            ?>
                            <li><a href="<?php echo ($menu_link_itm->url) ?>"><?php echo ($menu_link_itm->title) ?></a></li>
                            <?php
                        }
                        ?>
</ul>
<?php 
                }
            }
?>


</div>
</div>


                


            <?php

            echo ($after_widget);
        }

    }

}
add_action('widgets_init', function () {
    return register_widget("jc_footer_sixty_menu");
});