<?php

add_filter('jobcircle_404_page_markup', function () {
    ob_start();
    ?>
   	<div class="subvisual-block cover-area subvisual-theme-1 block-404 d-flex pt-50 pt-lg-80 pb-50 pb-lg-80 text-white">
			<div class="container position-relative">
				<div class="row align-items-center">
					<div class="col-12 col-md-6">
						<div class="subvisual-textbox">
							<h1><?php echo esc_html_e("404",'jobcirle-frame');?></h1>
							<h2><?php echo esc_html_e("Ooops, Page Not Found",'jobcirlce-frame');?></h2>
							<p><?php echo esc_html_e("We Can't Seem to find the page your'e looking for.",'jobcircle-frame');?></p>
							<div class="form-subscribe">
								<form action="s">
									<input class="form-control" type="text" placeholder="Enter Kayword...." name="s">
									<button class="btn-search"><i class="jobcircle-icon-search"></i></button>
								</form>
								<a class="btn btn-green btn-sm" href="<?php echo home_url();?>"><span class="btn-text"><?php echo esc_html_e("Back To Home",'jobcircle-frame');?></span></a>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="image-404">
							<img src="<?php echo Jobcircle_Plugin::root_url()?>/images/404-theme1.png" alt="404">
						</div>
					</div>
				</div>
			</div>
		</div>
		
    <?php
    $html = ob_get_clean();
    return $html;
});
