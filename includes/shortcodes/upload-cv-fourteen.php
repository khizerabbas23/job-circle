<?php

function jobcircle_upload_cv()

{

  vc_map(

    array(

      'name' => __('Upload CV'),

      'base' => 'upload_cv',

      'category' => __('job Circle'),

      'params' => array(



        //group

        array(

          'type' => 'param_group',

          'value' => '',

          'param_name' => 'upload_cv_multi',

          'params' => array(



            array(

              'type' => 'jobcircle_browse_img',

              'holder' => 'div',

              'class' => '',

              'heading' => __('Image'),

              'param_name' => 'image',

            ),

            array(

              'type' => 'textfield',

              'holder' => 'div',

              'class' => '',

              'heading' => __('Title'),

              'param_name' => 'title',

            ),

            array(

              'type' => 'textfield',

              'holder' => 'div',

              'class' => '',

              'heading' => __('Discription'),

              'param_name' => 'disc',

            ),
            array(

              'type' => 'textfield',

              'holder' => 'div',

              'class' => '',

              'heading' => __('Url'),

              'param_name' => 'url',

            ),


          )

        )

      ),

    )

  );

}

add_action('vc_before_init', 'jobcircle_upload_cv');



//welcome Massage frontend

function jobcircle_upload_cv_frontend($atts, $content)

{



  $atts = shortcode_atts(

    array(



      'upload_cv_multi' => '',



    ),

    $atts,

    'jobcircle_upload_cv'

  );

  $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

  ob_start()

?>

  <section class="section section-theme-14 job_search_steps remote_jobt">

    <div class="container">

      <div class="row more_steps">



        <?php

        $lm_team_list = vc_param_group_parse_atts($atts['upload_cv_multi']);

        if (!empty($lm_team_list)) {

          foreach ($lm_team_list as $key => $value) {

            $title  = isset($value["title"]) ? $value["title"] : '';

            $disc  = isset($value["disc"]) ? $value["disc"] : '';

            $image = isset($value['image']) ? $value['image'] : '';
	    $url= isset($value['url']) ? $value['url'] : '';


        ?>

            <div class="col-12 col-lg-4 mb-30 mb-lg-30">

              <a class="link" href="<?php echo esc_html($url) ?>">

                <div class="wrap">

                  <div class="icon">

                

                    <img src="<?php echo esc_url_raw($image) ?>" alt="img">

                

                  </div>

                  <div class="text">

                    <?php

                    if (!empty($title)) {

                    ?>

                      <strong class="h5"><?php echo esc_html($title) ?></strong>

                    <?php

                    }

                    ?>

                    <?php

                    if (!empty($disc)) {

                    ?>

                      <p><?php echo esc_html($disc) ?></p>

                    <?php

                    }

                    ?>

                  </div>

                </div>

              </a>

            </div>

          <?php  } ?>

      </div>

    </div>

  </section>

<?php

          return ob_get_clean();

        }

      }

      add_shortcode('upload_cv', 'jobcircle_upload_cv_frontend');

