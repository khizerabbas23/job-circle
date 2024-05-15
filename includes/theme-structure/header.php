<?php
add_filter('jobcircle_header_content_markup', function () {
    ob_start();
    global $jobcircle_framework_options;
    $logo = isset($jobcircle_framework_options['jobcircle-sticky-logo']['url']) ? $jobcircle_framework_options['jobcircle-sticky-logo']['url'] : '';
    $bg_logo = isset($jobcircle_framework_options['site-logo']['url']) ? $jobcircle_framework_options['site-logo']['url'] : '';
    $login_register = isset($jobcircle_framework_options['login_register']) ? $jobcircle_framework_options['login_register'] : '';
    $login_url = isset($jobcircle_framework_options['login_url']) ? $jobcircle_framework_options['login_url'] : '';
    // Style 5
    $number = isset($jobcircle_framework_options['jobcircle-header-five-number']) ? $jobcircle_framework_options['jobcircle-header-five-number'] : '';
    $insta = isset($jobcircle_framework_options['jobcircle-header-five-google']) ? $jobcircle_framework_options['jobcircle-header-five-google'] : '';
    $facebook = isset($jobcircle_framework_options['jobcircle-header-five-facebook']) ? $jobcircle_framework_options['jobcircle-header-five-facebook'] : '';
    $twitter = isset($jobcircle_framework_options['jobcircle-header-five-twitter']) ? $jobcircle_framework_options['jobcircle-header-five-twitter'] : '';
    $linkedin = isset($jobcircle_framework_options['jobcircle-header-five-linkedin']) ? $jobcircle_framework_options['jobcircle-header-five-linkedin'] : '';
    // Style 7
    $sevalert = isset($jobcircle_framework_options['jobcircle-header-seven-alert']) ? $jobcircle_framework_options['jobcircle-header-seven-alert'] : '';
    $seveml = isset($jobcircle_framework_options['jobcircle-header-seven-email']) ? $jobcircle_framework_options['jobcircle-header-seven-email'] : '';
    $sevnumb = isset($jobcircle_framework_options['jobcircle-header-seven-number']) ? $jobcircle_framework_options['jobcircle-header-seven-number'] : '';
    $sevinsta = isset($jobcircle_framework_options['jobcircle-header-seven-google']) ? $jobcircle_framework_options['jobcircle-header-seven-google'] : '';
    $sevfburl = isset($jobcircle_framework_options['jobcircle-header-seven-facebook']) ? $jobcircle_framework_options['jobcircle-header-seven-facebook'] : '';
    $sevtwturl = isset($jobcircle_framework_options['jobcircle-header-seven-twitter']) ? $jobcircle_framework_options['jobcircle-header-seven-twitter'] : '';
    $sevlnkdn = isset($jobcircle_framework_options['jobcircle-header-seven-linkedin']) ? $jobcircle_framework_options['jobcircle-header-seven-linkedin'] : '';
    // Style 13
    $thrnumb = isset($jobcircle_framework_options['jobcircle-header-thirteen-number']) ? $jobcircle_framework_options['jobcircle-header-thirteen-number'] : '';
    $thremail = isset($jobcircle_framework_options['jobcircle-header-thirteen-email']) ? $jobcircle_framework_options['jobcircle-header-thirteen-email'] : '';
    $thrfb = isset($jobcircle_framework_options['jobcircle-header-thirteen-facebook']) ? $jobcircle_framework_options['jobcircle-header-thirteen-facebook'] : '';
    $thrytb = isset($jobcircle_framework_options['jobcircle-header-thirteen-youtube']) ? $jobcircle_framework_options['jobcircle-header-thirteen-youtube'] : '';
    $thrinsta = isset($jobcircle_framework_options['jobcircle-header-thirteen-instagram']) ? $jobcircle_framework_options['jobcircle-header-thirteen-instagram'] : '';
    $thrlink = isset($jobcircle_framework_options['jobcircle-header-thirteen-linkdin']) ? $jobcircle_framework_options['jobcircle-header-thirteen-linkdin'] : '';
     // Style 17
     $sevtnalrt = isset($jobcircle_framework_options['jobcircle-header-seventeen-alert']) ? $jobcircle_framework_options['jobcircle-header-seventeen-alert'] : '';
     $sevtneml = isset($jobcircle_framework_options['jobcircle-header-seventeen-email']) ? $jobcircle_framework_options['jobcircle-header-seventeen-email'] : '';
     $sevtnnmbr = isset($jobcircle_framework_options['jobcircle-header-seventeen-number']) ? $jobcircle_framework_options['jobcircle-header-seventeen-number'] : '';
     $sevtndmneml = isset($jobcircle_framework_options['jobcircle-header-seventeen-domain-email']) ? $jobcircle_framework_options['jobcircle-header-seventeen-domain-email'] : '';
     ?>

        <div class="page-loader">
			<div class="loader-animmte"></div>
			<div class="loader-logo">
				<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/favicon.png" alt="Job-Circle">
			</div>
		</div>
    <?php
    global $post;
    $header_style_page = '';
    global $jobcircle_framework_options;
    $logo_style = jobcircle_site_logo();
    // Meta Field 
    if(isset($post->ID)){
    $header_style_page = get_post_meta($post->ID, 'jobcircle_field_header_style', true);
    } 
    $header_style = isset($jobcircle_framework_options['header-style']) ? $jobcircle_framework_options['header-style'] : '';

    if (!empty($header_style_page)) {
        $header_style = $header_style_page;
    }
    // 404 Page
    $error_header_style = isset($jobcircle_framework_options['header-style-error']) ? $jobcircle_framework_options['header-style-error'] : '';

    if(is_404() && (!empty($error_header_style))) {
    $header_style = $error_header_style;
    }
            
            if ($header_style == 'style1') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-sites-logo']['url']) ? $jobcircle_framework_options['jobcircle-sites-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-sites-logo', 'jobcircle-stick-logo');
                }
            } elseif ($header_style == 'style2') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-two-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-two-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-two-logo', 'jobcircle-sticky-two-logo');
                }
            } elseif ($header_style == 'style3') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-three-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-three-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-three-logo', 'jobcircle-sticky-three-logo');
                }
            } elseif ($header_style == 'style4') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-four-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-four-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-four-logo', 'jobcircle-sticky-four-logo');
                }
            } elseif ($header_style == 'style5') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-five-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-five-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-five-logo', 'jobcircle-sticky-five-logo');
                }
            } elseif ($header_style == 'style6') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-six-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-six-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-six-logo', 'jobcircle-sticky-six-logo');
                }
            } elseif ($header_style == 'style7') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-seven-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-seven-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-seven-logo', 'jobcircle-sticky-seven-logo');
                }
            } elseif ($header_style == 'style8') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-eight-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-eight-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-eight-logo', 'jobcircle-sticky-eight-logo');
                }
            } elseif ($header_style == 'style9') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-nine-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-nine-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-nine-logo', 'jobcircle-sticky-nine-logo');
                }
            } elseif ($header_style == 'style10') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-ten-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-ten-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-ten-logo', 'jobcircle-sticky-ten-logo');
                }
            } elseif ($header_style == 'style11') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-eleven-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-eleven-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-eleven-logo', 'jobcircle-sticky-eleven-logo');
                }
            }elseif ($header_style == 'style12') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-twelve-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-twelve-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-twelve-logo', 'jobcircle-sticky-twelve-logo');
                }
            }elseif ($header_style == 'style13') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-thirteen-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-thirteen-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-thirteen-logo', 'jobcircle-sticky-thirteen-logo');
                }
            }elseif ($header_style == 'style14') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-forteen-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-forteen-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-forteen-logo', 'jobcircle-sticky-forteen-logo');
                }
            }elseif ($header_style == 'style15') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-fifteen-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-fifteen-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-fifteen-logo', 'jobcircle-sticky-fifteen-logo');
                }
            }elseif ($header_style == 'style16') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-sixteen-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-sixteen-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-sixteen-logo', 'jobcircle-sticky-sixteen-logo');
                }
            }elseif ($header_style == 'style17') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-seventeen-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-seventeen-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-seventeen-logo', 'jobcircle-sticky-seventeen-logo');
                }
            }elseif ($header_style == 'style60') {
                $logo_value = isset($jobcircle_framework_options['jobcircle-site-sixty-logo']['url']) ? $jobcircle_framework_options['jobcircle-site-sixty-logo']['url'] : '';
                if (!empty($logo_value)) {
                    $logo_style = jobcircle_site_logo('jobcircle-site-sixty-logo', 'jobcircle-sticky-sixty-logo');
                }
            }
            

            
