<?php

add_filter('jobcircle_page_content_markup', function () {
    ob_start();
    ?>
    <div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
        if (has_post_thumbnail()) {
            $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'large');
            $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
            if ($post_thumbnail_src != '') {
                ?>
                <div class="jobcircle-post-thumb">
                    <img src="<?php echo esc_url($post_thumbnail_src) ?>" alt="<?php the_title() ?>">
                </div>
                <?php
            }
        }
        ?>
        <div class="jobcircle-detail-content">
            <?php
            if (function_exists('is_checkout')) {
                if (is_checkout()) {
                    echo '<div class="jobcircle-section-tbpading"><div class="bg-white rounded"><div class="px-4 py-3">';
                }
            }
            the_content();
            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'jobcircle-frame'),
                'after' => '</div>',
            ));
            if (function_exists('is_checkout')) {
                if (is_checkout()) {
                    echo '</div></div></div>';
                }
            }
            ?>
        </div>
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
});
