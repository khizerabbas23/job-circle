<?php
function jobcircle_theme_colors(){
    global $jobcircle_framework_options;

    $header_style = isset($jobcircle_framework_options['header-style']) ? $jobcircle_framework_options['header-style'] : '';

    if ($header_style == 'style2') {   
        $primarycolor = '#20ca6f';
        $darkprimarycolor = '#00411e';
        $lightprimarycolor = '#00ff77';
    } elseif ($header_style == 'style3') {  
        $primarycolor = '#f9ab00';
        $darkprimarycolor = '#d08f00';
        $lightprimarycolor = '#ffc23d';
    }elseif ($header_style == 'style4') {  
        $primarycolor = '#7d29e6';
        $darkprimarycolor = '#7200ff';
        $lightprimarycolor = '#b274ff';
    }elseif ($header_style == 'style5') { 
        $primarycolor = '#20ca6f';
        $darkprimarycolor = '#00a44c';
        $lightprimarycolor = '#5bffa7';
    }elseif ($header_style == 'style6') {  
        $primarycolor = '#e66f3b';
        $darkprimarycolor = '#ff4d00';
        $lightprimarycolor = '#ffa27a'; 
    }elseif ($header_style == 'style7') { 
        $primarycolor = '#20ca6f';
        $darkprimarycolor = '#007a38';
        $lightprimarycolor = '#47ff9c';
    }elseif ($header_style == 'style8') {  
        $primarycolor = '#fe7420';
        $darkprimarycolor = '#ff6200';
        $lightprimarycolor = '#fba874';
    }elseif ($header_style == 'style9') {  
        $primarycolor = '#3f71ef';
        $darkprimarycolor = '#0049ff';
        $lightprimarycolor = '#85a8ff';
    }elseif ($header_style == 'style10') {    
        $primarycolor = '#ff6b2c';
        $darkprimarycolor = '#fd4b00';
        $lightprimarycolor = '#ff9b71';
    }elseif ($header_style == 'style11') {  
        $primarycolor = '#feb559';
        $darkprimarycolor = '#ff8d00';
        $lightprimarycolor = '#ffd198';
    }elseif ($header_style == 'style12') { 
        $primarycolor = '#f9ab00';
        $darkprimarycolor = '#c68800';
        $lightprimarycolor = '#ffca57';
    }elseif ($header_style == 'style13') {   
        $primarycolor = '#25b892';
        $darkprimarycolor = '#005740';
        $lightprimarycolor = '#50d0ae';
    }elseif ($header_style == 'style14') {   
        $primarycolor = '#20ca6f';
        $darkprimarycolor = '#009546';
        $lightprimarycolor = '#00ff77';
    }elseif ($header_style == 'style15') {  
        $primarycolor = '#4a59eb';
        $darkprimarycolor = '#0018ff';
        $lightprimarycolor = '#7481ff';
    }elseif ($header_style == 'style16') {  
        $primarycolor = '#db3478';
        $darkprimarycolor = '#ff0068';
        $lightprimarycolor = '#ff79af';
    }elseif ($header_style == 'style17') {   
        $primarycolor = '#fe7420';
        $darkprimarycolor = '#f85d00';
        $lightprimarycolor = '#ffad7c';
    }elseif ($header_style == 'style60') {   
        $primarycolor = '#20ca6f';
        $darkprimarycolor = '#00a24c';
        $lightprimarycolor = '#5affa7';
    }else{
        $primarycolor = '#21e5c6';
        $darkprimarycolor = '#00deb9';
        $lightprimarycolor = '#75cabc';
    }
    ?>
<style>
    :root {
  --colorPrimary: <?php echo $primarycolor; ?>;
  --colorDarkPrimary: <?php echo $darkprimarycolor; ?>;
  --colorLightPrimary: <?php echo $lightprimarycolor; ?>;
}
    </style>
    <?php
}
add_action('wp_head', 'jobcircle_theme_colors', 5);

function jobcircle_googlefont_enqueue(){
    global $jobcircle_framework_options;

    $header_style = isset($jobcircle_framework_options['header-style']) ? $jobcircle_framework_options['header-style'] : '';

    if ($header_style == 'style2') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    } elseif ($header_style == 'style3') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);    
    }elseif ($header_style == 'style4') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style5') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style6') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style7') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style8') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style9') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style10') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style11') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style12') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style13') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style14') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style15') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style16') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style17') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }elseif ($header_style == 'style60') {
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }else{
    wp_enqueue_style('jobcircle-font-akadfa', 'https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_enqueue_style('jobcircle-font-family', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'jobcircle_googlefont_enqueue', 5);