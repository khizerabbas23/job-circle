<?php
ob_start(); ?>
<header class="header header-theme-1">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <!-- main menu -->
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-flex">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <!-- navigation -->
                <ul class="navigation">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {   ?>
                        <li class="text-login"><a href="#" data-bs-toggle="modal" data-bs-target="#login"><?php echo esc_html_e('Login', 'jobcircle-frame'); ?></a></li>
                    <?php      } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }   
                        
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                        <li class="text-login <?php echo jobcircle_esc_the_html($lgncls); ?>"><a href="<?php echo jobcircle_esc_the_html($account_page_url) ?>"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></a></li>
                    <?php    }  
                    if (!is_user_logged_in()) {  ?>
                    
                    <li><a class="btn btn-green btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                  <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }       ?>
                    <li><a class="btn btn-green btn-sm" href="<?php echo jobcircle_esc_the_html($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                  <?php 
                    }
                  }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);      ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php $style2 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-2">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-flex">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <ul class="navigation">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {          ?>
                        <li class="text-login"><a href="#" data-bs-toggle="modal" data-bs-target="#login"><?php echo esc_html_e('Login', 'jobcircle-frame'); ?></a></li>
                    <?php       } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }      
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                        <li class="text-login <?php echo jobcircle_esc_the_html($lgncls); ?>"><a href="<?php echo jobcircle_esc_the_html($account_page_url) ?>"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></a></li>
                    <?php    } 
                     if (!is_user_logged_in()) {  ?>
                     <li><a class="btn btn-dark-yellow btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a></li>
                   <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }       ?>
                    <li><a class="btn btn-dark-yellow btn-sm" href="<?php echo jobcircle_esc_the_html($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php
                    }
                   }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php $style3 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-4">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <div class="user-box">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {      ?>
                    <a href="#" class="user-link" data-bs-toggle="modal" data-bs-target="#login"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/lines.svg" width="23" alt="lines"></a>
                    <?php        } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }                     ?>
                     <a href="<?php echo jobcircle_esc_the_html($account_page_url) ?>"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/lines.svg" width="23" alt="lines"></a>
                    <?php    } 
                    if (!is_user_logged_in()) {  ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                      $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                      $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                      $account_pst_url = '';
                      if ($account_post_id > 0) {
                          $account_pst_url = get_permalink($account_post_id);
                      }   ?>
                    <a href="<?php echo jobcircle_esc_the_html($account_pst_url) ?>" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);     ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $style4 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-5">
    <div class="top-bar bg-light-sky pt-15 pb-15 d-none d-lg-block">
        <div class="container d-block">
            <div class="row justify-content-center justify-content-lg-end">
                <div class="col-12 col-md-7 d-flex align-items-center justify-content-lg-end">
                    <strong class="hotline">
                        <i class="jobcircle-icon-hotline"></i>
                        <?php esc_html_e('Hotline:') ?> <a href="tel:<?php echo jobcircle_esc_the_html($number) ?>"> <?php echo jobcircle_esc_the_html($number) ?></a>
                    </strong>
                    <ul class="list-inline social-links-top m-0">
                        <li class="list-inline-item">
                            <a href="<?php echo jobcircle_esc_the_html($insta) ?>"><i style="font-weight:bold;" class="jobcircle-icon-instagram"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo jobcircle_esc_the_html($facebook) ?>"><i class="jobcircle-icon-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo jobcircle_esc_the_html($twitter) ?>"><i class="jobcircle-icon-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo jobcircle_esc_the_html($linkedin) ?>"><i class="jobcircle-icon-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-lg-flex align-items-center justify-content-between">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <div class="user-box d-lg-flex">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {      ?>
                    <a href="#" class="btn btn-outline-gray" data-bs-toggle="modal" data-bs-target="#login"><i class="jobcircle-icon-user"></i></a>
                    <?php } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        } 
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                    <a class="btn btn-outline-gray <?php echo jobcircle_esc_the_html($lgncls); ?>" href="<?php echo jobcircle_esc_the_html($account_page_url) ?>"><i class="jobcircle-icon-user"></i></a>
                    <?php   } 
                    if (!is_user_logged_in()) {  ?>
                    <a class="btn btn-green btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }   ?>
                    <a class="btn btn-green btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $style5 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-3">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-flex">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <ul class="navigation ">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {        ?>
                        <li class="text-login"><a class="login-link" href="#" data-bs-toggle="modal" data-bs-target="#login"><?php echo esc_html_e('Login', 'jobcircle-frame'); ?></a></li>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }    
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                        <li class="text-login"><a class="login-link" href="<?php echo ($account_page_url) ?>"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></a></li>
                    <?php    } 
                    if (!is_user_logged_in()) {  ?>
                    <li><a class="btn btn-brown btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a></li>
                     <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    } ?>
                    <li><a class="btn btn-brown btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php
                    }
                     }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php $style6 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-7">
    <div class="top-bar d-none d-lg-block">
        <div class="container d-flex justify-content-between">
            <div class="subscribe">
                <span class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icon_bell.png" alt="img"></span>
                <span class="subs_text"><?php echo jobcircle_esc_the_html($sevalert); ?> <a href="<?php echo jobcircle_esc_the_html($seveml); ?>"><?php echo jobcircle_esc_the_html($seveml); ?></a></span>
            </div>
            <div class="hotline_wrap d-flex align-items-center">
                <strong class="hotline">
                    <i class="jobcircle-icon-hotline"></i>
                    <?php echo esc_html_e('Hotline:') ?> <a href="tel:<?php echo jobcircle_esc_the_html($sevnumb); ?>"><?php echo jobcircle_esc_the_html($sevnumb); ?></a>
                </strong>
                <ul class="list-inline social-links-top m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo jobcircle_esc_the_html($sevinsta); ?>"><i class="jobcircle-icon-instagram"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo jobcircle_esc_the_html($sevfburl); ?>"><i class="jobcircle-icon-facebook"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo jobcircle_esc_the_html($sevtwturl); ?>"><i class="jobcircle-icon-twitter"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo jobcircle_esc_the_html($sevlnkdn); ?>"><i class="jobcircle-icon-linkedin"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-lg-flex align-items-center justify-content-end">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <div class="user-box d-lg-flex">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {        ?>
                    <a href="#" class="btn btn-outline-gray" data-bs-toggle="modal" data-bs-target="#login"><i class="jobcircle-icon-user"></i></a>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                    ?>
                    <a class="btn btn-outline-gray <?php echo jobcircle_esc_the_html($lgncls); ?>" href="<?php echo ($account_page_url) ?>"><i class="jobcircle-icon-user"></i></a>
                    <?php    }  
                    if (!is_user_logged_in()) {  ?>
                    <a class="btn btn-green btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }  ?>
                    <a class="btn btn-green btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $style7 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-8">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-flex">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <ul class="navigation">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {        ?>
                        <li class="text-login"><a class="btn btn-login" href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="jobcircle-icon-user"></i></a></li>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }    
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                        <li class="text-login <?php echo jobcircle_esc_the_html($lgncls); ?>"><a class="btn btn-login" href="<?php echo ($account_page_url) ?>"><i class="jobcircle-icon-user"></i></a></li>
                    <?php    }  
                     if (!is_user_logged_in()) {  ?>
                     <li><a class="btn btn-orange btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }   ?>
                    <li><a class="btn btn-orange btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php $style8 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-9 page-theme-9">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-flex">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <ul class="navigation">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {        ?>
                        <li class="text-login"><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i>
						<span class="text"><?php echo esc_html_e('Register & Login', 'jobcircle-frame'); ?></span></a></li>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }  
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                        <li class="text-login <?php echo jobcircle_esc_the_html($lgncls); ?>"><a href="<?php echo ($account_page_url) ?>"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i>
						<span class="text"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></span></a></li>
                    <?php    } 
                    if (!is_user_logged_in()) {  ?>
                    <li><a class="btn btn-blue btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }  ?>
                    <li><a class="btn btn-blue btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);   ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php $style9 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-10 bg-white">
    <div class="container">
        <strong class="logo d-lg-none">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <strong class="logo d-none d-md-block">
                    <?php echo jobcircle_esc_the_html($logo_style); ?>
                </strong>
                <div class="user-box">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {       ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login" class="user-link"><i class="jobcircle-icon-user"></i><span class="d-none d-lg-block"><?php echo esc_html_e('Register & Login', 'jobcircle-frame'); ?></span></a>
                  <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        } 
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                <a href="<?php echo ($account_page_url) ?>" class="<?php echo jobcircle_esc_the_html($lgncls); ?> user-link"><i class="jobcircle-icon-user"></i><span class="d-none d-lg-block"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></span></a></li>
                    <?php    }
                    if (!is_user_logged_in()) {  ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                     <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }    ?>
            <a href="<?php echo ($account_pst_url) ?>" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php
                    }
                     }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $style10 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-6">
    <div class="container">
        <strong class="logo d-block">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <?php jobcircle_header_navigation() ?>
                <div class="user-box d-lg-flex">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {    ?>
                    <a class="login-link" href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="jobcircle-icon-user"></i><?php echo esc_html_e('Login', 'jobcircle-frame'); ?></a>
                    <?php  } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }  
                         $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                    <a class="login-link <?php echo jobcircle_esc_the_html($lgncls); ?>" href="<?php echo ($account_page_url) ?>"><i class="jobcircle-icon-user"></i><?php echo esc_html_e('Account', 'jobcircle-frame'); ?></a>
                    <?php  }
                    if (!is_user_logged_in()) {  ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                   
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    } ?>
                    <a href="<?php echo ($account_pst_url) ?>" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('+ Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);   ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php $style11 = ob_get_clean();
ob_start();
?>
<header class="header header-theme-11">
    <div class="container">
        <strong class="logo d-lg-none">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <!-- main menu -->
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <!-- navigation -->
                <?php jobcircle_header_navigation() ?>

                <strong class="logo d-none d-lg-block">
                    <?php echo jobcircle_esc_the_html($logo_style); ?>
                </strong>
                <div class="user-box">
                    <?php
                    ob_start();
                    if (!is_user_logged_in()) {    ?>
                    <a class="user-link lgn-cls" href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="jobcircle-icon-user"></i><span class="d-none d-lg-block"><?php echo esc_html_e('Register & Login', 'jobcircle-frame'); ?></span></a>
                    <?php  } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }  
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                    <a class="user-link <?php echo jobcircle_esc_the_html($lgncls); ?>" href="<?php echo ($account_page_url) ?>"><i class="jobcircle-icon-user"></i><span class="d-none d-lg-block"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></span></a>
                    <?php  } 
                    if (!is_user_logged_in()) {  ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                     <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                     $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                     $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                     $account_pst_url = '';
                     if ($account_post_id > 0) {
                         $account_pst_url = get_permalink($account_post_id);
                     }   ?>
                    <a href="<?php echo ($account_pst_url) ?>" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php
                    }
                     }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);   ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $style12 = ob_get_clean();
