<?php

include_once JOBCIRCLE_ABSPATH . 'includes/theme-structure/header.php';
include_once JOBCIRCLE_ABSPATH . 'includes/theme-structure/footer.php';
include_once JOBCIRCLE_ABSPATH . 'includes/theme-structure/single-post.php';
include_once JOBCIRCLE_ABSPATH . 'includes/theme-structure/content.php';
include_once JOBCIRCLE_ABSPATH . 'includes/theme-structure/page-content.php';
include_once JOBCIRCLE_ABSPATH . 'includes/theme-structure/404.php';
include_once JOBCIRCLE_ABSPATH . 'includes/theme-structure/comments.php';

add_filter('jobcircle_comments_default_theme_structure_all', '__return_false');
add_filter('jobcircle_theme_style_scripts', '__return_false');
add_filter('jobcircle_comments_template_html_con', '__return_false');

add_filter('jobcircle_enable_theme_sidebar', '__return_false');

add_filter('jobcircle_site_main_container_start', function($html = '') {
    $html = '<div class="jobcircle-site-wrapper">';
    return $html;
});

add_filter('jobcircle_site_main_innercon_start', '__return_false');
add_filter('jobcircle_site_main_innercon_end', '__return_false');

add_filter('jobcircle_before_page_container_markup', function($html = '', $page_type = 'page') {
     $html = '';
    $page_subheader_switch = '';
    $post = get_the_id();
    if(is_page() ){
        $page_subheader_switch = get_post_meta($post, 'jobcircle_field_sub_header', true);

    }
    if (!is_home() && !is_front_page() && $page_subheader_switch != 'off' && !is_404()) {   
 
        ob_start();
        ?>
		<div class="subvisual-block subvisual-theme-1 bg-dark-green d-flex pt-60 pt-md-90 pt-lg-150 pb-30 text-white">
			<span class="shape top"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-shape-top.webp" width="93" height="241" alt="Banner Shape Top"></span>
			<span class="shape bottom"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/banner-inner-bottom.png" width="979" height="249" alt="Banner Shape Bottom"></span>
			<div class="icons-image"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/visual-pattern-1-3.png" width="1187" height="274" alt="Icons"></div>
			<div class="container position-relative text-center">
				<div class="row">
					<div class="col-12">
						<div class="subvisual-textbox">
							<h1><?php jobcircle_post_page_title() ?></h1>
							<p><?php esc_html_e('Feel free to get in touch with us. Need Help?', 'jobcircle-frame') ?></p>
						</div>
						<nav class="breadcrumb-nav text-white d-flex justify-content-center mt-20 mt-lg-40">
							<ul class="breadcrumb mb-0">
								<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('Home', 'jobcircle-frame') ?></a></li>
								<li class="breadcrumb-item active"><?php jobcircle_post_page_title() ?></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
        <?php
        $html .= ob_get_clean();
    }
    
    if ($page_type != 'page_full_width' && !is_404()) {
        if (function_exists('is_checkout')) {
            if (is_checkout()) {
                echo '<div class="bg-light">';
            }
        }
        $html .= '<div class="container">';
    }
    if (is_author() || is_archive()) {
        $html .= '<div class="acticles-carousel author-posts">';
    }
    return $html;
}, 10, 2);

add_filter('jobcircle_after_page_container_markup', function($html = '', $page_type = 'page') {
    $html = '';
    if ($page_type != 'page_full_width') {
        $html = '</div>';
        if (function_exists('is_checkout')) {
            if (is_checkout()) {
                echo '</div>';
            }
        }
    }
    if (is_author() || is_archive()) {
        $html .= '</div>';
    }
    return $html;
}, 10, 2);

add_action('jobcircle_before_main_content', function($page_type = 'page') {

    $html = '';
    $has_sidebar = false;
    $content_class = '';
    $content_main_class = 'col-12 col-lg-9';
   
    if ($page_type == 'page' || $page_type == 'single') {
        $post_id = get_the_id();
        
        if (metadata_exists('post', $post_id, 'jobcircle_field_post_layout')) {
            $layout = get_post_meta($post_id, 'jobcircle_field_post_layout', true);
            $sidebar = get_post_meta($post_id, 'jobcircle_field_post_sidebar', true);
        }
        $sidebar_size = get_post_meta($post_id, 'jobcircle_field_column_size', true);

        if ($sidebar_size == 'columneight') {
            $content_main_class = 'col-md-8' ;
        }
    }
    if (!isset($layout)) {
        global $jobcircle_framework_options;
        $layout = isset($jobcircle_framework_options['jobcircle-default-layout']) ? $jobcircle_framework_options['jobcircle-default-layout'] : '';
        $sidebar = isset($jobcircle_framework_options['jobcircle-default-sidebar']) ? $jobcircle_framework_options['jobcircle-default-sidebar'] : '';
    }

    if (($layout == 'right' || $layout == 'left') && $sidebar != '' && is_active_sidebar($sidebar)) {
        $has_sidebar = true;
        $content_class = $layout == 'left' ? ' pull-right' : ' pull-left';
        $content_reverse = $layout == 'left' ? 'flex-md-row-reverse' : '';
    } else if (is_active_sidebar('sidebar-1') && $layout == '') {
        $has_sidebar = true;
    }

    if ($page_type == '404') {
        $html = '<div class="jobcircle-404-page">' . "\n";

    } else {
        if ($has_sidebar) {
            $html = '<div class="row column-wrapper pt-35 pt-md-50 pt-lg-45 pb-35 pb-md-50 pb-lg-65 pt-xl-95 '.$content_reverse.'">
            <div class="'.$content_main_class . $content_class . '">';
        }
        
    }
    echo ($html);
});

