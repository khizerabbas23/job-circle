<?php
ob_start();   ?>
<footer class="footer footer-theme-1">
    <div class="pri-footer bg-dark-green text-white pt-35 pt-lg-50 pt-xxl-80 pb-35 pb-md-20">
        <div class="container">
            <div class="pri-footer-top pb-30 pb-md-35 mb-35 mb-lg-50 mb-xxl-80">
                <div class="row">
                    <div class="col-12 col-lg-3 mb-md-15 mb-lg-0">
                        <strong class="logo">
                            <a href="<?php echo home_url(); ?>"><img src="<?php echo $footstltwlog; ?>" width="174" height="43" alt="Job Circle"></a>
                        </strong>
                    </div>
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-12 col-md-6 textbox mb-15 mb-md-0">
                                <strong class="h4"><?php echo $jbprttw; ?></strong>
                                <p><?php echo $jbsbprttw; ?></p>
                            </div>
                            <div class="col-12 col-md-6 footer-buttons text-md-end">
                                <a href="<?php echo $jblookurltw; ?>" class="btn btn-outline-lt-yellow btn-sm"><span class="btn-text"><?php echo $jblooktw; ?></span></a>
                                <a href="<?php echo $jbfrjburl; ?>" class="btn btn-green btn-sm"><span class="btn-text"><?php echo $jbfrjb; ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-md-row-reverse">
                <?php echo $widget_style; ?>
            </div>
        </div>
    </div>
    <div class="sec-footer bg-dark-green text-white pt-0 pb-25 py-md-20 py-lg-45">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube-play"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style2 = ob_get_clean();
ob_start();  ?>
<footer class="footer footer-theme-2">
    <div class="pri-footer bg-dark-blue text-gray-alt pt-0 pt-lg-35 pt-xxl-0 pb-0 pb-md-35">
        <div class="container">
            <?php echo $widget_style; ?>
        </div>
    </div>
    <div class="sec-footer bg-dark-blue text-white pt-15 pb-25 py-md-20 py-lg-45">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube-play"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style3 = ob_get_clean();
ob_start();    ?>
<footer class="footer footer-theme-4">
    <div class="pri-footer text-white pt-35 pt-lg-70 pt-xl-90 pb-35 pb-md-20" style="background-image: url(<?php echo $footbgimgfr; ?>);">
        <div class="pri-footer-top pb-30 pb-md-35 pb-lg-65 mb-35 mb-lg-50 mb-xl-90">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                       
                        <strong class="h4"><?php echo $footsbfr; ?></strong>
                    </div>
                    <div class="col-12 col-md-8">
                        <p><?php echo $footnotfr; ?></p>
                        <?php echo do_shortcode('[contact-form-7 id="'. $footsubidfor .'" title="'.$footsubtltfor.'"]');?>
                        <div class="active-candidates">
                            <strong class="title"><?php echo $footcndfr; ?></strong>
                            <ul class="list-inline candidates-list">
                                <li>
                                    <a href="<?php echo $footcndoneurl; ?>"><img src="<?php echo $footcndonefr; ?>" alt=""></a>
                                </li>
                                <li>
                                    <a href="<?php echo $footcndtwurl; ?>"><img src="<?php echo $footcndtwfr; ?>" alt=""></a>
                                </li>
                                <li>
                                    <a href="<?php echo $footcndthrurl; ?>"><img src="<?php echo $footcndthrfr; ?>" alt=""></a>
                                </li>
                                <li>
                                    <a href="<?php echo $footcndfoururl; ?>"><img src="<?php echo $footcndfourfr; ?>" alt=""></a>
                                </li>
                                <li><a href="<?php echo $footcndfveurl; ?>">+</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="flex-md-row-reverse justify-content-between pb-lg-30 pb-xl-40">
                <?php echo $widget_style; ?>
            </div>
        </div>
    </div>
    <div class="sec-footer text-white pt-35 pb-35">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style4 = ob_get_clean();
