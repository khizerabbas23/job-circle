<?php

// Add array of your fonts so they can be displayed in the font selector
function jobcircle_vc_icons_array($icons) {
	$icon_arr = array(
        "jobcircle-icon-upload1" => "e95f",
        "jobcircle-icon-cloud-upload" => "e95a",
        "jobcircle-icon-checkmark1" => "e954",
        "jobcircle-icon-tick1" => "e954",
        "jobcircle-icon-camera1" => "e933",
        "jobcircle-icon-photo" => "e933",
        "jobcircle-icon-image" => "e933",
        "jobcircle-icon-medal" => "e942",
        "jobcircle-icon-first" => "e942",
        "jobcircle-icon-win" => "e942",
        "jobcircle-icon-stats" => "e940",
        "jobcircle-icon-headphones" => "e934",
        "jobcircle-icon-music" => "e934",
        "jobcircle-icon-earphones" => "e934",
        "jobcircle-icon-medal1" => "e943",
        "jobcircle-icon-medal2" => "e944",
        "jobcircle-icon-moon-stars" => "e945",
        "jobcircle-icon-stars" => "e946",
        "jobcircle-icon-document-certificate" => "e92b",
        "jobcircle-icon-document-code" => "e921",
        "jobcircle-icon-mail" => "e905",
        "jobcircle-icon-email" => "e905",
        "jobcircle-icon-letter" => "e905",
        "jobcircle-icon-envelope" => "e905",
        "jobcircle-icon-contact" => "e905",
        "jobcircle-icon-calendar" => "e906",
        "jobcircle-icon-date" => "e906",
        "jobcircle-icon-schedule" => "e906",
        "jobcircle-icon-out" => "e95e",
        "jobcircle-icon-check-alt" => "e952",
        "jobcircle-icon-checkmark" => "e952",
        "jobcircle-icon-tick" => "e952",
        "jobcircle-icon-checkmark2" => "e953",
        "jobcircle-icon-tick2" => "e953",
        "jobcircle-icon-headphones3" => "e935",
        "jobcircle-icon-camera3" => "e936",
        "jobcircle-icon-cricket-bat-ball" => "e937",
        "jobcircle-icon-person-swimming" => "e938",
        "jobcircle-icon-drown" => "e92c",
        "jobcircle-icon-sit" => "e922",
        "jobcircle-icon-rest" => "e922",
        "jobcircle-icon-work" => "e922",
        "jobcircle-icon-portfolio" => "e923",
        "jobcircle-icon-briefcase" => "e923",
        "jobcircle-icon-suitcase" => "e923",
        "jobcircle-icon-work1" => "e923",
        "jobcircle-icon-business" => "e923",
        "jobcircle-icon-comments" => "e91a",
        "jobcircle-icon-chat" => "e91a",
        "jobcircle-icon-talk" => "e91a",
        "jobcircle-icon-bubble" => "e91a",
        "jobcircle-icon-upload" => "e95b",
        "jobcircle-icon-camera" => "e932",
        "jobcircle-icon-camera1" => "e933",
        "jobcircle-icon-photo" => "e933",
        "jobcircle-icon-image" => "e933",
        "jobcircle-icon-medal" => "e942",
        "jobcircle-icon-first" => "e942",
        "jobcircle-icon-win" => "e942",
        "jobcircle-icon-stats" => "e940",
        "jobcircle-icon-headphones" => "e934",
        "jobcircle-icon-music" => "e934",
        "jobcircle-icon-earphones" => "e934",
        "jobcircle-icon-medal1" => "e943",
        "jobcircle-icon-medal2" => "e944",
        "jobcircle-icon-moon-stars" => "e945",
        "jobcircle-icon-stars" => "e946",
        "jobcircle-icon-document-certificate" => "e92b",
        "jobcircle-icon-check_circle" => "e955",
        "jobcircle-icon-check2" => "e956",
        "jobcircle-icon-upload-cloud" => "e95d",
        "jobcircle-icon-check" => "e957",
        "jobcircle-icon-stacked_line_chart" => "e93b",
        "jobcircle-icon-insert_chart_outlined" => "e93c",
        "jobcircle-icon-graphic_eq" => "e93d",
        "jobcircle-icon-sports_cricket" => "e92d",
        "jobcircle-icon-chart-line-outline" => "e93e",
        "jobcircle-icon-chart-line" => "e93f",
        "jobcircle-icon-camera-outline" => "e92e",
        "jobcircle-icon-headphones1" => "e92f",
        "jobcircle-icon-camera2" => "e930",
        "jobcircle-icon-headphones2" => "e931",
        "jobcircle-icon-group-outline" => "e92a",
        "jobcircle-icon-work_outline" => "e924",
        "jobcircle-icon-briefcase1" => "e925",
        "jobcircle-icon-arrow-right" => "e907",
        "jobcircle-icon-arrow-left1" => "e908",
        "jobcircle-icon-arrow-down1" => "e909",
        "jobcircle-icon-arrow-up1" => "e90a",
        "jobcircle-icon-phone" => "e90b",
        "jobcircle-icon-mail1" => "e90c",
        "jobcircle-icon-calendar1" => "e90d",
        "jobcircle-icon-eye-off" => "e90e",
        "jobcircle-icon-eye" => "e90f",
        "jobcircle-icon-clock" => "e910",
        "jobcircle-icon-bookmark" => "e911",
        "jobcircle-icon-plus" => "e912",
        "jobcircle-icon-user" => "e913",
        "jobcircle-icon-chevron-right" => "e914",
        "jobcircle-icon-chevron-left" => "e915",
        "jobcircle-icon-chevron-up" => "e916",
        "jobcircle-icon-chevron-down" => "e917",
        "jobcircle-icon-map-pin" => "e918",
        "jobcircle-icon-search" => "e919",
        "jobcircle-icon-check-circle" => "e958",
        "jobcircle-icon-message" => "e950",
        "jobcircle-icon-calendar2" => "e951",
        "jobcircle-icon-briefcase3" => "e94f",
        "jobcircle-icon-phone1" => "e949",
        "jobcircle-icon-ad" => "e94a",
        "jobcircle-icon-handshake" => "e94b",
        "jobcircle-icon-books" => "e94c",
        "jobcircle-icon-medal3" => "e94d",
        "jobcircle-icon-stars-group" => "e94e",
        "jobcircle-icon-users-group" => "e947",
        "jobcircle-icon-chart-line-arrow" => "e948",
        "jobcircle-icon-group" => "e941",
        "jobcircle-icon-users" => "e941",
        "jobcircle-icon-line-chart" => "e939",
        "jobcircle-icon-bar-chart" => "e93a",
        "jobcircle-icon-linkedin1" => "e929",
        "jobcircle-icon-suitcase1" => "e926",
        "jobcircle-icon-briefcase2" => "e927",
        "jobcircle-icon-youtube-play" => "e91b",
        "jobcircle-icon-twitter" => "e91c",
        "jobcircle-icon-instagram" => "e91d",
        "jobcircle-icon-facebook" => "e91e",
        "jobcircle-icon-facebook-f" => "e91e",
        "jobcircle-icon-star-half" => "e91f",
        "jobcircle-icon-star" => "e920",
        "jobcircle-icon-upload-to-cloud" => "e95c",
        "jobcircle-icon-check1" => "e959",
        "jobcircle-icon-linkedin" => "e928",
        "jobcircle-icon-youtube" => "e900",
        "jobcircle-icon-arrow-left" => "e901",
        "jobcircle-icon-arrow-right1" => "e902",
        "jobcircle-icon-arrow-down" => "e903",
        "jobcircle-icon-arrow-up" => "e904"
    );

    $cus_icons = array();
    foreach ($icon_arr as $icon_class => $icon_code) {
        $icon_name = str_replace('-icon-', ' ', $icon_class);
        $cus_icons[] = array($icon_class => $icon_name);
    }
    $categrize_icons = array(
        'JobCircle Icons' => $cus_icons,
    );

    return array_merge($icons, $categrize_icons);
}
add_filter( 'vc_iconpicker-type-fontawesome', 'jobcircle_vc_icons_array', 5 );

/**
 * Register Backend and Frontend CSS Styles
 */
add_action( 'vc_base_register_front_css', 'jobcircle_vc_iconpicker_base_register_css' );
add_action( 'vc_base_register_admin_css', 'jobcircle_vc_iconpicker_base_register_css' );
function jobcircle_vc_iconpicker_base_register_css(){
    wp_register_style('jobcircle-icons', Jobcircle_Plugin::root_url() . 'css/icons.css');
}

/**
 * Enqueue Backend and Frontend CSS Styles
 */
add_action( 'vc_backend_editor_enqueue_js_css', 'jobcircle_vc_iconpicker_editor_jscss' );
add_action( 'vc_frontend_editor_enqueue_js_css', 'jobcircle_vc_iconpicker_editor_jscss' );
function jobcircle_vc_iconpicker_editor_jscss(){
    wp_enqueue_style( 'jobcircle-icons' );
}

/**
 * Enqueue CSS in Frontend when it's used
 */
add_action('vc_enqueue_font_icon_element', 'jobcircle_enqueue_font_icomoon');
function jobcircle_enqueue_font_icomoon($font){
    switch ( $font ) {
        case 'fontawesome': wp_enqueue_style( 'jobcircle-icons' );
    }
}