add_action('jobcircle_after_main_content', function($page_type = 'page') {

    $html = '';
    $has_sidebar = false;
    $sidebar_class = '';
    $content_sidebar= 'col-12 col-lg-3';

    if ($page_type == 'page' || $page_type == 'single') {
        $post_id = get_the_id();
        $sidebar_size = get_post_meta($post_id, 'jobcircle_field_column_size', true);
        if ($sidebar_size == 'columneight') {
            $content_sidebar = 'col-md-4';
}

        if (metadata_exists('post', $post_id, 'jobcircle_field_post_layout')) {
            $layout = get_post_meta($post_id, 'jobcircle_field_post_layout', true);
            $sidebar = get_post_meta($post_id, 'jobcircle_field_post_sidebar', true);
        }
    }
    if (!isset($layout)) {
        global $jobcircle_framework_options;
        $layout = isset($jobcircle_framework_options['jobcircle-default-layout']) ? $jobcircle_framework_options['jobcircle-default-layout'] : '';
        $sidebar = isset($jobcircle_framework_options['jobcircle-default-sidebar']) ? $jobcircle_framework_options['jobcircle-default-sidebar'] : '';
    }

    if (($layout == 'right' || $layout == 'left') && $sidebar != '' && is_active_sidebar($sidebar)) {
        $has_sidebar = true;
        $sidebar_class = $layout == 'left' ? ' pull-left' : ' pull-right';
    } else if (is_active_sidebar('sidebar-1') && $layout == '') {
        $has_sidebar = true;
        $sidebar = 'sidebar-1';
    }

    if ($page_type == '404') {
        $html = '</div>' . "\n";
    } else {
        if ($has_sidebar) {
            $html = '</div>';
            ob_start();
            echo '<div class="' .$content_sidebar .  $sidebar_class . '">';
            dynamic_sidebar($sidebar);
            echo '</div>';
            $html .= ob_get_clean();
            $html .= '</div>';
        }
    }
    echo ($html);
});

// Default Layouts Sidebars Register
add_action('widgets_init', 'jobcircle_dynamic_sidebars');

function jobcircle_dynamic_sidebars() {
	global $jobcircle_framework_options;

	$jobcircle_sidebars = isset($jobcircle_framework_options['jobcircle-themes-sidebars']) ? $jobcircle_framework_options['jobcircle-themes-sidebars'] : '';
	if (is_array($jobcircle_sidebars) && sizeof($jobcircle_sidebars) > 0) {
		foreach ($jobcircle_sidebars as $sidebar) {
			if ($sidebar != '') {
				$sidebar_id = urldecode(sanitize_title($sidebar));
				register_sidebar(array(
					'name' => $sidebar,
					'id' => $sidebar_id,
					'description' => esc_html__('Add widgets here.', "jobcircle-frame"),
					'before_widget' => '',
					'after_widget' => '',
					'before_title' => '<div class="widget "><h4>',
					'after_title' => '</h4></div>',
				));
			}
		}
	}
}

// Footer Sidebars Register
add_action('widgets_init', 'jobcircle_footer_dynamic_sidebars');