ob_start();        ?>
<footer class="footer footer-theme-5">
    <div class="pri-footer text-white pt-35 pt-lg-50 pt-xxl-80 pb-35 pb-md-20" style="background-image: url(<?php echo $footbgimgfv; ?>);">
        <div class="pri-footer-top pb-30 pb-md-35 mb-35 mb-lg-50 mb-xl-90">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8 d-flex align-items-center pb-15 pb-md-0">
                        <strong class="logo">
                            <a href="<?php echo home_url(); ?>"><img src="<?php echo $footfvlogo; ?>" alt="user"></a>
                        </strong>
                        <div class="textbox">
                            <strong class="h4"><?php echo $empfive; ?></strong>
                            <p class="m-0"><?php echo $adverfive; ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-end">
                        <a href="<?php echo $jblblurlfive; ?>" class="btn btn-green btn-sm"><span class="btn-text"><?php echo $jblblfive; ?></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="flex-md-row-reverse justify-content-between pb-lg-65 pb-xl-80">
                <?php echo $widget_style; ?>
            </div>
        </div>
    </div>
    <div class="sec-footer text-white pt-35 pt-lg-50 pb-25 py-md-20 py-lg-45">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style5 = ob_get_clean();
ob_start();         ?>
<footer class="footer footer-theme-3">
    <div class="pri-footer pt-35 pt-lg-50 pt-xl-80 pb-35 pb-md-20">
        <div class="container">
            <div class="row justify-content-between pb-lg-25 pb-xl-50">
                <div class="col-12 col-lg-4 mb-35 mb-lg-0">
                    <strong class="logo">
                        <a href="<?php echo home_url(); ?>"><img src="<?php echo $footlogosix; ?>" width="175" height="43" alt="Job Circle"></a>
                    </strong>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="justify-content-between">
                        <?php echo $widget_style; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sec-footer bg-light-yellow pt-35 pt-lg-30 pb-25 pb-lg-30">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style6 = ob_get_clean();
ob_start();      ?>
<footer class="footer footer-theme-7">
    <div class="pri-footer text-white pt-35 pt-lg-50 pt-xxl-80 pb-35 pb-md-20" style="background-image: url(<?php echo $footbgimgsev; ?>);">
        <div class="pri-footer-top pb-30 pb-md-35 mb-35 mb-lg-50 mb-xl-90">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8 d-flex align-items-center pb-15 pb-md-0">
                        <strong class="logo">
                            <a href="<?php echo home_url(); ?>"><img src="<?php echo $footsevlogo; ?>" alt="user"></a>
                        </strong>
                        <div class="textbox">
                            <strong class="h2"><?php echo $empsev; ?></strong>
                            <p class="m-0"><?php echo $adversev; ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-end">
                        <a href="<?php echo $jblblurlsev; ?>" class="btn btn-green btn-sm"><span class="btn-text"><?php echo $jblblsev; ?></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="flex-md-row-reverse justify-content-between pb-lg-65 pb-xl-80">
                <?php echo $widget_style; ?>
            </div>
        </div>
    </div>
    <div class="sec-footer text-white pt-25 pb-25 py-md-30">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style7 = ob_get_clean();
ob_start();        ?>
<footer class="footer footer-theme-8">
    <div class="pri-footer bg-light-sky text-black pt-35 pt-lg-50 pt-xxl-80 pb-35 pb-md-20">
        <div class="container">
            <div class="pri-footer-top pb-30 pb-md-35 mb-35 mb-lg-50 mb-xxl-80">
                <div class="row">
                    <div class="col-12 col-lg-3 mb-md-15 mb-lg-0">
                        <strong class="logo">
                            <a href="<?php echo home_url(); ?>"><img src="<?php echo $footstltwlogeight; ?>" width="175" height="43" alt="Job Circle"></a>
                        </strong>
                    </div>
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-12 col-md-6 textbox mb-15 mb-md-0">
                                <strong class="h4"><?php echo $jbportalight; ?></strong>
                                <p><?php echo $jbsubprteight; ?></p>
                            </div>
                            <div class="col-12 col-md-6 footer-buttons text-md-end">
                                <a href="<?php echo $jblookurleight; ?>" class="btn btn-outline-orange btn-sm"><span class="btn-text"><?php echo $jblookeight; ?></span></a>
                                <a href="<?php echo $jblookforurleight; ?>" class="btn btn-orange btn-sm"><span class="btn-text"><?php echo $jblookforeight; ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-md-row-reverse">
                <?php echo $widget_style; ?>
            </div>
        </div>
    </div>
    <div class="sec-footer bg-light-sky text-black pt-0 pb-25 py-md-20 py-lg-45">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube-play"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style8 = ob_get_clean();
