<?php

// this is an include only WP file
if (!defined('ABSPATH')) {
    die;
}

// main plugin class
class jobcircle_Job_RSS_Feeds {

    // hook things up
    public function __construct() {
        add_action('init', array($this, 'custom_rss'));
    }

    function custom_rss() {
        add_feed('job_feed', array($this, 'custom_feed_template'));
    }

    function custom_feed_template() {

        $numofpost = 20;
        $page_numbr = 1;
        $order = 'DESC';
        $orderby = 'ID';

        $args = array(
            'post_type' => 'jobs',
            'post_status' => 'publish',
            'posts_per_page' => $numofpost,
            'order' => $order,
            'paged' => $page_numbr,
            'orderby' => $orderby,
        );
    
        // Search keyword
        if (isset($_REQUEST['keyword'])) {
            $keyword = $_REQUEST['keyword'];
            $args['s'] = esc_html($keyword);
        }
    
        // tax query
        $tax_query = array();
        if (isset($_REQUEST['job_category'])) {
            $job_category = $_REQUEST['job_category'];
            $tax_query[] = array(
                'taxonomy' => 'job_category',
                'field' => 'slug',
                'terms' => $job_category,
            );
        }
    
        $min_salary = isset($_REQUEST['min_salary']) ? preg_replace("/[^0-9]/", '', $_REQUEST['min_salary'] ): '';
        $max_salary = isset($_REQUEST['max_salary']) ? preg_replace("/[^0-9]/", '',$_REQUEST['max_salary'] ): '';
    
        $meta_query = array();
        if ($min_salary >= 0 && $max_salary > 0) {
    
            $meta_query[] = array(
                'key' => 'jobcircle_field_min_salary',
                'value' => array($min_salary, $max_salary),
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            );
        }
        $meta_query = apply_filters('jobcircle_listing_filters_meta_query', $meta_query, 'jobs');
    
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
    
        if (!empty($meta_query)) {
            $args['meta_query'] = $meta_query;
        }
    
        // Custom query.// also this one
        $jobs_query = new WP_Query($args);
        header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
    
        echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>';

        $job_types = jobcircle_job_types_list();
        ?>
        <rss version="2.0"
            xmlns:content="http://purl.org/rss/1.0/modules/content/"
            xmlns:wfw="http://wellformedweb.org/CommentAPI/"
            xmlns:dc="http://purl.org/dc/elements/1.1/"
            xmlns:atom="http://www.w3.org/2005/Atom"
            xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
            xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
            <?php do_action('rss2_ns'); ?>>
            <channel>
                <title><?php bloginfo_rss('name'); ?> - Feed</title>
                <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
                <link><?php bloginfo_rss('url') ?></link>
                <description><?php bloginfo_rss('description') ?></description>
                <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
                <language><?php echo get_option('rss_language'); ?></language>
                <sy:updatePeriod><?php echo apply_filters('rss_update_period', 'hourly'); ?></sy:updatePeriod>
                <sy:updateFrequency><?php echo apply_filters('rss_update_frequency', '1'); ?></sy:updateFrequency>
                <?php do_action('rss2_head'); ?>
                <?php
                if ($jobs_query->have_posts()) {
                    while ($jobs_query->have_posts()) : $jobs_query->the_post();
                        $job_id = get_the_ID();
                        $post_obj = get_post($job_id);
                        
                        $expiry_date = get_post_meta($job_id, 'jobcircle_field_job_expiry_date', true);
                        if ($expiry_date != '') {
                            $expiry_date = date('Y-m-d H:i:s', $expiry_date);
                            $expiry_date = mysql2date('D, d M Y H:i:s +0000', $expiry_date, false);
                        }
                        $appdedline_date = get_post_meta($job_id, 'jobcircle_field_job_deadline', true);
                        if ($appdedline_date != '') {
                            $appdedline_date = date('Y-m-d H:i:s', strtotime($appdedline_date));
                            $appdedline_date = mysql2date('D, d M Y H:i:s +0000', $appdedline_date, false);
                        }
                        $post_content = isset($post_obj->post_content) ? $post_obj->post_content : '';
                        $post_content = apply_filters('the_content', $post_content);
                        $postby_author = isset($post_obj->post_author) ? $post_obj->post_author : '';
                        $postby_emp_id = jobcircle_user_employer_id($postby_author);
                        $postby_emp_name = '';
                        if ($postby_emp_id > 0) {
                            $postby_emp_name = get_the_title($postby_emp_id);
                        } else {
                            $get_post_user = get_user_by('id', $postby_author);
                            $postby_emp_name = isset($get_post_user->display_name) ? $get_post_user->display_name : '';
                        }
                        $post_thumbnail_src = jobcircle_job_thumbnail_url($job_id);
                        
                        $is_featured = get_post_meta($job_id, 'jobcircle_field_job_featured', true);
                        $featured_till_date = get_post_meta($job_id, 'jobcircle_field_job_feature_till', true);
                        if ($featured_till_date != '') {
                            $featured_till_date = date('Y-m-d H:i:s', strtotime($featured_till_date));
                            $featured_till_date = mysql2date('D, d M Y H:i:s +0000', $featured_till_date, false);
                        }
                        
                        $get_job_location = jobcircle_post_location_str($job_id);
                        
                        $job_salary = jobcircle_job_salary_str($job_id);
                        
                        $job_sectors = wp_get_post_terms($job_id, 'job_category');
                        $job_sector = isset($job_sectors[0]->name) ? $job_sectors[0]->name : '';
                        $job_type = get_post_meta($job_id, 'jobcircle_field_job_type', true);
                        $job_type_str = $job_type != '' && isset($job_types[$job_type]) ? $job_types[$job_type]['title'] : '';
                        ?>
                        <item>
                            <RecuiterJobNumber><![CDATA[<?php echo ($job_id) ?>]]></RecuiterJobNumber>
                            <title><![CDATA[<?php the_title_rss(); ?>]]></title>
                            <link><![CDATA[<?php the_permalink_rss(); ?>]]></link>
                            <PostDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></PostDate>
                            <expiryDate><?php echo ($expiry_date); ?></expiryDate>
                            <?php
                            if ($appdedline_date != '') {
                                ?>
                                <applicationDeadline><?php echo ($appdedline_date); ?></applicationDeadline>
                                <?php
                            }
                            ?>
                            <featured><![CDATA[<?php echo ($is_featured == 'on' ? 'yes' : 'no') ?>]]></featured>
                            <?php
                            if ($is_featured == 'on') {
                                ?>
                                <featuredTill><![CDATA[<?php echo ($featured_till_date) ?>]]></featuredTill>
                                <?php
                            }
                            ?>
                            <salary><![CDATA[<?php echo ($job_salary) ?>]]></salary>
                            <employer><![CDATA[<?php echo ($postby_emp_name) ?>]]></employer>
                            <employerImg><![CDATA[<?php echo ($post_thumbnail_src) ?>]]></employerImg>
                            <location><![CDATA[<?php echo ($get_job_location) ?>]]></location>
                            <sector><![CDATA[<?php echo ($job_sector) ?>]]></sector>
                            <type><![CDATA[<?php echo ($job_type_str) ?>]]></type>
                            <excerpt><![CDATA[<?php the_excerpt_rss() ?>]]></excerpt>
                            <description><![CDATA[<?php echo ($post_content) ?>]]></description>
                            <?php rss_enclosure(); ?>
                            <?php do_action('rss2_item'); ?>
                        </item>
                        <?php
                    endwhile;
                }
                ?>
            </channel>
        </rss>
        <?php
    }

}

return new jobcircle_Job_RSS_Feeds();
