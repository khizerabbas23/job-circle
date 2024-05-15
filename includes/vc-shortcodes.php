<?php

add_action('vc_before_init', 'jobcircle_row_add_view_param');

function jobcircle_row_add_view_param() {

    $attributes = array(
        'type' => 'dropdown',
        'heading' => esc_html__("Row View", "jobcircle-frame"),
        'param_name' => 'jobcircle_container',
        'value' => array(esc_html__("Box", "jobcircle-frame") => 'box', esc_html__("Wide", "jobcircle-frame") => 'wide'),
        'description' => ''
    );

    if (function_exists('vc_add_param')) {
        vc_add_param('vc_row', $attributes);
    }
}

// job pages
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/grow-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-column.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/discover-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/trending-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/feature-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/freelance-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/open-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/great-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/easiest-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/clean-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/modern-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/suite-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/talent-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/demand-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/fit-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/deserve-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/classic-job.php';


// Home 1
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/jobcircle-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/populor-cat.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/get-your-profile.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/talented-team.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/stay-linked.php';  
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/latest-news.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/subscribe.php';


// Home 2
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/popular-feature-job-post.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/interest-article.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/feature-testimonial.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidiate-job.php';

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/contact-address.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/contact-form.php';
//Home Page 2
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/how-its-works.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/explore.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/say-about-us.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/download-app.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-two-how-its-work.php';

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/search-banner.php';

//About Section
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/about-section-unique-experience.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/about-section-what-we-provide.php';

// Home Page 3
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/your-dream-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-three-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/theme-three-how-it-work.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/best-companies.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/feature-city.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-three-what-can-i-do.php';

// Home Page 4
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/tranding-categories.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/browse-our-job-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/popular-search.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/most-popular-candidates-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/how-it-work-home-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/popular-cities-work.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/our-client-review-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/our-client-review.php';

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-banner-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/recent-articles-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/looking-for-a-carrier-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/app-available-now-four.php';
// Home Page 6
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-explore.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-explore-jobs.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-newsletter.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-pricing-package.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-news-block.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-customer.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-six-popular-cities.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/company-style-one.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/Company-list-style.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/company-grid-style.php';


//

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/jobcircle-blog-detail-post.php';


require JOBCIRCLE_ABSPATH . 'includes/shortcodes/theme-three-newsletter.php';
//require JOBCIRCLE_ABSPATH . 'includes/shortcodes/what-can-i.php';
//Blog Post
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/jobcircle-blog-post.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-posts.php';
//company list
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/company-list.php';


 
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-portfolio.php';
//Home Page 5
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-five-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-five-testimonial.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/companies-logo.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/great-employe-resume.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-five-how-it-work.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-five-candidate-post.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/top-company-registerd-seven.php';

//Home Page 7

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/banner-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/download-the-app-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/recent-articles-home-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/what-our-customer-says-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/how-its-works-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/find-top-tallent-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/featured-job-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/popular-jobs-category-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/jobcircle-blog-style-one.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-banner-section.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-theme-candi-post.php'; 
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-three-theme-one.php'; 
//Home Page 8

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/trusted-by-world-best.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/explore-a-faster.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/best-talented-team.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/download-our-mobile-app.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-eight-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/recent-news-post-eight.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/demanding-category-eight.php';

//Home Page 9

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/banner-nine.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-nine-how-its-work.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/client-testimonials.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/hnin-feature-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-nin-over-recruite.php';

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-nine-featured-candidates.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-nine-job-waiting.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-nine-app-avialable.php';

//Home Page 11

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/helvn-download-the-app.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/market-place-h-eleven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/most-viewed-h-eleven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/banner-h-eleven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/kind-words-from-happys.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/counter-h-eleven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/helvn-our-latest-news.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/helevn-talent-by-categories.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/trending-service-h-eleven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/companies-logo-heleven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/helvn-latest-jobs.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/people-love-to-learn-helvn.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/modernize-fourteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/help-full-question.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/twelv-candidates.php';
//Home Page 13

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-banner-thirteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/browse-category-hthirteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/search-millions-of-jobs.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/featured-jobs-hthirteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/find-worlds-best-remote.php';

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/best-companies-hthirteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/transparent-pricing-thirteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/latest-candidate-hthirteen.php';




