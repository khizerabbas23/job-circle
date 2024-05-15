<?php

add_filter('jobcircle_footer_content_markup', function () {
ob_start();
global $post;
global $jobcircle_framework_options;
// Style 2
$footstltwlog = isset($jobcircle_framework_options['jobcircle-footer-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-logo']['url'] : '';
$jbprttw = isset($jobcircle_framework_options['jobcircle-job-portal']) ? $jobcircle_framework_options['jobcircle-job-portal'] : '';
$jbsbprttw = isset($jobcircle_framework_options['jobcircle-job-portal-sub']) ? $jobcircle_framework_options['jobcircle-job-portal-sub'] : '';
$jblooktw = isset($jobcircle_framework_options['jobcircle-job-look-job']) ? $jobcircle_framework_options['jobcircle-job-look-job'] : '';
$jblookurltw = isset($jobcircle_framework_options['jobcircle-job-look-job-url']) ? $jobcircle_framework_options['jobcircle-job-look-job-url'] : '';
$jbfrjb = isset($jobcircle_framework_options['jobcircle-job-for-job']) ? $jobcircle_framework_options['jobcircle-job-for-job'] : '';
$jbfrjburl = isset($jobcircle_framework_options['jobcircle-job-for-job-url']) ? $jobcircle_framework_options['jobcircle-job-for-job-url'] : '';
// Style 4
$footlgfor = isset($jobcircle_framework_options['jobcircle-footer-logo-four']['url']) ? $jobcircle_framework_options['jobcircle-footer-logo-four']['url'] : '';
$footbgimgfr = isset($jobcircle_framework_options['jobcircle-footer-bgimg-four']['url']) ? $jobcircle_framework_options['jobcircle-footer-bgimg-four']['url'] : '';
$footsbfr = isset($jobcircle_framework_options['jobcircle-subscription-four']) ? $jobcircle_framework_options['jobcircle-subscription-four'] : '';
$footnotfr = isset($jobcircle_framework_options['jobcircle-notify-four']) ? $jobcircle_framework_options['jobcircle-notify-four'] : '';
$footsubidfor = isset($jobcircle_framework_options['jobcircle-sub-form-id-four']) ? $jobcircle_framework_options['jobcircle-sub-form-id-four'] : '';
$footsubtltfor = isset($jobcircle_framework_options['jobcircle-sub-form-head-four']) ? $jobcircle_framework_options['jobcircle-sub-form-head-four'] : '';
$footsubfr = isset($jobcircle_framework_options['jobcircle-subscribe-four']) ? $jobcircle_framework_options['jobcircle-subscribe-four'] : '';
$footcndfr = isset($jobcircle_framework_options['jobcircle-candidate-four']) ? $jobcircle_framework_options['jobcircle-candidate-four'] : '';
$footcndonefr = isset($jobcircle_framework_options['jobcircle-candidate-one-four']['url']) ? $jobcircle_framework_options['jobcircle-candidate-one-four']['url'] : '';
$footcndoneurl = isset($jobcircle_framework_options['jobcircle-candidate-one-four-url']) ? $jobcircle_framework_options['jobcircle-candidate-one-four-url'] : '';
$footcndtwfr = isset($jobcircle_framework_options['jobcircle-candidate-two-four']['url']) ? $jobcircle_framework_options['jobcircle-candidate-two-four']['url'] : '';
$footcndtwurl = isset($jobcircle_framework_options['jobcircle-candidate-two-four-url']) ? $jobcircle_framework_options['jobcircle-candidate-two-four-url'] : '';
$footcndthrfr = isset($jobcircle_framework_options['jobcircle-candidate-three-four']['url']) ? $jobcircle_framework_options['jobcircle-candidate-three-four']['url'] : '';
$footcndthrurl = isset($jobcircle_framework_options['jobcircle-candidate-three-four-url']) ? $jobcircle_framework_options['jobcircle-candidate-three-four-url'] : '';
$footcndfourfr = isset($jobcircle_framework_options['jobcircle-candidate-four-four']['url']) ? $jobcircle_framework_options['jobcircle-candidate-four-four']['url'] : '';
$footcndfoururl = isset($jobcircle_framework_options['jobcircle-candidate-four-four-url']) ? $jobcircle_framework_options['jobcircle-candidate-four-four-url'] : '';
$footcndfveurl = isset($jobcircle_framework_options['jobcircle-candidate-five-four-url']) ? $jobcircle_framework_options['jobcircle-candidate-five-four-url'] : '';
// Style 5
$footbgimgfv = isset($jobcircle_framework_options['jobcircle-footer-bgimg-five']['url']) ? $jobcircle_framework_options['jobcircle-footer-bgimg-five']['url'] : '';
$footfvlogo = isset($jobcircle_framework_options['jobcircle-footer-five-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-five-logo']['url'] : '';
$empfive = isset($jobcircle_framework_options['jobcircle-employer-five']) ? $jobcircle_framework_options['jobcircle-employer-five'] : '';
$adverfive = isset($jobcircle_framework_options['jobcircle-advertise-five']) ? $jobcircle_framework_options['jobcircle-advertise-five'] : '';
$jblblfive = isset($jobcircle_framework_options['jobcircle-job-label-five']) ? $jobcircle_framework_options['jobcircle-job-label-five'] : '';
$jblblurlfive = isset($jobcircle_framework_options['jobcircle-job-label-url-five']) ? $jobcircle_framework_options['jobcircle-job-label-url-five'] : '';
// Style 6
$footlogosix = isset($jobcircle_framework_options['jobcircle-footer-six-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-six-logo']['url'] : '';
// Style 7
$footbgimgsev = isset($jobcircle_framework_options['jobcircle-footer-bgimg-seven']['url']) ? $jobcircle_framework_options['jobcircle-footer-bgimg-seven']['url'] : '';
$footsevlogo = isset($jobcircle_framework_options['jobcircle-footer-seven-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-seven-logo']['url'] : '';
$empsev = isset($jobcircle_framework_options['jobcircle-employer-seven']) ? $jobcircle_framework_options['jobcircle-employer-seven'] : '';
$adversev = isset($jobcircle_framework_options['jobcircle-advertise-seven']) ? $jobcircle_framework_options['jobcircle-advertise-seven'] : '';
$jblblsev = isset($jobcircle_framework_options['jobcircle-job-label-seven']) ? $jobcircle_framework_options['jobcircle-job-label-seven'] : '';
$jblblurlsev = isset($jobcircle_framework_options['jobcircle-job-label-url-seven']) ? $jobcircle_framework_options['jobcircle-job-label-url-seven'] : '';
// Style 8
$footstltwlogeight = isset($jobcircle_framework_options['jobcircle-footer-eight-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-eight-logo']['url'] : '';
$jbportalight = isset($jobcircle_framework_options['jobcircle-job-portal-eight']) ? $jobcircle_framework_options['jobcircle-job-portal-eight'] : '';
$jbsubprteight = isset($jobcircle_framework_options['jobcircle-job-portal-sub-eight']) ? $jobcircle_framework_options['jobcircle-job-portal-sub-eight'] : '';
$jblookeight = isset($jobcircle_framework_options['jobcircle-job-look-job-eight']) ? $jobcircle_framework_options['jobcircle-job-look-job-eight'] : '';
$jblookurleight = isset($jobcircle_framework_options['jobcircle-job-look-job-url-eight']) ? $jobcircle_framework_options['jobcircle-job-look-job-url-eight'] : '';
$jblookforeight = isset($jobcircle_framework_options['jobcircle-job-for-job-eight']) ? $jobcircle_framework_options['jobcircle-job-for-job-eight'] : '';
$jblookforurleight = isset($jobcircle_framework_options['jobcircle-job-for-job-url-eight']) ? $jobcircle_framework_options['jobcircle-job-for-job-url-eight'] : '';
// Style 9
$foot_nine_tag = isset($jobcircle_framework_options['jobcircle-nine-footer-tag']) ? $jobcircle_framework_options['jobcircle-nine-footer-tag'] : '';
$foot_nine_sub = isset($jobcircle_framework_options['jobcircle-nine-footer-sub-keep']) ? $jobcircle_framework_options['jobcircle-nine-footer-sub-keep'] : '';
$foot_nine_lbl = isset($jobcircle_framework_options['jobcircle-nine-footer-label']) ? $jobcircle_framework_options['jobcircle-nine-footer-label'] : '';
$foot_nine_form_id = isset($jobcircle_framework_options['jobcircle-nine-footer-form-id']) ? $jobcircle_framework_options['jobcircle-nine-footer-form-id'] : '';
$foot_nine_form_titl = isset($jobcircle_framework_options['jobcircle-nine-footer-form-title']) ? $jobcircle_framework_options['jobcircle-nine-footer-form-title'] : '';
$foot_nine_bgimg = isset($jobcircle_framework_options['jobcircle-footer-nine-bg-image']['url']) ? $jobcircle_framework_options['jobcircle-footer-nine-bg-image']['url'] : '';
// Style 10
$foottenlogo = isset($jobcircle_framework_options['jobcircle-footer-ten-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-ten-logo']['url'] : '';
$foot_tag_ten = isset($jobcircle_framework_options['jobcircle-ten-footer-tag']) ? $jobcircle_framework_options['jobcircle-ten-footer-tag'] : '';
$foot_ten_sub = isset($jobcircle_framework_options['jobcircle-ten-footer-sub-title']) ? $jobcircle_framework_options['jobcircle-ten-footer-sub-title'] : '';
$foot_ten_lbl = isset($jobcircle_framework_options['jobcircle-ten-footer-label']) ? $jobcircle_framework_options['jobcircle-ten-footer-label'] : '';
// Style 12
$foottwelvlogo = isset($jobcircle_framework_options['jobcircle-footer-twelve-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-twelve-logo']['url'] : '';
$footconstag = isset($jobcircle_framework_options['jobcircle-twelve-footer-tag']) ? $jobcircle_framework_options['jobcircle-twelve-footer-tag'] : '';
$footnumber = isset($jobcircle_framework_options['jobcircle-twelve-footer-number']) ? $jobcircle_framework_options['jobcircle-twelve-footer-number'] : '';
$footaddr = isset($jobcircle_framework_options['jobcircle-twelve-footer-address']) ? $jobcircle_framework_options['jobcircle-twelve-footer-address'] : '';
// Style 13
$footthirtnumb = isset($jobcircle_framework_options['jobcircle-thirteen-footer-number']) ? $jobcircle_framework_options['jobcircle-thirteen-footer-number'] : '';
$footthirtadd = isset($jobcircle_framework_options['jobcircle-thirteen-footer-address']) ? $jobcircle_framework_options['jobcircle-thirteen-footer-address'] : '';
$footthritemail = isset($jobcircle_framework_options['jobcircle-thirteen-footer-email']) ? $jobcircle_framework_options['jobcircle-thirteen-footer-email'] : '';
$footthritpriva = isset($jobcircle_framework_options['jobcircle-thirteen-footer-privacy']) ? $jobcircle_framework_options['jobcircle-thirteen-footer-privacy'] : '';
$footthritermserv = isset($jobcircle_framework_options['jobcircle-thirteen-footer-terms-service']) ? $jobcircle_framework_options['jobcircle-thirteen-footer-terms-service'] : '';
// Style 14
$footfrtnlgo = isset($jobcircle_framework_options['jobcircle-footer-fourteen-logo']['url']) ? $jobcircle_framework_options['jobcircle-footer-fourteen-logo']['url'] : '';
$footfrtntg = isset($jobcircle_framework_options['jobcircle-fourteen-footer-tag']) ? $jobcircle_framework_options['jobcircle-fourteen-footer-tag'] : '';
$footfrtnnmbr = isset($jobcircle_framework_options['jobcircle-fourteen-footer-number']) ? $jobcircle_framework_options['jobcircle-fourteen-footer-number'] : '';
$footfrtnadd = isset($jobcircle_framework_options['jobcircle-fourteen-footer-address']) ? $jobcircle_framework_options['jobcircle-fourteen-footer-address'] : '';
$footfrtnsub = isset($jobcircle_framework_options['jobcircle-fourteen-footer-subscribe']) ? $jobcircle_framework_options['jobcircle-fourteen-footer-subscribe'] : '';
$footfridsubsc = isset($jobcircle_framework_options['jobcircle-sub-form-id-fourten']) ? $jobcircle_framework_options['jobcircle-sub-form-id-fourten'] : '';
$footfrtitsubsc = isset($jobcircle_framework_options['jobcircle-sub-form-head-fourten']) ? $jobcircle_framework_options['jobcircle-sub-form-head-fourten'] : '';
// Style 16
$footsixtntg = isset($jobcircle_framework_options['jobcircle-sixteen-footer-main-tag']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-main-tag'] : '';
$footsixtnsbhed = isset($jobcircle_framework_options['jobcircle-sixteen-footer-sub-heading']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-sub-heading'] : '';
$footsixtngoglimg = isset($jobcircle_framework_options['jobcircle-sixteen-footer-google-image']['url']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-google-image']['url'] : '';
$footsixtngoglimgurl = isset($jobcircle_framework_options['jobcircle-sixteen-footer-google-image-url']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-google-image-url'] : '';
$footsixtnappstr = isset($jobcircle_framework_options['jobcircle-sixteen-footer-app-store']['url']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-app-store']['url'] : '';
$footsixtnappstrurl = isset($jobcircle_framework_options['jobcircle-sixteen-footer-app-store-url']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-app-store-url'] : '';
$footsixtnpriv = isset($jobcircle_framework_options['jobcircle-sixteen-footer-privacy']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-privacy'] : '';
$footstixtntermserv = isset($jobcircle_framework_options['jobcircle-sixteen-footer-terms-service']) ? $jobcircle_framework_options['jobcircle-sixteen-footer-terms-service'] : '';
// Style 17
$footsevntnws = isset($jobcircle_framework_options['jobcircle-seventeen-footer-news-tag']) ? $jobcircle_framework_options['jobcircle-seventeen-footer-news-tag'] : '';
$footnwssbhed = isset($jobcircle_framework_options['jobcircle-seventeen-footer-news-sub-heading']) ? $jobcircle_framework_options['jobcircle-seventeen-footer-news-sub-heading'] : '';
$footformid = isset($jobcircle_framework_options['jobcircle-seventeen-footer-form-id']) ? $jobcircle_framework_options['jobcircle-seventeen-footer-form-id'] : '';
$footformtitle = isset($jobcircle_framework_options['jobcircle-seventeen-footer-form-title']) ? $jobcircle_framework_options['jobcircle-seventeen-footer-form-title'] : '';
// Style 60
$footsixtynumb = isset($jobcircle_framework_options['jobcircle-sixty-footer-number']) ? $jobcircle_framework_options['jobcircle-sixty-footer-number'] : '';
$footsixtyadd = isset($jobcircle_framework_options['jobcircle-sixty-footer-address']) ? $jobcircle_framework_options['jobcircle-sixty-footer-address'] : '';
$footsixtyemail = isset($jobcircle_framework_options['jobcircle-sixty-footer-email']) ? $jobcircle_framework_options['jobcircle-sixty-footer-email'] : '';

$copyright = isset($jobcircle_framework_options['jobcircle-footer-copyright-text']) ? $jobcircle_framework_options['jobcircle-footer-copyright-text'] : '';
$footfburl = isset($jobcircle_framework_options['jobcircle-footer-facebook-url']) ? $jobcircle_framework_options['jobcircle-footer-facebook-url'] : '';
$footinsurl = isset($jobcircle_framework_options['jobcircle-footer-instagram-url']) ? $jobcircle_framework_options['jobcircle-footer-instagram-url'] : '';
$foottwurl = isset($jobcircle_framework_options['jobcircle-footer-twitter-url']) ? $jobcircle_framework_options['jobcircle-footer-twitter-url'] : '';
$footyouurl = isset($jobcircle_framework_options['jobcircle-footer-youtube-url']) ? $jobcircle_framework_options['jobcircle-footer-youtube-url'] : '';

$widget_style = jobcircle_footer_sidebar_widgets();

$footer_style_page = get_post_meta($post->ID, 'jobcircle_field_footer_style', true);  
$footer_widget_style = isset($jobcircle_framework_options['footer-widget-style']) ? $jobcircle_framework_options['footer-widget-style'] : '';   

// For 404 Page
$error_footer_style = isset($jobcircle_framework_options['footer-style-error']) ? $jobcircle_framework_options['footer-style-error'] : '';
if(is_404() && (!empty($error_footer_style))) {
    $footer_widget_style = $error_footer_style;
}
// End 404 condition

// For each & every page
if(!empty($footer_style_page)){
$footer_widget_style = $footer_style_page;
}
// End every page

if ($footer_widget_style == 'style1'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-sidebars']: '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-sidebars');
}
}elseif ($footer_widget_style == 'style2'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-two-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-two-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-two-sidebars');
}
}elseif ($footer_widget_style == 'style3'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-three-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-three-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-three-sidebars');
}
}elseif ($footer_widget_style == 'style4'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-four-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-four-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-four-sidebars');
}
}elseif ($footer_widget_style == 'style5'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-five-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-five-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-five-sidebars');
}
}elseif ($footer_widget_style == 'style6'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-six-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-six-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-six-sidebars');
}
}elseif ($footer_widget_style == 'style7'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-seven-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-seven-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-seven-sidebars');
}
}elseif ($footer_widget_style == 'style8'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-eight-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-eight-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-eight-sidebars');
}
}elseif ($footer_widget_style == 'style9'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-nine-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-nine-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-nine-sidebars');
}
}elseif ($footer_widget_style == 'style10'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-ten-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-ten-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-ten-sidebars');
}
}elseif ($footer_widget_style == 'style11'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-eleven-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-eleven-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-eleven-sidebars');
}
}elseif ($footer_widget_style == 'style12'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-twelve-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-twelve-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-twelve-sidebars');
}
}elseif ($footer_widget_style == 'style13'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-thirteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-thirteen-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-thirteen-sidebars');
}
}elseif ($footer_widget_style == 'style14'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-fourteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-fourteen-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-fourteen-sidebars');
}
}elseif ($footer_widget_style == 'style15'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-fifteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-fifteen-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-fifteen-sidebars');
}
}elseif ($footer_widget_style == 'style16'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-sixteen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-sixteen-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-sixteen-sidebars');
}
}elseif ($footer_widget_style == 'style17'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-seventeen-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-seventeen-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-seventeen-sidebars');
}
}elseif ($footer_widget_style == 'style60'){
$footer_style= isset($jobcircle_framework_options['jobcircle-footer-widgstyle-sixty-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-widgstyle-sixty-sidebars'] : '';
if(!empty($footer_style)){
$widget_style = jobcircle_footer_sidebar_widgets('jobcircle-footer-widgstyle-sixty-sidebars');
}
}


include 'footer-html.php';


if($footer_widget_style == 'style2') {
echo $style2;
}elseif($footer_widget_style == 'style3') {
	echo $style3;
}elseif($footer_widget_style == 'style4') {
	echo $style4;
}elseif($footer_widget_style == 'style5') {
	echo $style5;
}elseif($footer_widget_style == 'style6') {
	echo $style6;
}elseif($footer_widget_style == 'style7'){ 
	echo $style7;
}elseif($footer_widget_style == 'style8') { 
	echo $style8;
}elseif($footer_widget_style == 'style9'){ 
	echo $style9;
}elseif($footer_widget_style == 'style10') {
	echo $style10;
}elseif($footer_widget_style == 'style11') {
	echo $style11;
}elseif($footer_widget_style == 'style12') {
	echo $style12;
}elseif($footer_widget_style == 'style13') {
	echo $style13;
}elseif($footer_widget_style == 'style14') {
	echo $style14;
}elseif($footer_widget_style == 'style15') {
	echo $style15;
}elseif($footer_widget_style == 'style16') {
	echo $style16;
}elseif($footer_widget_style == 'style17') {
	echo $style17;
}elseif($footer_widget_style == 'style60') {
	echo $style60;
}else{   
	echo $style1;
}
$html = ob_get_clean();
return $html;
});