ob_start();   ?>
<header class="header header-theme-13">
			<div class="top-bar d-none d-lg-block">
				<div class="container d-block">
					<div class="row justify-content-center">
						<div class="col-12 col-md-6 d-flex align-items-center justify-content-lg-start">
							<ul class="list-inline contact-links m-0">
								<li class="list-inline-item">
									<i class="jobcircle-icon-phone"></i>
									<a href="tel:<?php echo jobcircle_esc_the_html($thrnumb); ?>"><?php echo jobcircle_esc_the_html($thrnumb); ?></a>
								</li>
								<li class="list-inline-item">
									<i class="jobcircle-icon-email"></i>
									<a href="mailto:<?php echo jobcircle_esc_the_html($thremail); ?>"><?php echo jobcircle_esc_the_html($thremail); ?></a>
								</li>
							</ul>
						</div>
						<div class="col-12 col-md-6 d-flex align-items-center justify-content-lg-end">
							<ul class="list-inline social-links-top m-0">
								<li class="list-inline-item">
									<a href="<?php echo jobcircle_esc_the_html($thrfb); ?>"><i class="jobcircle-icon-facebook"></i></a>
								</li>
								<li class="list-inline-item">
									<a href="<?php echo jobcircle_esc_the_html($thrytb); ?>"><i class="jobcircle-icon-youtube"></i></a>
								</li>
								<li class="list-inline-item">
									<a href="<?php echo jobcircle_esc_the_html($thrinsta); ?>"><i class="jobcircle-icon-instagram"></i></a>
								</li>
								<li class="list-inline-item">
									<a href="<?php echo jobcircle_esc_the_html($thrlink); ?>"><i class="jobcircle-icon-linkedin"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<strong class="logo">
                <?php echo jobcircle_esc_the_html($logo_style); ?>
				</strong>
				<!-- main menu -->
				<div class="main-nav">
					<a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
					<div class="nav-drop">
						<a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
						<!-- navigation -->
                        <?php jobcircle_header_navigation() ?>						
						<div class="user-box">
                        <?php
                    ob_start();
                    if (!is_user_logged_in()) {  ?>
                    <a href="#" data-bs-toggle="modal" class="user-link" data-bs-target="#login"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i></a>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }  
                        
                        ?>
                    <a class="user-link lgn-cls" href="<?php echo ($account_page_url) ?>"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i></a>
                    <?php   } 
                    if (!is_user_logged_in()) {  ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }   ?>
                    <a href="<?php echo ($account_pst_url) ?>" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php 
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>

                </div>
					</div>
				</div>
			</div>
		</header>