//Home Page 14

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/feature-job-fourteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/remotely-dream-job-fourteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/popular-job-category-fourteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/how-to-job-search-fourteen.php';

//Home Page 15

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-fifteen-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-fifteen-demanding-cat.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-fifteen-find-top-talent.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-fifteen-how-its-work.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/top-experts-home-fifteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/get-matched-home-fifteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/client-saying-home-fifteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/recent-artical-home-fifteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/companies-home-fifteen.php';





//Home Page 16 

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-sixteen-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-sixteen-demanding-cat.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-sixteen-get-over-expert.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-sixteen-counter.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-sixteen-latest-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-sixteen-recent-candidate.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/hsixteen-brand-offer.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/hsixteen-get-started.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/hsixteen-job-portal.php';


//Home Page 17

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-banner-seventeen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-seventeen-company-logo.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/featured-job-seventeen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/get-job-discover-seventeen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-seventeen-browse-by-cat.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-make-resume-seventeen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-usa-job-seventeen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-client-reviews-seventeen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-three-theme-one-left-filter-top.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-three-theme-one-left-filter-top.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-three-theme-one.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-three-theme-one-left-map.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-three-theme-one-left-map.php';






require JOBCIRCLE_ABSPATH . 'includes/shortcodes/recent-artical-seventeen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/transparent-pricing-seventeen.php';

//Candidate Views
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-dview.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-demandview.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-greatview.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-openview.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-talentview.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-trendingview.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-search-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/blog-search-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-green-sub-header.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/company-search-banner.php';




//FAQ's
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/faq-main-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/faq-dont-get-your-answer.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/question-and-answer.php';

// Comapny Detail 
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/our-office-gallery.php';


//Contact Form
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/contact-form-two.php';


// Pricing Plane
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/pricing-page-pkg-one.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/pricing-page-pkg-two.php';





// Home 10
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/how-we-help-home-ten.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/latest-jobs-ten.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/browse-category-ten.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/home-ten-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-ten-our-recruiters.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/h-ten-counter-numbers.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/recent-news-ten.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/companies-activety.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/start-recuriting.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/pricing-home-ten.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/get-hired-top-companies.php';


//Home 12
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/htwlv-home-banner.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/htwlv-explore-faster.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/htwlv-populor-job.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/htwlv-job-location.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/htwlv-job-categories.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/htwlv-over-recruiter.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/htwlv-recent-articles.php';


// Home 14

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/upload-cv-fourteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/jobs-are-waiting-fourteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-articles-news-fourteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/banner-fourteen.php';

// candidates2 theme 1
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidates-cond.php';

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidates-theme-two-candi.php';


//our blog 2
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/our-blog-two.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/blog-download-app.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/account-page.php';

// Sub Header 

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/green-sub-header.php';



// Job List Pages
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-two.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-three.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-five.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-six.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-one-twelve.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-one-thrteen.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-tp-map.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/candidate-filter-page.php';



// job grid Pages
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-one.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-two.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-three.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-four.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-five.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-five-top-search.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-six.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-grid-seven.php';

//home 60
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/banner-sixty.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/our-latest-jobs-sixty.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/broswe-telent-category-sixty.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/trending-services-sixty.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/world-best-marketplace-sixty.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/most-viewed-sixty.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/recent-news-artical-sixty.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/download-the-app-sixty.php';

// about us theme 1
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/about-our-company.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/counter-coustomiser.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/company-leadership.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/how-it-works-aboutus.php';


//All Blog Pages
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/blog-three.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/modern-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/classic-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/fits-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/fits-blog-sidebar.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/dream-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/dream-blog-sidebar.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/deserve-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/easiest-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/experts-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/expert-blog-sidebar.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/open-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/freelance-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/featured-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/discover-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/discover-blog-sidebar.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/grow-blog.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/suite-blog.php';


// Job List
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-seven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-nine.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-ten.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-eleven.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/job-list-two-map.php';

//job detail 
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/similar-jobs.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/opne-position.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/clint-review.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/portfolio.php';

require JOBCIRCLE_ABSPATH . 'includes/shortcodes/employer-team-members.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/notifications.php';
require JOBCIRCLE_ABSPATH . 'includes/shortcodes/trending-category-fifteen.php';