ob_start();      ?>
<footer class="footer footer-theme-9 page-theme-9" style="background-image: url(<?php echo $foot_nine_bgimg; ?>);">
    <div class="container">
        <div class="wrap_footer">
            <div class="subscription">
                <div class="text-holder">
                    <strong class="title"><?php echo $foot_nine_tag; ?></strong>
                    <p><?php echo $foot_nine_sub; ?></p>
                </div>
               <?php echo do_shortcode('[contact-form-7 id="'. $foot_nine_form_id .'" title="'.$foot_nine_form_titl.'"]');?>
            </div>
            <?php echo $widget_style; ?>
            <div class="bottom-footer">
                <p><?php echo $copyright; ?></p>
                <ul class="social_links">
                    <li>
                        <a href="<?php echo $footfburl; ?>">
                            <i class="jobcircle-icon-facebook icon"></i>
                            <span class="text"><?php echo esc_html_e('Facebook','jobcircle-frame')?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $footinsurl; ?>">
                            <i class="jobcircle-icon-instagram icon"></i>
                            <span class="text"><?php echo esc_html_e('Instagram','jobcircle-frame')?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $foottwurl; ?>">
                            <i class="jobcircle-icon-twitter icon"></i>
                            <span class="text"><?php echo esc_html_e('Twitter','jobcircle-frame')?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $footyouurl; ?>">
                            <i class="jobcircle-icon-youtube icon"></i>
                            <span class="text"><?php echo esc_html_e('youtube','jobcircle-frame')?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php $style9 = ob_get_clean();
