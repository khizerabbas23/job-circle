<?php
function jobcircle_trusted_by_world_best()
{
  vc_map(
    array(
      'name' => __('Trusted By World'),
      'base' => 'jc_trusted_by_world_best',
      'category' => __('Job Circle'),
      'params' => array(
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Title'),
          'param_name' => 'title',
        ),
        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'multi',
          'params' => array(
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Image Url'),
              'param_name' => 'img_url',
            ),
            array(
              'type' => 'jobcircle_browse_img',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Image'),
              'param_name' => 'image',
            ),
          ),
        )
      )
    )
  );
}
add_action('vc_before_init', 'jobcircle_trusted_by_world_best');
// Frontend Coding 

function jobcircle_trusted_by_world_best_front($atts, $content)
{

  $atts = shortcode_atts(
    array(

      'title' => '',
      'multi' => '',
    ),
    $atts,
    'jobcircle_trusted_by_world_best'
  );

  $title = isset($atts['title']) ? $atts['title'] : '';
  ob_start();
?>
  <section class="section section-theme-8 section-explores pt-35 pt-md-50 pb-35 pb-md-50 pb-lg-65 pb-xl-100">
    <div class="container">
      <div class="section-header mb-20 md-md-50 text-center">
        <?php if (!empty($title)) {
        ?>
          <h3 class="h6">
            <?php echo esc_html($title, 'jobcircle-frame') ?>
          </h3>
        <?php
        } ?>
      </div>
      <ul class="sites-list">
        <?php

        $lm_team_list = vc_param_group_parse_atts($atts['multi']);
        foreach ($lm_team_list as $key => $value) {

          $img_url = isset($value['img_url']) ? $value['img_url'] : '';
          $image = isset($value['image']) ? $value['image'] : '';
       
          if (!empty($img_url) || !empty($image)) { ?>
          
            <li><a href="<?php echo esc_html($img_url, 'jobcircle-frame') ?>">
                <img src="<?php echo esc_url_raw($image, 'jobcircle-frame') ?>" alt="Image Description"></a></li>
          <?php
          } 
        }
        ?>

      </ul>
    </div>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('jc_trusted_by_world_best', 'jobcircle_trusted_by_world_best_front');