<?php $style13 = ob_get_clean();
ob_start();   ?>
<header class="header header-theme-14 page-theme-14">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <!-- main menu -->
        <div class="main-nav">
			<a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
			<div class="nav-drop">
				<a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <!-- navigation -->
                <?php jobcircle_header_navigation(); 
                ob_start();
                if (!is_user_logged_in()) {    ?>                    
                    <a href="#" class="text-login space d-none d-lg-flex" data-bs-toggle="modal" data-bs-target="#login">
                        <i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i><span class="text"><?php echo esc_html_e('Login', 'jobcircle-frame'); ?></span></a>
                <?php  } else {
                    global $jobcircle_framework_options;
                    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                    $account_page_url = '';
                    if ($account_page_id > 0) {
                        $account_page_url = get_permalink($account_page_id);
                    } 
                    $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                    ?>
                    <a href="<?php echo ($account_page_url) ?>" class="<?php echo jobcircle_esc_the_html($lgncls); ?> text-login space d-none d-lg-flex"><i class="icon">
                            <img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i>
                        <span class="text"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></span></a>
                <?php  } 
                 if (!is_user_logged_in()) {  ?>
                 <a class="btn btn-green btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                <?php }else{
                $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	} 
                    }
                    if ($show_button == true) {
                  $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                  $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                  $account_pst_url = '';
                  if ($account_post_id > 0) {
                      $account_pst_url = get_permalink($account_post_id);
                  }   ?>
                <a class="btn btn-green btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                <?php
                    }
                    }
                $btns_html = ob_get_clean();
                echo apply_filters('jobcircle_header_right_btns_html', $btns_html);   ?>                
            </div>
        </div>
    </div>