function jobcircle_footer_sidebar_widgets($footer_sidebar = 'jobcircle-footer-sidebars') {
global $jobcircle_framework_options;
$footer_sidebar_def = $footer_sidebar;
$jobcircle_sidebars = isset($jobcircle_framework_options[$footer_sidebar_def]) ? $jobcircle_framework_options[$footer_sidebar_def] : '';
if (isset($jobcircle_sidebars['sidebar_name']) && is_array($jobcircle_sidebars['sidebar_name']) && sizeof($jobcircle_sidebars['sidebar_name']) > 0) {
foreach ($jobcircle_sidebars['sidebar_name'] as $sidebar_cname) {
if ($sidebar_cname == '') {
$jobcircle_sidebars = isset($jobcircle_framework_options['jobcircle-footer-sidebars']) ? $jobcircle_framework_options['jobcircle-footer-sidebars'] : '';
}
break;
}
}
$jobcircle_sidebars_switch = isset($jobcircle_framework_options['jobcircle-footer-sidebar-switch']) ? $jobcircle_framework_options['jobcircle-footer-sidebar-switch'] : '';

ob_start();
if ($jobcircle_sidebars_switch == 'on' && isset($jobcircle_sidebars['col_width']) && is_array($jobcircle_sidebars['col_width']) && sizeof($jobcircle_sidebars['col_width']) > 0) {

?>
<div class="row">
<?php
$sidebar_counter = 0;
foreach ($jobcircle_sidebars['col_width'] as $sidebar_col) {
$sidebar = isset($jobcircle_sidebars['sidebar_name'][$sidebar_counter]) ? $jobcircle_sidebars['sidebar_name'][$sidebar_counter] : '';
if ($sidebar != '') {
$sidebar_col_arr = explode('_', $sidebar_col);
$sidebar_col_class = isset($sidebar_col_arr[0]) && $sidebar_col_arr[0] != '' ? 'col-md-' . $sidebar_col_arr[0] : 'col-md-12';
$sidebar_id = sanitize_title($sidebar);
if (is_active_sidebar($sidebar_id)) {
?>
<div class="<?php echo ($sidebar_col_class) ?> col-sm-6 col-xs-6">
<?php dynamic_sidebar($sidebar_id) ?>
</div>
<?php
}
}
$sidebar_counter++;
}
?>
</div>
<?php
}
$html = ob_get_clean();

return $html;
}