function jobcircle_footer_dynamic_sidebars() {
	global $jobcircle_framework_options;

	$before_title = '<div class="widget-header"><h5>';
	$after_title = '</h5></div>';

	$all_sidebars = $jobcircle_sidebars = isset($jobcircle_framework_options['jobcircle-footer-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-sidebars'] : '';
        
    $jobcircle_sidebars_2 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-two-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-two-sidebars'] : '';
    $jobcircle_sidebars_3 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-three-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-three-sidebars'] : '';
    $jobcircle_sidebars_4 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-four-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-four-sidebars'] : '';
    $jobcircle_sidebars_5 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-five-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-five-sidebars'] : '';
    $jobcircle_sidebars_6 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-six-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-six-sidebars'] : '';
    $jobcircle_sidebars_7 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-seven-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-seven-sidebars'] : '';
    $jobcircle_sidebars_8 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-eight-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-eight-sidebars'] : '';
    $jobcircle_sidebars_9 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-nine-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-nine-sidebars'] : '';
    $jobcircle_sidebars_10 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-ten-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-ten-sidebars'] : '';
    $jobcircle_sidebars_11 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-eleven-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-eleven-sidebars'] : '';
    $jobcircle_sidebars_12 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-twelve-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-twelve-sidebars'] : '';
    $jobcircle_sidebars_13 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-thirteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-thirteen-sidebars'] : '';
    $jobcircle_sidebars_14 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-fourteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-fourteen-sidebars'] : '';
    $jobcircle_sidebars_15 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-fifteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-fifteen-sidebars'] : '';
    $jobcircle_sidebars_16 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-sixteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-sixteen-sidebars'] : '';
    $jobcircle_sidebars_17 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-seventeen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-seventeen-sidebars'] : '';
    $jobcircle_sidebars_60 = isset($jobcircle_framework_options['jobcircle-footer-widgstyle-sixty-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-sixty-sidebars'] : '';

    if (isset($jobcircle_sidebars_2['col_width']) && !empty($jobcircle_sidebars_2['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_2['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_2['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_3['col_width']) && !empty($jobcircle_sidebars_3['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_3['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_3['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_4['col_width']) && !empty($jobcircle_sidebars_4['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_4['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_4['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_5['col_width']) && !empty($jobcircle_sidebars_5['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_5['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_5['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_6['col_width']) && !empty($jobcircle_sidebars_6['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_6['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_6['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_7['col_width']) && !empty($jobcircle_sidebars_7['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_7['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_7['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_8['col_width']) && !empty($jobcircle_sidebars_8['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_8['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_8['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_9['col_width']) && !empty($jobcircle_sidebars_9['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_9['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_9['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_10['col_width']) && !empty($jobcircle_sidebars_10['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_10['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_10['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_11['col_width']) && !empty($jobcircle_sidebars_11['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_11['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_11['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_12['col_width']) && !empty($jobcircle_sidebars_12['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_12['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_12['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_13['col_width']) && !empty($jobcircle_sidebars_13['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_13['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_13['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_14['col_width']) && !empty($jobcircle_sidebars_14['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_14['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_14['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_15['col_width']) && !empty($jobcircle_sidebars_15['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_15['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_15['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_16['col_width']) && !empty($jobcircle_sidebars_16['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_16['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_16['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_17['col_width']) && !empty($jobcircle_sidebars_17['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_17['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_17['sidebar_name']);
    }
    if (isset($jobcircle_sidebars_60['col_width']) && !empty($jobcircle_sidebars_60['col_width'])) {
        $all_sidebars['col_width'] = array_merge($all_sidebars['col_width'], $jobcircle_sidebars_60['col_width']);
        $all_sidebars['sidebar_name'] = array_merge($all_sidebars['sidebar_name'], $jobcircle_sidebars_60['sidebar_name']);
    }



	if (isset($all_sidebars['col_width']) && is_array($all_sidebars['col_width']) && sizeof($all_sidebars['col_width']) > 0) {
		$sidebar_counter = 0;
		foreach ($all_sidebars['col_width'] as $sidebar_col) {
			$sidebar = isset($all_sidebars['sidebar_name'][$sidebar_counter]) ? $all_sidebars['sidebar_name'][$sidebar_counter] : '';
			if ($sidebar != '') {
				$sidebar_id = urldecode(sanitize_title($sidebar));
				register_sidebar(array(
					'name' => $sidebar,
					'id' => $sidebar_id,
					'description' => esc_html__('Add only one widget here.', "jobcircle-frame"),
					'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',// footer-widget sy phaly widget ki class thi jis ko ma ny remove kiya h footer ky style ky liyay q ky widget ki class index ma nhi thi
					'after_widget' => '</div>',
					'before_title' => $before_title,
					'after_title' => $after_title,
				));
			}
			$sidebar_counter++;
		}
	}
}

add_filter('jobcircle_archive_page_title_markup', function($html) {
    ob_start();
    ?>
    <div class="jobcircle-archive-header">
        <h1><?php the_archive_title(); ?></h1>
    </div>
    <?php
    $html = ob_get_clean();
    $html = '';

    return $html;
});

add_filter('jobcircle_search_title_output', function($html) {
    ob_start();
    ?>
    <div class="jobcircle-search-header">
        <h1>
            <?php
            printf(
                __( 'Search Results for: %s', 'jobcircle-frame' ),
                '<span>' . get_search_query() . '</span>'
            );
            ?>
        </h1>
    </div>
    <?php
    $html = ob_get_clean();
    $html = '';

    return $html;
});