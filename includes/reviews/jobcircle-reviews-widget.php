<?php 
class JobCircle_Dashboard_Reviews_Widget{
    public $jobcircle_comments_per_page;
    public function __construct() {
       
        $this->jobcircle_comments_per_page = get_option('posts_per_page');
        add_action('jobcircle_dashboard_candidate_reviews_html', array($this, 'jobcircle_reviews_listing'), 10, 2);
        add_action('jobcircle_dashboard_employer_reviews_html', array($this, 'jobcircle_reviews_listing'), 10, 2);
    }

    public function jobcircle_reviews_listing(){
        global $jobcircle_framework_options;
        $jobcircle_review_title = isset($jobcircle_framework_options['jobcircle_review_title']) ? $jobcircle_framework_options['jobcircle_review_title'] : '';
		$jobcricle_reviews_enable = isset($jobcircle_framework_options['jobcricle_reviews_enable']) ? $jobcircle_framework_options['jobcricle_reviews_enable'] : '';
        
        if($jobcricle_reviews_enable !== 'on'){
            return false;
        }
        wp_enqueue_style('jobcircle-reviews');
        wp_enqueue_script('jobcircle-reviews');
        $jobcircle_user_id  = get_current_user_id();
        if (jobcircle_user_account_type($jobcircle_user_id) == 'employer') {
            $jobcircle_post_id    = jobcircle_user_employer_id($jobcircle_user_id);
        } else {
            $jobcircle_post_id    = jobcircle_user_candidate_id($jobcircle_user_id);
        }

        $jobcircle_current_page = max(1, get_query_var('paged'));
        $jobcircle_offset = ($jobcircle_current_page - 1) * $this->jobcircle_comments_per_page;
        $jobcircle_comment_query_args = array(
            'post_id' => $jobcircle_post_id,
            'parent' => 0,
            'status' => array('approve', 'hold'),
            'count' => true,
        );        
        // Create the comment query
        $jobcircle_comment_query = new WP_Comment_Query;
        $jobcircle_total_approved_comments = $jobcircle_comment_query->query($jobcircle_comment_query_args);
        $jobcircle_total_pages = ceil($jobcircle_total_approved_comments / $this->jobcircle_comments_per_page);

        $jobcircle_post_type    = get_post_type($jobcircle_post_id);
        $jobcircle_post_author_id = get_post_field('post_author', $jobcircle_post_id);
        $jobcircle_args = array(
            'post_id' => $jobcircle_post_id,
            'status' => array('approve', 'hold'),
            'parent' => 0,
            'number' => $this->jobcircle_comments_per_page,
            'offset' => 0,
            'orderby' => 'comment_date',
            'order' => 'DESC',
        );
        $jobcircle_parent_comments = get_comments($jobcircle_args);
        ob_start();
        ?>
        <div class="jobcircle-reviews-section jobcircle-dashboard-box">
            <div class="jobcircle-reviews-title">
                <h2><?php echo esc_html($jobcircle_review_title);?></h2>
            </div>
            <div class="jobcircle-reviews-listing jobcircle-reviews-listing">
                <div class="row">
                    <?php
                    $jobcircle_args = array(
                        'jobcircle_post_id'  => $jobcircle_post_id,
                        'jobcircle_post_type'  => $jobcircle_post_type,
                        'jobcircle_post_author_id'  => $jobcircle_post_author_id,
                        'jobcircle_user_id'  => $jobcircle_user_id,
                    );

                    if($jobcircle_parent_comments){
                        foreach ($jobcircle_parent_comments as $jobcircle_comment) {
                            $jobcircle_args['jobcircle_comment']    = $jobcircle_comment;
                            do_action('jobcircle_reviews_list_item', $jobcircle_args);
                        }
                    } else {
                        ?>
                        <div class="col-md-12 mb-4 jobcircle-no-review">
                            <div class="card">
                                <div class="card-body">
                                    <p><?php esc_html_e('There are no revewis', 'jobcircle-iframe');?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php 
             if ($jobcircle_total_pages > 1) {
                echo '<div class="jobcircle-loaremore-pagination">';
                echo '<a href="javascript:void(0)" class="btn btn-secondary btn-sm jobcircle-load-more-comments" data-screen_type="page" data-page_number="2" data-total_pages="'.intval($jobcircle_total_pages).'" data-post_id="'.intval($jobcircle_post_id).'">'.esc_html__('Load More Reviews', 'jobcircle-iframe').'</a>';
                echo '</div>';
            }
            do_action('jobcircle_review_reply_form', $jobcircle_args);
            ?>
        </div>
        <?php
    }


}
new JobCircle_Dashboard_Reviews_Widget();