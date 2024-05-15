<?php
if (!class_exists('Jobcircle_Email')) {

    class Jobcircle_Email{

        public static $jobcircle_default_codes = '';

        public function __construct(){
            add_action('init', array($this, 'jobcirlce_email_init'), 1, 0);               
            add_filter('wp_mail_content_type', array(&$this, 'jobcircle_set_content_type'));
            add_filter('wp_mail_from',  array(&$this,'jobcircle_sender_email') );
            add_filter('wp_mail_from_name', array(&$this,'jobcircle_sender_name') );
        }

        public function jobcirlce_email_init(){
            self::$jobcircle_default_codes = array(
                array(
                    'var' => '{sitename}',
                    'display_text' => 'Site Name',
                    'function_callback' => array($this, 'jobcircle_get_site_name'),
                ),
                array(
                    'var' => '{admin_email}',
                    'display_text' => 'Admin Email',
                    'function_callback' => array($this, 'jobcircle_get_admin_email'),
                ),
                array(
                    'var' => '{site_url}',
                    'display_text' => 'SITE URL',
                    'function_callback' => array($this, 'jobcircle_get_site_url'),
                ),
            );         
        }

        public function jobcircle_get_site_name(){
            return get_bloginfo('name');
        }		
        public function jobcircle_get_admin_email(){
            return get_bloginfo('admin_email');
        }		
        
        public function jobcircle_get_site_url(){
            return get_bloginfo('url');
        }	

        public function jobcircle_set_content_type(){
            return "text/html";
        }		
       
        public function jobcircle_sender_email($jobcircle_email_address){
            global $jobcircle_framework_options;
            $jobcircle_sender_email 	= !empty($jobcircle_framework_options['jobcircle_sender_email']) ? $jobcircle_framework_options['jobcircle_sender_email'] : '';
            $jobcircle_sender_email 	= !empty($jobcircle_sender_email) ? $jobcircle_sender_email : $jobcircle_email_address;
            return $jobcircle_sender_email;
        }
        
        public function jobcircle_sender_name($jobcircle_name){
            global $jobcircle_framework_options;
            $jobcircle_default_sender_name 	= !empty($jobcircle_framework_options['jobcircle_sender_name']) ? $jobcircle_framework_options['jobcircle_sender_name'] : '';
            $jobcircle_sender_name 			= !empty($jobcircle_default_sender_name) ? $jobcircle_default_sender_name : $jobcircle_name;
            return $jobcircle_sender_name;
        }        
        
        public function jobcircle_prepare_email_headers(){
			global $jobcircle_framework_options;
            $jobcircle_email_logo = !empty($jobcircle_framework_options['jobcircle_email_logo']['url']) ? $jobcircle_framework_options['jobcircle_email_logo']['url'] : '';
			$jobcircle_blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            ob_start();
            ?>
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background-color: #f4f4f4; border-radius: 20px;">
                <tr>
                    <td align="center">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" width="600" style="background: #ffffff;margin-top: 100px;border-radius: 20px 20px 0 0;">
                            <tbody>
                                <tr>
                                    <td style="direction:ltr;font-size:0px;padding:50px 55px;text-align:center;">
                                        <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="width:130px;">
                                                                        <img height="auto" src="<?php echo esc_url($jobcircle_email_logo);?>" alt="<?php echo esc_attr($jobcircle_blogname);?>" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;" width="130">
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php
            return ob_get_clean();
        }
       
        public function jobcircle_prepare_email_footers($jobcircle_params = '')
        {
            global $jobcircle_framework_options;
            $jobcircle_email_copyrights = !empty($jobcircle_framework_options['jobcircle_email_copyrights']) ? $jobcircle_framework_options['jobcircle_email_copyrights'] : esc_html__('Copyright', 'jojobcircle-frame') . '&nbsp;&copy;&nbsp;' . date('Y') . esc_html__(' | All Rights Reserved', 'jojobcircle-frame');
            $jobcircle_email_footer_color = !empty($jobcircle_framework_options['jobcircle_email_footer_color']) ? $jobcircle_framework_options['jobcircle_email_footer_color'] : '#353648';
            $jobcircle_email_footer_color_text = !empty($jobcircle_framework_options['jobcircle_email_footer_color_text']) ? $jobcircle_framework_options['jobcircle_email_footer_color_text'] : '#FFF';

            ob_start();
            ?>
                <tr>
                    <td align="center">
                        <table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="600" style="background: <?php echo esc_attr($jobcircle_email_footer_color);?>; margin-bottom: 100px; border-radius: 0 0 20px 20px;">
                            <tbody>
                                <tr>
                                    <td style="font-size: 0px; padding: 30px 55px 30px; word-break: break-word;">
                                        <div style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 13px; font-weight: 500; line-height: 20px; color: <?php echo esc_attr($jobcircle_email_footer_color_text);?>; text-align:center;">
                                            <p style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; text-align:center; width: 100%; font-size: 13px; color: <?php echo esc_attr($jobcircle_email_footer_color_text);?>; font-weight: 500; line-height: 20px; margin: 0;"><?php echo do_shortcode($jobcircle_email_copyrights); ?></p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <?php
            return ob_get_clean();
        }        
        public function jobcircle_prepare_email_signature($params = ''){
            global $jobcircle_framework_options;
            $blogname 				= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            $default_sender_name 	= !empty($jobcircle_framework_options['jobcircle_sender_name']) ? $jobcircle_framework_options['jobcircle_sender_name'] : $blogname;
            $sender_name 			= !empty($params) ? $params : $default_sender_name;

            $default_signature 		= esc_html__('Regards', 'jojobcircle-frame');
            $sender_signature 		= !empty($jobcircle_framework_options['jobcircle_email_signature']) ? $jobcircle_framework_options['jobcircle_email_signature'] : $default_signature;
			
            ob_start();
            if (!empty($sender_name) || !empty($sender_signature)) {
            
				if (!empty($sender_signature) ) {?>
				<tr>
					<td align="center">
						<table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="600" style="background: #ffffff;">
							<tbody>
								<tr>
									<td style="font-size: 0px; padding: 0 55px 5px; word-break: break-word;">
										<div style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 16px; font-weight: 700; line-height: 20px; color: #303041;">
											<p style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; width: 100%; font-size: 15px; color: #303041; font-weight: 700; line-height: 20px; margin: 0;"><?php echo esc_html($sender_signature); ?></p>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<?php }?>
           		<?php if (!empty($sender_name) ) {?>
					<tr>
						<td align="center">
							<table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="600" style="background: #ffffff;">
								<tbody>
									<tr>
										<td style="font-size: 0px; padding: 0 55px 60px; word-break: break-word;">
											<div style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 16px; font-weight: 500; line-height: 20px; color: #676767;">
												<p style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; width: 100%; font-size: 15px; color: #676767; font-weight: 500; line-height: 20px; margin: 0;"><?php echo esc_html($sender_name); ?></p>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
       			<?php }
        	}
            return ob_get_clean();
        }
       
        public function prepare_greeting_message($jobcircle_greeting_text = ''){
            ob_start();
            ?>
            <tr>
                <td align="center">
                    <table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="600" style="background: #ffffff;">
                        <tbody>
                            <tr>
                                <td style="vertical-align: top; padding: 0 0px;">
                                    <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 0px; padding: 14px 55px 20px; word-break: break-word;">
                                                    <div style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 18px; font-weight: 700; line-height: 24px; color: #303041;">
                                                        <h3 style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-weight: 700; font-size: 18px; color: #303041; font-weight: bold; line-height: 24px; margin: 0;"><?php echo esc_html($jobcircle_greeting_text); ?></h3>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <?php
            return ob_get_clean();
        }

        public function jobcircle_process_email_links($jobcircle_params = '', $jobcircle_link_text = '')
        {
            $jobcircle_link_src = !empty($jobcircle_params) ? $jobcircle_params : 'javascript:void(0);';
            return '<a href="' . esc_url($jobcircle_link_src) . '" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; width: 100%; font-size: 16px; color: #55acee; fontt-weight: 700; line-height: 24px; margin: 0;">' . esc_html($jobcircle_link_text) . '</a>';
        }

        
        public function jobcircle_email_body($jobcircle_email_content = '', $jobcircle_greeting = '')
        {
            $jobcircle_body  = '';
            $jobcircle_body .= $this->jobcircle_prepare_email_headers();
            $jobcircle_body .= $this->prepare_greeting_message($jobcircle_greeting);
            $jobcircle_body .= '<tr>';
            $jobcircle_body .= '<td align="center">';
            $jobcircle_body .= '<table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="600" style="background: #ffffff;">';
            $jobcircle_body .= '<tbody>';
            $jobcircle_body .= '<tr>';
            $jobcircle_body .= '<td style="font-size: 0px; padding: 0 55px 20px; word-break: break-word;">';
            $jobcircle_body .= '<div style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 16px; font-weight: 500; line-height: 24px; color: #676767;">';
            $jobcircle_body .= '<p style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; width: 100%; font-size: 16px; color: #676767; font-weight: 500; line-height: 24px; margin: 0;">';
            $jobcircle_body .=  wpautop(nl2br($jobcircle_email_content));
            $jobcircle_body .= '</p>';
            $jobcircle_body .= '</div>';
            $jobcircle_body .= '</td>';
            $jobcircle_body .= '</tr>';
            $jobcircle_body .= $this->jobcircle_prepare_email_signature();
            $jobcircle_body .= '</tbody>';
            $jobcircle_body .= '</table>';
            $jobcircle_body .= '</td>';
            $jobcircle_body .= '</tr>';
            $jobcircle_body .= $this->jobcircle_prepare_email_footers();

            return $jobcircle_body;
        }

        public static function jobcircle_replace_variables($jobcircle_template, $jobcircle_variables)
        {
            $jobcircle_variables = array_merge(self::$jobcircle_default_codes, $jobcircle_variables);
            $jobcircle_variables = (array)$jobcircle_variables;
            foreach ($jobcircle_variables as $key => $jobcircle_variable) {
                $callback_exists = false;

                if (isset($jobcircle_variable['direct_value'])) {
                    $jobcircle_value = $jobcircle_variable['direct_value'];
                    if (false != $jobcircle_value && !is_array($jobcircle_value)) {
                        $jobcircle_template = str_replace($jobcircle_variable['var'], $jobcircle_value, $jobcircle_template);
                    }
                } else {
                    
                    if (is_array($jobcircle_variable['function_callback'])) { 
                        $callback_exists = method_exists($jobcircle_variable['function_callback'][0], $jobcircle_variable['function_callback'][1]);
                    } else {
                        $callback_exists = function_exists($jobcircle_variable['function_callback']);
                    }
                    
                    if (true == $callback_exists) {
                            
                        $jobcircle_value = call_user_func($jobcircle_variable['function_callback']);
                        
                        if (false != $jobcircle_value) {
                            $jobcircle_template = str_replace($jobcircle_variable['var'], $jobcircle_value, $jobcircle_template);
                        }
                    }
                }
            }
            return $jobcircle_template;
        }
    }

    new Jobcircle_Email();
}