ob_start();         ?>
<footer class="footer footer-theme-10">
    <div class="pri-footer pt-35 pt-lg-70 pt-xl-90 pb-35 pb-md-20">
        <div class="container">
            <div class="row mb-25 mb-md-40 mb-lg-60 mb-xl-100">
                <div class="col-12">
                    <div class="call-to-action">
                        <div class="text-row">
                            <img class="icon" src="<?php echo $foottenlogo; ?>" alt="icon">
                            <strong class="heading"><?php echo $foot_tag_ten; ?></strong>
                            <p><?php echo $foot_ten_sub; ?></p>
                        </div>
                        <a href="https://modern.miraclesoftsolutions.com/candidate-page/"><button class="btn btn-sm btn-orange" type="submit">
                             <span class="btn-text"><?php echo $foot_ten_lbl; ?></span>
                        </button></a>
                    </div>
                </div>
            </div>
            <div class="flex-md-row-reverse justify-content-between pb-lg-30 pb-xl-40">
                <?php echo $widget_style; ?>
            </div>
        </div>
    </div>
    <div class="sec-footer text-black pt-35 pb-35">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-xl-6 mb-15 mb-xl-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-xl-6">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-center justify-content-xl-end">
                        <li>
                            <a href="<?php echo $footfburl; ?>">
                                <i class="jobcircle-icon-facebook"></i>
                                <span class="txt"><?php echo esc_html__('Facebook', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $footyouurl; ?>">
                                <i class="jobcircle-icon-youtube"></i>
                                <span class="txt"><?php echo esc_html__('Youtube', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $footinsurl; ?>">
                                <i class="jobcircle-icon-instagram"></i>
                                <span class="txt"><?php echo esc_html__('Instagram', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $foottwurl; ?>">
                                <i class="jobcircle-icon-twitter"></i>
                                <span class="txt"><?php echo esc_html__('Twitter', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style10 = ob_get_clean();
ob_start();       ?>
<footer class="footer footer-theme-6">
    <div class="pri-footer text-black pt-35 pt-lg-90 pb-35 pb-md-20" style="background-image: url(<?php echo Jobcircle_Plugin::root_url()?>/images/bg-footer-6.png);">
        <div class="container">
            <div class="flex-md-row-reverse justify-content-between pb-lg-65 pb-xl-80">
                <?php echo $widget_style; ?>
            </div>
        </div>
    </div>
    <div class="sec-footer text-black pt-35 pt-lg-50 pb-25 py-md-20 py-lg-45">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8 mb-15 mb-md-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-md-end">
                        <li><a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube"></i></a></li>
                        <li><a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a></li>
                        <li><a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a></li>
                        <li><a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style11 = ob_get_clean();
ob_start();   ?>
<footer class="footer footer-theme-11">
    <div class="container">
        <div class="row justify-content-between pt-35 pt-lg-70 pt-xl-90">
            <div class="col-12 col-lg-3 mb-35 mb-lg-0">
                <strong class="logo">
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo $foottwelvlogo; ?>" width="175" height="43" alt="Job Circle"></a>
                </strong>
            </div>
            <div class="col-12 col-lg-9">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-4 mb-15 mb-md-0">
                        <div class="footer-info">
                            <p><?php echo $footconstag; ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="contact-info">
                            <div class="img-box">
                                <img src="<?php echo Jobcircle_Plugin::root_url()?>/images/footer-11-phobe-bg.svg" alt="image">
                            </div>
                            <p class="phone-number"><a class="number" href="tel:<?php echo $footnumber; ?>"><?php echo $footnumber; ?></a></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="contact-info">
                            <div class="img-box">
                                <i class="jobcircle-icon-map-pin"></i>
                            </div>
                            <p class="address-info"><?php echo $footaddr; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pri-footer pt-35 pt-lg-50 pt-xl-50 pb-60 pb-md-50">
        <div class="container">
            <div class="row flex-md-row-reverse justify-content-between pb-lg-30 pb-xl-40">
                <div class="col-12 col-lg-12">
                    <div class="justify-content-between">
                        <?php echo $widget_style; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center bottom-footer">
                <div class="col-12 col-xl-6 mb-15 mb-xl-0">
                    <p><?php echo $copyright; ?></p>
                </div>
                <div class="col-12 col-xl-6">
                    <ul class="social-networks no-bg d-flex flex-wrap justify-content-center justify-content-xl-end">
                        <li>
                            <a href="<?php echo $footfburl; ?>">
                                <i class="jobcircle-icon-facebook"></i>
                                <span class="txt"><?php echo esc_html__('Facebook', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $footyouurl; ?>">
                                <i class="jobcircle-icon-youtube"></i>
                                <span class="txt"><?php echo esc_html__('Youtube', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $foottwurl; ?>">
                                <i class="jobcircle-icon-twitter"></i>
                                <span class="txt"><?php echo esc_html__('Twitter', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $footinsurl; ?>">
                                <i class="jobcircle-icon-instagram"></i>
                                <span class="txt"><?php echo esc_html__('Instagram', 'jobcircle-frame'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $style12 = ob_get_clean();
ob_start();   ?>
<footer class="footer footer-theme-13">
			<div class="text-white pb-20">
				<div class="container">
					<div class="row align-items-end">
						<div class="col-12 col-md-4">
							<div class="footer-item phone">
								<div class="icon"><i class="jobcircle-icon-phone"></i></div>
								<a href="tel:<?php echo $footthirtnumb; ?>"><?php echo $footthirtnumb; ?>&gt;</a>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<address class="footer-item">
								<div class="icon"><i class="jobcircle-icon-map-pin"></i></div>
								<?php echo nl2br($footthirtadd); ?>
							</address>
						</div>
						<div class="col-12 col-md-4">
							<div class="footer-item">
								<div class="icon"><i class="jobcircle-icon-email"></i></div>
								<a href="mailto:<?php echo $footthritemail; ?>"><?php echo $footthritemail; ?></a>
							</div>
						</div>
					</div>
					<div class="mb-lg-10">
                    <?php echo $widget_style; ?>	
					</div>
				</div>
			</div>
			<div class="copyright text-white py-0">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12 col-md-7 mb-15 mb-md-0">
							<p><?php echo $copyright; ?></p>
						</div>
						<div class="col-12 col-md-5">
							<ul class="list-inline f-links m-0">
								<li><a href="<?php echo $footthritpriva; ?>"><?php echo esc_html__('Privacy &amp; Security', 'jobcircle-frame'); ?></a></li>
								<li><a href="<?php echo $footthritermserv; ?>"><?php echo esc_html__('Terms of Service', 'jobcircle-frame'); ?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
<?php $style13 = ob_get_clean();
ob_start();   ?>
<footer class="footer footer-theme-14" style="background-image: url(<?php echo Jobcircle_Plugin::root_url()?>/images/bg_img13.jpg);">
    <div class="container">
        <div class="wrap_footer">
            <div class="wrap-holder">
                <div class="footer-logo">
                    <a href="<?php echo home_url(); ?>">
                        <img class="normal-logo" src="<?php echo $footfrtnlgo; ?>" width="174" height="43" alt="Job Circle">
                    </a>
                </div>
                <p><?php echo $footfrtntg; ?></p>
                <p><a href="tel:<?php echo $footfrtnnmbr; ?>"><?php echo $footfrtnnmbr; ?></a></p>
                <p><?php echo $footfrtnadd; ?></p>
            </div>
        </div>
        <div class="bottom-footer">
            <strong class="title-subs"><?php echo $footfrtnsub; ?></strong>
            
            <?php echo do_shortcode('[contact-form-7 id="'. $footfridsubsc .'" title="'.$footfrtitsubsc.'"]');?>
            
            
            <ul class="social_links">
                <li>
                    <a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook"></i></a>
                </li>
                <li>
                    <a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter"></i></a>
                </li>
                <li>
                    <a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube"></i></a>
                </li>
                <li>
                    <a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram"></i></a>
                </li>
            </ul>
            <strong class="copyright"><?php echo $copyright; ?></strong>
        </div>
    </div>
</footer>
<?php $style14 = ob_get_clean();
ob_start();   ?>
<footer class="footer footer-theme-15">
			<div class="container">
				<div class="justify-content-between flex-md-row-reverse">                
                <?php echo $widget_style; ?>					
				</div>
			</div>
		</footer>
<?php $style15 = ob_get_clean();
ob_start();   ?>
<footer class="footer footer-theme-16" style="background-image: url(<?php echo Jobcircle_Plugin::root_url()?>/images/bg_img20.jpg);">
			<div class="container">
				<div class="wrap_footer">
					<div class="subscription">
						<div class="text-holder">
							<strong class="title"><?php echo $footsixtntg; ?></strong>
							<p><?php echo $footsixtnsbhed; ?></p>
						</div>
						<div class="download-btns d-flex justify-content-center align-items-center">
							<a href="<?php echo $footsixtngoglimgurl; ?>"><img src="<?php echo $footsixtngoglimg; ?>" alt="img"></a>
							<a href="<?php echo $footsixtnappstrurl; ?>"><img src="<?php echo $footsixtnappstr; ?>" alt="img"></a>
						</div>
					</div>
					<?php echo $widget_style; ?>
					<div class="bottom-footer">
						<p><?php echo $copyright; ?></p>
						<ul class="social_links">
							<li>
								<a href="<?php echo $footsixtnpriv; ?>">
									<span class="text"><?php echo esc_html__('Privacy &amp; Security', 'jobcircle-frame'); ?></span>
								</a>
							</li>
							<li>
								<a href="<?php echo $footstixtntermserv; ?>">
									<span class="text"><?php echo esc_html__('Terms of Service', 'jobcircle-frame'); ?></span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
<?php $style16 = ob_get_clean();
ob_start();   ?>
<footer class="footer footer-theme-17" style="background-image: url(<?php echo Jobcircle_Plugin::root_url()?>/images/bg_img26.png);">
			<div class="container">
				<div class="subscription-holder">
					<div class="flag-img">
						<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/img_96.png" alt="img">
					</div>
					<strong class="h1"><?php echo $footsevntnws; ?></strong>
					<p><?php echo $footnwssbhed; ?></p>  
					<?php echo do_shortcode('[contact-form-7 id="'. $footformid .'" title="'.$footformtitle.'"]');?>
					<ul class="social_links">
						<li>
							<a href="<?php echo $footfburl; ?>"><i class="jobcircle-icon-facebook icon"></i></a>
						</li>
						<li>
							<a href="<?php echo $footinsurl; ?>"><i class="jobcircle-icon-instagram icon"></i></a>
						</li>
						<li>
							<a href="<?php echo $footyouurl; ?>"><i class="jobcircle-icon-youtube icon"></i></a>
						</li>
						<li>
							<a href="<?php echo $foottwurl; ?>"><i class="jobcircle-icon-twitter icon"></i></a>
						</li>
					</ul>
				</div>
				<?php echo $widget_style; ?>	
				<div class="bottom-footer">
					<p><?php echo $copyright; ?></p>
					<ul class="page_links">
						<li>
							<a href="#">
								<span class="text"><?php echo esc_html__('Privacy &amp; Security', 'jobcircle-frame'); ?></span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="text"><?php echo esc_html__('Terms of Service', 'jobcircle-frame'); ?></span>
							</a>
						</li>
					</ul>
				</div>				
			</div>
		</footer>
<?php $style17 = ob_get_clean();
ob_start();   ?>
<footer class="footer footer-theme-12">
			<div class="pri-footer pt-35 pt-lg-70 pt-xl-90 pb-35 pb-md-20">
				<div class="container">
					<div class="flex-md-row-reverse justify-content-between pb-lg-30 pb-xl-40">
					<?php echo $widget_style; ?>						
					</div>
				</div>
				<div class="container">
					<div class="footer-columns">
						<div class="column">
							<div class="img-box">
								<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/footer-11-phobe-bg.svg" alt="image">
							</div>
							<div class="txt-box">
								<a href="tel:<?php echo $footsixtynumb; ?>"><?php echo $footsixtynumb; ?></a>
							</div>
						</div>
						<div class="column">
							<div class="img-box">
								<i class="jobcircle-icon-map-pin"></i>
							</div>
							<div class="txt-box">
								<p><?php echo $footsixtyadd; ?></p>
							</div>
						</div>
						<div class="column">
							<div class="img-box">
								<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/footer-11-mail.svg" alt="image">
							</div>
							<div class="txt-box">
								<a href="mailto:<?php echo $footsixtyemail; ?>"><?php echo $footsixtyemail; ?></a>
							</div>
						</div>
					</div>
				</div>
				<div class="container pb-20px pb-md-20 pb-lg-20 d-flex justify-content-center">
					<span class="copyright"><?php echo $copyright; ?></span>
				</div>
			</div>			
		</footer>
<?php $style60 = ob_get_clean();
ob_start();   ?>
<footer class="footer">
    <div class="pri-footer bg-blue-dark text-white pt-35 pt-lg-50 pb-35 pb-md-35">
        <div class="container">
            <?php echo $widget_style; ?>
        </div>
    </div>
    <div class="sec-footer bg-blue-darker text-center text-white py-15 py-md-20">
        <p><?php echo $copyright; ?></p>
    </div>
</footer>
<?php $style1 = ob_get_clean();  ?>