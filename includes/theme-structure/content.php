<?php
add_filter('jobcircle_posts_item_content_markup', function () {
   if (is_author() || is_archive()) {
        ob_start();
        $author_id = get_queried_object_id();
        $args = array(
            'author' => $author_id, // Author ID
            'post_type' => 'post',
            'post_status' => 'publish',
        );       
        $day = date('j');
        $month = get_the_date('M, Y');
        ?>
                <div class="article-slide section-theme-4">
                <div class="article">
                    <div class="image-holder">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="text-frm">
                        <div class="exp-counter">
                            <div class="text">
                                <strong><?php echo $day; ?></strong><?php echo $month; ?>
                            </div>
                        </div>
                        <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                </div>
                </div>
            <?php
    $html = ob_get_clean();
    return $html;
   } 
});