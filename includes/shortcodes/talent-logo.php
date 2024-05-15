<?php

namespace Elementor;

if (!defined('ABSPATH')) {  
  die;
} // Cannot access pages directly.
/**
 * Accordion Widget.
 *
 * @version       1.0
 * @author        zercarbon
 * @category      Classes
 * @author        waseemjutt
 */
class jc_talent_company_logo extends Widget_Base
{

  public function get_name()
  {
    return 'talent-company-logo';
  }

  public function get_title()
  {
    return 'Talent Company Logo';
  }

  public function get_icon()
  {
    return 'pa-grid';
  }


  public function get_categories()
  {
    return array('zc-elementor');
  }


  protected function _register_controls()
  {
    $this->start_controls_section(
      'talent-company-logo',
      array(
        'label' => esc_html__('Talent Company Logo', 'webify-addons')
      )
    );

    // Multi

    $repeater = new Repeater();
    
   
    $repeater->add_control(
      'comp_logo',
      array(
        'label'       => esc_html__('Company Logo', 'webify-addons'),
        'default'     => [],
        'label_block' => true,
        'type'        => Controls_Manager::MEDIA
      )
    );
    $repeater->add_control(
      'comp_logo_url',
      array(
        'label'       => esc_html__('Company Logo Url', 'webify-addons'),
        'default'     => 'FOCUSED',
        'label_block' => true,
        'type'        => Controls_Manager::TEXT
      )
    );

    

    $this->add_control(
      'zc_tab_list_multi',
      array(
        'heading'     => esc_html__('Tabs', 'webify-addons'),
        'type'        => Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'separator' => 'after',
        'default'    => array(
          array(
            'icon'                => '',
            'name'            => '',
            'url'            => '',
          ),
        ),
        'title_field' => '<span>{{ name }}</span>',
      )
    );

    $this->end_controls_section();
  }
// single
  protected function render()
  {
    $settings    = $this->get_settings_for_display();

    $zc_tab_lists = $settings['zc_tab_list_multi'];

?> 
<section class="section section-theme-13 happy-workers-block bg-white pt-0 pb-40 pb-md-50 pb-lg-80 pb-xl-100">
		<div class="container">
    <ul class="logos_list mt-40 mt-md-80 mt-lg-90 mt-xl-100 mt-xxl-120">
						<?php
						 if (is_array($zc_tab_lists) && !empty($zc_tab_lists)) :
              foreach ($zc_tab_lists as $key => $zc_tab_list) :
                
              $comp_logo = $zc_tab_list['comp_logo'];
              $comp_logo_url = $zc_tab_list['comp_logo_url'];
						?>
									<li>
							<div class="logo-holder">
								<?php if (!empty($comp_logo_url) && !empty($comp_logo)) {
									?>
									<a href="<?php echo esc_html($comp_logo_url) ?>"><img src="<?php echo esc_url_raw($comp_logo['url']) ?>"
											alt="img"></a>
									<?php
								} ?>
							</div>
						</li>
							<?php
							endforeach;
							?>
					</ul>
		</div>
	</section>
    <?php
          endif;
        }
      }
      Plugin::instance()->widgets_manager->register_widget_type(new jc_talent_company_logo());