include 'header-html.php';
// For 404 page 


    if ($header_style == 'style2') { 
                echo jobcircle_esc_the_html($style2); 
    } elseif ($header_style == 'style3') {  
              echo jobcircle_esc_the_html($style3);
    } elseif ($header_style == 'style4') {   
              echo jobcircle_esc_the_html($style4);
    } elseif ($header_style == 'style5') {  
              echo jobcircle_esc_the_html($style5);
    } elseif ($header_style == 'style6') {  
                echo jobcircle_esc_the_html($style6);
    } elseif ($header_style == 'style7') {  
               echo jobcircle_esc_the_html($style7);
    } elseif ($header_style == 'style8') {  
               echo jobcircle_esc_the_html($style8);
    } elseif ($header_style == 'style9') {  
               echo jobcircle_esc_the_html($style9);
    } elseif ($header_style == 'style10') { 
               echo jobcircle_esc_the_html($style10);
    } elseif ($header_style == 'style11') { 
                echo jobcircle_esc_the_html($style11);
    } elseif ($header_style == 'style12') { 
                echo jobcircle_esc_the_html($style12);
    } elseif ($header_style == 'style13') { 
                echo jobcircle_esc_the_html($style13);
    } elseif ($header_style == 'style14') { 
                echo jobcircle_esc_the_html($style14);
    } elseif ($header_style == 'style15') { 
                echo jobcircle_esc_the_html($style15);
    } elseif ($header_style == 'style16') { 
                echo jobcircle_esc_the_html($style16);
    } elseif ($header_style == 'style17') { 
                echo jobcircle_esc_the_html($style17);
    } elseif ($header_style == 'style60') { 
                echo jobcircle_esc_the_html($style60);
    } else {                 
               echo jobcircle_esc_the_html($style1);       
            }
            $html = ob_get_clean();
            return apply_filters('jobcircle_theme_header_html', $html);
        });
        function jobcircle_site_logo($logo_key = 'jobcircle-sites-logo', $sticky_logo_key = 'jobcircle-stick-logo')
        {
            global $jobcircle_framework_options;
            $logo_default_val = '';
            $jobcircle_theme_options = get_option('jobcircle_framework_options');
            if (empty($jobcircle_theme_options)) {
                $logo_default_val = Jobcircle_Plugin::root_url() . '/images/logo.png';
            }
            $site_logo_key = $logo_key;
            $sticky_logo_key = $sticky_logo_key;
            $jobcircle_logo = isset($jobcircle_framework_options[$site_logo_key]['url']) && $jobcircle_framework_options[$site_logo_key]['url'] != '' ? $jobcircle_framework_options[$site_logo_key]['url'] : $logo_default_val;
            $sticky_logo = isset($jobcircle_framework_options[$sticky_logo_key]['url']) && $jobcircle_framework_options[$sticky_logo_key]['url'] != '' ? $jobcircle_framework_options[$sticky_logo_key]['url'] : $logo_default_val;
            $html = '';
            ob_start();
            echo '<a title="' . get_bloginfo('name') . '" href="' . esc_url(home_url('/')) . '">';
            if ($jobcircle_logo != '' || $sticky_logo != '') {
                echo '<img class="normal-logo" src="' . esc_url($jobcircle_logo) . '"' . ' alt="' . get_bloginfo('name') . '">';
                echo '<img class="sticky-logo" src="' . esc_url($sticky_logo) . '"' . ' alt="' . get_bloginfo('name') . '">';
            } else {
                echo get_bloginfo('name');
            }
            echo '</a>';
            $html .= ob_get_clean();
            return $html;
        }
        function jobcircle_header_navigation()
        {
            if (is_page()) {
                $page_id = get_the_id();
                $menu_slug = get_post_meta($page_id, 'jobcircle_field_sub_menu', true);
            }
            
            if (isset($menu_slug) && $menu_slug != '') {
                $args = array(
                    'menu' => $menu_slug,
                    'menu_class' => 'navigation',
                    'container' => '',
                    'fallback_cb' => 'jobcircle_nav_menu_fallback',
                    'walker' => new jobcircle_theme_menu_walker,
                );
                wp_nav_menu($args);
            } else {
                $args = array(
                    'theme_location' => 'primary',
                    'menu_class' => 'navigation',
                    'container' => '',
                    'fallback_cb' => 'jobcircle_nav_menu_fallback',
                    'walker' => new jobcircle_theme_menu_walker,
                );
                wp_nav_menu($args);
            }
        }
        function jobcircle_nav_menu_fallback()
        {
            $pages = wp_list_pages(array('title_li' => '', 'echo' => false));
            $pages = str_replace(array('class="children"', "class='children'"), array('class="children dropdown-menu"', "class='children dropdown-menu'"), $pages);
            echo '
            <ul class="navigation jobcircle-defu-nav">
                ' . $pages . '
                
            </ul>';
        }