</header>
<?php  $style14 = ob_get_clean();
ob_start();   ?>
<header class="header header-theme-15">
			<div class="container">
				<strong class="logo d-lg-none">
                <?php echo jobcircle_esc_the_html($logo_style); ?>
				</strong>
				<!-- main menu -->
				<div class="main-nav">
					<a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
					<div class="nav-drop">
						<a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
						<strong class="logo d-none d-lg-block">
                        <?php echo jobcircle_esc_the_html($logo_style); ?>
						</strong>
						<!-- navigation -->
                        <?php jobcircle_header_navigation() ?>						
						<div class="user-box">
                        <?php
                    ob_start();
                    if (!is_user_logged_in()) {        ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login"><button class="btn btn-sm btn-user" type="button"><i class="jobcircle-icon-user"></i>
                    <span class="btn-text d-none d-lg-block"><?php echo esc_html_e('Login & Register', 'jobcircle-frame'); ?></span></button></a>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        } 
                         $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                    <a href="<?php echo ($account_page_url) ?>"><button class="btn btn-sm btn-user <?php echo jobcircle_esc_the_html($lgncls); ?>" type="button"><i class="jobcircle-icon-user"></i>
					<span class="btn-text d-none d-lg-block"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></span></button></a>
                    <?php    }  
                    if (!is_user_logged_in()) {  ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login"><button class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></button></a>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }  ?>
                    <a href="<?php echo ($account_pst_url) ?>"><button class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></button></a>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);   ?>
						</div>
					</div>
				</div>
			</div>
		</header>
