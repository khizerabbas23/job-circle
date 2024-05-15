<?php
        if (has_post_thumbnail()) {
            $post = get_post();
            $postid = $post->ID;
            
            $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'large');
            $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
            $title = get_the_title();
            $content = get_the_content($postid);
            $permalink = get_the_permalink($postid);
            $date = date('M d Y');
            $comment_count = get_comments_number(get_the_ID());
            $author_id = get_post_field('post_author', get_the_ID());
            $author_name = get_the_author_meta('display_name', $author_id);
            $author_id = get_the_author_meta('ID');
            $author_profile_link = get_author_posts_url($author_id);
            $user_bio = get_the_author_meta('description', $author_id);
            $designation = get_post_meta($postid, 'jobcircle_field_designation', true);
            $job_post = get_post($post);
            $facebook_url = isset($jobcircle_framework_options['jobcircle-footer-facebook-url']) ? $jobcircle_framework_options['jobcircle-footer-facebook-url'] : '';
            $instagrm_url = isset($jobcircle_framework_options['jobcircle-footer-instagram-url']) ? $jobcircle_framework_options['jobcircle-footer-instagram-url'] : '';
            $twitter_url = isset($jobcircle_framework_options['jobcircle-footer-twitter-url']) ? $jobcircle_framework_options['jobcircle-footer-twitter-url'] : '';
    		 $post_author = $job_post->post_author;
    		 $post_employer_id = jobcircle_user_employer_id($post_author);
    		 if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
    		     $post_author_name = get_the_title($post_employer_id);
    		 } else {
    		     $author_user_obj = get_user_by('id', $post_author);
    		     $post_author_name = $author_user_obj->display_name;
    		}
            if ($post_thumbnail_src != '') {
                ?>

                <?php
            }
        ?>
            <main class="main">
			<div class="container">
						<!-- Article Post -->
						<article class="post singlepost-theme-1">
							<div class="post-image">
								<img src="<?php echo $post_thumbnail_image[0]; ?>" alt="How to overcome economic crisis instantly">
							</div>
							<strong class="subtitle"><?php echo $designation ?></strong>
							<h3 class="entry-title"><?php echo $title ?></h3>
							<div class="post-meta-wrap">
								<ul class="entry-meta">
									<li>
										<span class="subtext"><?php echo $date ?></span>
									</li>
									<li>
										<span class="subtext"><?php echo $comment_count ?> <?php esc_html_e('Comments','jobcircle-frame')?></span>
									</li>
								</ul>
								<div class="post-author-info">
									<span class="author-image"><?php echo get_avatar(get_the_author_meta('ID')); ?></span>
									<span class="post-by">By <strong><a href="<?php echo $author_profile_link ?>"><?php echo $post_author_name ?></a></strong></span>
								</div>
							</div>
							
                            <?php echo the_content(); ?>
                            
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
							<div class="post-author">
								<div class="author-avatar">
								    <a href="<?php echo $author_profile_link ?>">
									<?php echo get_avatar(get_the_author_meta('ID')); ?>
									</a>
								</div>
								<div class="author-bio">
								    <a href="<?php echo $author_profile_link ?>">
									<strong class="title"><?php echo $post_author_name ?></strong>
									</a>
									<p><?php echo $user_bio ?></p>
								</div>
							</div>
						</article>
			</div>
		</main>

            <?php
            if (comments_open() || get_comments_number()):
                comments_template();
            endif;


            ?>
    </div>
    <?php
}

