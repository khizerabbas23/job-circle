<?php

add_filter('jobcircle_comments_form_markup', function () {
    ob_start();
    ?>
   	<div id="comments">
   	    <div class="section-details section-comments">
    	<?php
        	/**
        	 * jobcircle_inside_comments hook.
        	 *
        	 */
        	do_action( 'jobcircle_inside_comments' );
        
        	if ( have_comments() ) :
        		$comments_number = get_comments_number();
        		$comments_title = apply_filters(
        			'jobcircle_comment_form_title',
        			sprintf(
        				esc_html(
        					/* translators: 1: number of comments, 2: post title */
        					_nx(
        						'%1$s Comments &ldquo;%2$s&rdquo;',
        						'%1$s Comments',
        						$comments_number,
        						'comments title',
        						'jobcircle'
        					)
        				),
        				number_format_i18n($comments_number),
        				get_the_title()
        			)
        		);
        
        		// phpcs:ignore -- Title escaped in output.
        		?>
        		                  
                    <h4><?php printf(esc_html__( 'Comment (%s)', 'jobcircle-frame' ), $comments_number); ?></h4>
        		<?php
        		
        
        		/**
        		 * jobcircle_below_comments_title hook.
        		 *
        		 */
        		do_action( 'jobcircle_below_comments_title' );
        
        		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
        			?>
        			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
        				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'jobcircle-frame' ); ?></h2>
        				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'jobcircle-frame' ) ); ?></div>
        				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'jobcircle-frame' ) ); ?></div>
        			</nav><!-- #comment-nav-above -->
        		<?php endif; ?>
        
        		<div class="commentlist">
        		   
        			<?php
        			/*
        			 * Loop through and list the comments. Tell wp_list_comments()
        			 * to use jobcircle_comment() to format the comments.
        			 * If you want to override this in a child theme, then you can
        			 * define jobcircle_comment() and that will be used instead.
        			 * See jobcircle_comment() in inc/template-tags.php for more.
        			 */
        			wp_list_comments(
        				array(
        					'callback' => 'jobcircle_comments_html',
        				)
        			);
        			?>
        		</div><!-- .comment-list -->
        
        		<?php
        		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
        			?>
        			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
        				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'jobcircle-frame' ); ?></h2>
        				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'jobcircle-frame' ) ); ?></div>
        				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'jobcircle-frame' ) ); ?></div>
        			</nav><!-- #comment-nav-below -->
        			<?php
        		endif;
        
        	endif;
        
        	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
        	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        		?>
        		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'jobcircle-frame' ); ?></p>
        		<?php
        	endif;
       
            $defaults = array(
                
                'title_reply' => '
                <div class="comment-respond">
                    <h3 class="comment-reply-title">'. esc_html__('Comments','jobcircle-frame') .'</h3>
                </div>',
                'title_reply_before' => '<div class="jobcircle-title"><h2>',
                'title_reply_after' => '</h2></div>',
                'comment_notes_before' => '',
                'fields' => apply_filters('comment_form_default_fields', array(
                    'author' => '
                    
    				
                    <div class="col-12 col-md-6">
                    <p class="comment-form-author">
					<label class="d-none" for="f-name">' . esc_html__('First Name') . '</label>
                    <input name="yourname" class="form-control" placeholder="' . esc_html__('First Name', 'jobcircle-frame') . '" required type="text" tabindex="1">
                    ' .
                    '</p>',
                    '</div>',
                   
    
                    'email' => '' .
                    '<div class="col-12 col-md-6">
                    <p class="comment-form-email">
					<label class="d-none" for="l-name">' . esc_html__('Last Name ').'<span class="required">*</span></label>					
                    <input name="email" class="form-control" type="email" placeholder="' . esc_html__('Your E-mail', 'jobcircle-frame') . '" required tabindex="2">
                    ' .
    				'</p>',
                    '</div>',   
					
					
					'subject' => '' .
                    '<div class="col-12">
                    <p class="comment-form-url">
					<label class="d-none" for="subject">' . esc_html__('Subject').'</label>				
                    <input name="text" class="form-control" type="text" placeholder="' . esc_html__('Subject', 'jobcircle-frame') . '" required tabindex="3">
                    ' .
    				'</p>',
                    '</div>',   
                        )
                ),
                'comment_field' => '
                <div class="comment-form">
                <div class="row">
                <div class="col-12">
                <p class="comment-form-comment">
				<label class="d-none" for="comment">' . esc_html__('Comment').'</label>
                <textarea name="comment" class="form-control" placeholder="' . esc_html__('Comment...', 'jobcircle-frame') . '"></textarea>
                </p>
                </div>',
    
    
    
    			'submit_button' => '
    			<div class="col-12">
				<p class="form-submit">
                <button class="btn btn-primary" type="submit">
                <span class="btn-text">' . esc_html__('Comment') . '</span>
    			</button>
                </p>
                </div>
				</div>
                    </div>'
    
    
            );
            
        	comment_form($defaults, get_the_id());
        	?>
        </div>
    </div>
		
    <?php
    $html = ob_get_clean();
    return $html;
});

function jobcircle_comments_html($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $wpdb;

	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = '<i class="fa fa-mail-reply"></i> ' . esc_html__('Reply to this comment', 'jobcircle-frame') . '';
	$args['after'] = '';
	$_comment_type = $comment->comment_type;

	switch ($_comment_type) {
		case ($_comment_type == '' || $_comment_type == 'comment') :

			$comment_time = strtotime($comment->comment_date);

			$get_author = get_comment_author();
			$author_obj = get_user_by('login', $get_author);
			?>

			<div <?php comment_class("commentlist-item"); ?> id="li-comment-<?php comment_ID(); ?>">
			    
			<div id="comment-<?php comment_ID(); ?>" class="comment">

						<?php
						$avatar_link = get_avatar_url($comment, array('size' => 83));
						if (@getimagesize($avatar_link)) {
							$avatar_link = $avatar_link;
						} else {
							$avatar_link = get_template_directory_uri() . '/images/default_avatar.jpg';
						}
						?>

						
					     <div class="avatar-holder">                         
						<img class="avatar avatar-48 photo avatar-default" src="<?php echo esc_url_raw($avatar_link); ?>" alt="">
                    </div>                      
                                           
                          <div class="commentlist-holder">
                            <p class="meta">
                            <strong><?php comment_author(); ?></strong>
                            <?php echo date_i18n(get_option('date_format'), strtotime($comment->comment_date)) ?>
							<a href="#" class="comment-reply-link">
							<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'reply_text' => __('Reply', 'jobcircle-frame'),))); ?>
							</a>
					</p>
                            <p>
							<?php comment_text(); ?>
					</p>
                        
					</div>
					</div>
					</div>
										
		

			<?php
			break;
		case 'pingback' :
		case 'trackback' :
			?>
			<li class="post pingback">
			<p><?php comment_author_link(); ?><?php edit_comment_link(esc_html__('Edit Comment', 'jobcircle-frame'), ' '); ?></p>
			<?php
			break;
	}
}