<?php  $style15 = ob_get_clean();
ob_start();   ?>
<header class="header header-theme-16 page-theme-16">
			<div class="container">
				<strong class="logo">
                <?php echo jobcircle_esc_the_html($logo_style); ?>
				</strong>
				<!-- main menu -->
				<div class="main-nav">
					<a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
					<div class="nav-drop">
						<a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
						<!-- navigation -->
                        <?php jobcircle_header_navigation() ?>
						<ul class="navigation">
                        <?php
                    ob_start();
                    if (!is_user_logged_in()) {        ?>
                        <li class="text-login"><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i><span class="text"><?php echo esc_html_e('Login &amp; Register', 'jobcircle-frame'); ?></span></a></li>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        } 
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                        <li class="text-login <?php echo jobcircle_esc_the_html($lgncls); ?>"><a href="<?php echo ($account_page_url) ?>"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i><span class="text"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></span></a></li>
                    <?php    } 
                    if (!is_user_logged_in()) {  ?>
                    <li><a class="btn btn-pink btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }   ?>
                    <li><a class="btn btn-pink btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);   ?>
							
						</ul>
					</div>
				</div>
			</div>
		</header>
<?php  $style16 = ob_get_clean();
ob_start();   ?>
<header class="header header-theme-17 page-theme-17">
			<div class="top-bar d-none d-lg-block">
				<div class="container d-flex justify-content-between">
					<div class="subscribe">
						<span class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icon_bell2.svg" alt="img"></span>
						<span class="subs_text"><?php echo jobcircle_esc_the_html($sevtnalrt); ?> <a href="<?php echo jobcircle_esc_the_html($sevtneml); ?>"><?php echo esc_html__('email!', 'jobcircle-frame'); ?> </a></span>
					</div>
					<div class="contact-options">
						<div class="hold">
							<span class="icon">
								<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icon_phone.svg" alt="icon">
							</span>
							<a href="tel:<?php echo jobcircle_esc_the_html($sevtnnmbr); ?>" class="text"><?php echo jobcircle_esc_the_html($sevtnnmbr); ?></a>
						</div>
						<div class="hold">
							<span class="icon">
								<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/icon_mail.svg" alt="icon">
							</span>
							<a href="mailto:<?php echo jobcircle_esc_the_html($sevtndmneml); ?>" class="text"><?php echo jobcircle_esc_the_html($sevtndmneml); ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<strong class="logo">
                <?php echo jobcircle_esc_the_html($logo_style); ?>
				</strong>
				<!-- main menu -->
				<div class="main-nav">
					<a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
					<div class="nav-drop">
						<a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
						<!-- navigation -->
                        <?php jobcircle_header_navigation() ?>
						<ul class="navigation">
                <?php
                        ob_start();
                    if (!is_user_logged_in()) {        ?>
                        <li class="text-login"><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i><span class="text"><?php echo esc_html_e('Login & Register', 'jobcircle-frame'); ?></span></a></li>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        }  
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>
                        <li class="text-login <?php echo jobcircle_esc_the_html($lgncls); ?>"><a href="<?php echo ($account_page_url) ?>"><i class="icon"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/login_user.svg" alt=""></i><span class="text"><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></span></a></li>
                    <?php    } 
                    if (!is_user_logged_in()) {  ?>
                    <li><a class="btn btn-orange btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                    $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                    $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                    $account_pst_url = '';
                    if ($account_post_id > 0) {
                        $account_pst_url = get_permalink($account_post_id);
                    }  ?>
                    <li><a class="btn btn-orange btn-sm" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);   ?>	

						</ul>
					</div>
				</div>
			</div>
		</header>
