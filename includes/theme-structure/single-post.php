<?php

add_filter('jobcircle_single_post_page_markup', function () {
    ob_start();
    ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
        if (has_post_thumbnail()) {
            $post = get_post();
            $postid = $post->ID;
            
            global $jobcircle_framework_options;
            
            $default_job_view = isset($jobcircle_framework_options['jobcircle_field_post_detail_view']) ? $jobcircle_framework_options['jobcircle_field_post_detail_view'] : '';
            $post_style_view = get_post_meta($post->ID, 'jobcircle_field_post_detail_view', true);
            
            if ($post_style_view != '') {
            	$job_slected_style = $post_style_view;
            
            } else {
            	$job_slected_style = $default_job_view;
            }
             if ($job_slected_style == 'style2') {
            	include 'blog-detail/blog-details.php';
            } else {
            $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'large');
            $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
            $title = get_the_title();
            $content = get_the_content($postid);
            $permalink = get_the_permalink($postid);
            $posted = get_the_time('U');
            $timeago =  human_time_diff($posted,current_time( 'U' )). "";
            $comment_count = get_comments_number(get_the_ID());
            $author_id = get_post_field('post_author', get_the_ID());
            $author_name = get_the_author_meta('display_name', $author_id);
            $author_id = get_the_author_meta('ID');
            $user_bio = get_the_author_meta('description', $author_id);
            $facebook_url = isset($jobcircle_framework_options['jobcircle-footer-facebook-url']) ? $jobcircle_framework_options['jobcircle-footer-facebook-url'] : '';
            $instagrm_url = isset($jobcircle_framework_options['jobcircle-footer-instagram-url']) ? $jobcircle_framework_options['jobcircle-footer-instagram-url'] : '';
            $twitter_url = isset($jobcircle_framework_options['jobcircle-footer-twitter-url']) ? $jobcircle_framework_options['jobcircle-footer-twitter-url'] : '';
            
            if ($post_thumbnail_src != '') {
                ?>

                <?php
            }
        ?>
        <!-- Article Post -->
        <article class="post">
            <div class="post-image">
                <img src="<?php echo $post_thumbnail_image[0]; ?>" alt="How to overcome economic crisis instantly">
            </div>
            <h3 class="entry-title">
                <?php echo $title ?>
            </h3>
            <ul class="entry-meta">
                <li>
                    <i class="jobcircle-icon-calendar2 job_detmrn"></i>
                    <span class="subtext">
                        <?php echo $timeago ?>
                    </span>
                </li>
                <li>
                    <i class="jobcircle-icon-message job_detmrn"></i>
                    <span class="subtext">
                        <?php echo $comment_count ?>
                    </span>
                </li>
            </ul>

            <?php echo do_shortcode($content); ?>

            <div class="d-flex align-items-center justify-content-between flex-wrap mb-15 mb-md-35">
                <div class="post-tags">
                    <strong class="title"><?php esc_html_e('Tags:','jobcircle-frame')?></strong>
                    <div class="tagcloud">
                        <?php
                        $post_tags = get_the_tags();
                        if ($post_tags) {
                            $count = 0;
                            foreach ($post_tags as $tag) {
                                if ($count < 4) { // Sirf 3 tags display karenge
                                    echo '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a> ';
                                    $count++;
                                } else {
                                    break; // Loop se bahar nikal jayenge agar 3 tags ho gaye to
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="post-social">
                    <strong class="title">Share:</strong>
                    <ul class="social-share">
                        <li><a href="<?php echo $facebook_url ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $twitter_url ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $instagrm_url ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="post-author">
                <div class="author-avatar">
           <?php echo get_avatar(get_the_author_meta('ID')); ?>
                </div>
                <div class="author-bio">
                    <strong class="title">
                        <?php echo get_the_author(); ?><span>(admin)</span>
                    </strong>
                    <p>
                        <?php echo $user_bio ?>
                    </p>
                </div>
            </div>
            <?php echo jobcircle_blog_from_frontend() ?>
                    </artical>

            <?php
            if (comments_open() || get_comments_number()):
                comments_template();
            endif;


            ?>
    </div>
    <?php
}
}
    $html = ob_get_clean();
    return $html;
});