<?php  $style17 = ob_get_clean();
ob_start();   ?>
<header class="header header-theme-12">
			<div class="container">
				<strong class="logo d-block">
                <?php echo jobcircle_esc_the_html($logo_style); ?>
				</strong>
				<!-- main menu --> 
				<div class="main-nav">
					<a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
					<div class="nav-drop">
						<a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
						<!-- navigation -->
                        <?php jobcircle_header_navigation() ?>
						<div class="user-box d-lg-flex">
                        <?php
                    ob_start();
                    if (!is_user_logged_in()) {  ?>                    
                    <a href="#" class="user-link" data-bs-toggle="modal" data-bs-target="#login"><i class="jobcircle-icon-user"></i><span class="d-none d-lg-block"><?php echo esc_html_e('Login/Register', 'jobcircle-frame'); ?></span></a>
                    <?php    } else {
                        global $jobcircle_framework_options;
                        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                        $account_page_url = '';
                        if ($account_page_id > 0) {
                            $account_page_url = get_permalink($account_page_id);
                        } 
                        $lgncls = '';
                        if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$lgncls = "lgn-cls";
                    	}
                     }
                        ?>                    
                    <a href="<?php echo ($account_page_url) ?>" class="user-link <?php echo jobcircle_esc_the_html($lgncls); ?>"><i class="jobcircle-icon-user"></i><span class="d-none d-lg-block"><?php echo esc_html_e('Account', 'jobcircle-frame'); ?></span></a>
                    <?php   } 
                     if (!is_user_logged_in()) {  ?>
                     <a href="#" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php }else{
                    $show_button = true;
                    if (is_user_logged_in()) {
                    	$user_id = get_current_user_id();
                    	$employer_id = jobcircle_user_employer_id($user_id);
                    
                    	if (!$employer_id) {
                    		$show_button = false;
                    	}
                    }
                    if ($show_button == true) {
                     $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                     $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                     $account_pst_url = '';
                     if ($account_post_id > 0) {
                         $account_pst_url = get_permalink($account_post_id);
                     } ?>
                    <a href="<?php echo ($account_pst_url) ?>" class="btn btn-sm" type="submit"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a>
                    <?php
                    }
                    }
                    $btns_html = ob_get_clean();
                    echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
						</div>
					</div>
				</div>
			</div>
		</header>
<?php  $style60 = ob_get_clean();
ob_start();   ?>
<header class="header header-theme-1">
    <div class="container">
        <strong class="logo">
            <?php echo jobcircle_esc_the_html($logo_style); ?>
        </strong>
        <!-- main menu -->
        <div class="main-nav">
            <a href="#" class="nav-opener d-flex d-lg-none"><span></span></a>
            <div class="nav-drop d-flex">
                <a href="#" class="nav-close d-flex d-lg-none"><span></span></a>
                <!-- navigation -->
                <?php
                jobcircle_header_navigation();
                global $jobcircle_framework_options;
                $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                $account_page_url = '';
                if ($account_page_id > 0) {
                    $account_page_url = get_permalink($account_page_id);
                }
                if ($account_page_url != '') {
                    ?>
                    <ul class="navigation">
                        <?php
                        ob_start();
                        if (!is_user_logged_in()) {  ?>
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="jobcircle-icon-user icostyle logo-eighteen"></i><?php echo esc_html_e('Login/Register', 'jobcircle-frame'); ?></a></li>
                            <?php
                        } else {
                            
                            $lgncls = '';
                            if (is_user_logged_in()) {
                                $user_id = get_current_user_id();
                                $employer_id = jobcircle_user_employer_id($user_id);
                            
                                if (!$employer_id) {
                                    $lgncls = "lgn-cls";
                                }
                            }
                            ?>
                            <li class="<?php echo jobcircle_esc_the_html($lgncls); ?>"><a href="<?php echo ($account_page_url) ?>"><i class="jobcircle-icon-user icostyle logo-eighteen"></i><?php echo esc_html_e('My Account', 'jobcircle-frame'); ?></a></li>
                            <?php
                        } 
                        if (!is_user_logged_in()) {  ?>
                        
                            <li><a class="btn btn-info" href="#" data-bs-toggle="modal" data-bs-target="#login"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                            <?php
                        } else {
                            $show_button = true;
                            if (is_user_logged_in()) {
                                $user_id = get_current_user_id();
                                $employer_id = jobcircle_user_employer_id($user_id);
                            
                                if (!$employer_id) {
                                    $show_button = false;
                                }
                            }
                            if ($show_button == true) {
                                $post_new_job = isset($jobcircle_framework_options['post_new_job_page']) ? $jobcircle_framework_options['post_new_job_page'] : '';
                                $account_post_id = jobcircle_get_page_id_from_name($post_new_job);
                                $account_pst_url = '';
                                if ($account_post_id > 0) {
                                    $account_pst_url = get_permalink($account_post_id);
                                } ?>
                                <li><a class="btn btn-info" href="<?php echo ($account_pst_url) ?>"><span class="btn-text"><?php echo esc_html_e('Post a Job', 'jobcircle-frame'); ?></span></a></li>
                                <?php 
                            }
                        }
                        $btns_html = ob_get_clean();
                        echo apply_filters('jobcircle_header_right_btns_html', $btns_html);    ?>
                    </ul>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</header>
<?php $style1 = ob_get_clean();
?>