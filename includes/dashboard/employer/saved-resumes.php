<?php

add_filter('jobcircle_dashboard_employer_saved_resumes_html', 'jobcircle_dashboard_employer_saved_resumes_html');

function jobcircle_dashboard_employer_saved_resumes_html()
{

   $page_permissions = jobcircle_check_page_permissions('employer', 'saved-resumes');
   if ($page_permissions === 0) {
      $home_page_url = home_url('/');
      echo '<script>window.location.href="' . $home_page_url . '"</script>';
      exit;
   }

   ob_start();
   global $current_user;
   $user_id = $current_user->ID;
   $fav_jobs = get_user_meta($user_id, 'fav_follower_list', true);
?>
   <section class="table-responsive bg-wshite">
      <div class="alert-job-table-container">
         <table class="table">
            <thead>
               <tr>
                  <th class="heading-first-col">Job Title</th>
                  <th class="heading-middle-col">Location</th>
                  <th class="heading-middle-col">Date</th>
                  <th class="heading-last-col">Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php
               if (!empty($fav_jobs)) {
                  foreach ($fav_jobs as $emplpostId) {
                     $permalink = get_the_permalink($emplpostId);
                     $location = get_post_meta($emplpostId, 'jobcircle_field_location', true);
                     $image = wp_get_attachment_image_src(get_post_thumbnail_id($emplpostId), 'thumbnail');
                     $date = get_the_date();
                     ?>
                     <tr>
                        <td class="row-first-column">
                           <div class="image-holder"><img src="<?php echo $image[0] ?>"></div>
                           <div class="textbox">
                              <div><?php echo get_the_title($emplpostId); ?> <span>(Full Time)</span></div>

                              <div>Afiniti Studio <span class="job-status">Active</span></div>
                           </div>
                        </td>
                        <td>Texas, USA</td>
                        <td><?php echo $date; ?></td>
                        <td>
                        <div class="dash-action">
                           <a class="jobcircle-delete-follower-btn p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1" data-id="<?php echo jobcircle_esc_the_html($emplpostId) ?>"><i class="fa fa-trash"></i></a>
                           <a class ="eye-icone" href="<?php echo jobcircle_esc_the_html($permalink) ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAOCAYAAAArMezNAAAB0klEQVQ4jXXUS4hPYRgG8N9IyW1B2WhmI8wSC5ERzR+pKSmkFHINKYUaNZKkSXKZWYma5JZbk5pZWIlIbmUhm1lMlhTNaBgyRfTqPXX8O546nfO9l+c83/t+79dQ6xz1H0zHcrRhCWak/ROe4T4eY7gqeXyFrQGbcRjz8DZJ3qV/FlZjF97gHG7gd5lkXB1pJPXiMoawCi2l9VB+t6RvONe9mVupeBFuYTJ2pIpJ6MI2fM24qbiCg1iBLTiLB9iEl2XFUceHGMFKXE97N3ajHQvyaU9bd8Zcy5wvydH2t561ztHW3MoANuBDaQePcAKn60p2BMfRWijEzORpDp5Q3IPPWF8ilQET0V/R4P70NZds75MjuHqCuA9NWFuXHGX5icYK4sb0jdTZ1yRXXxB34CYuZkMKPMcgzmRwgaa0DWZMgci9lFwdcSp+YC++4zzm4Cg+4gDu4VW+A+swJd8RMw2d2IcLOISx4riNYX+qOIWlOJZlWog9eXYDt1PZQJbvJOYmYVchv2qkgzSCF+dkXcWT/HlgApZhK+bjRYp4WiapGukIiKnaiO25zRia6HYgtv4Nr7ETd7OR/6CKOBCB0YQ7eRHVMDt9Ua4YhLiAflVm4w+thnMpIM1DQgAAAABJRU5ErkJggg==">
                           </a>
                        </div>
                        </td>
                     </tr>
                     <?php
                  }
               } else {
                  ?>
                  <tr>
                        <td colspan="7"><?php esc_html_e('No result found.', 'jobcircle-frame') ?></td>
                  </tr>
                  <?php
               }
               ?>
            </tbody>
         </table>
      </div>
   </section>
<?php
   $html = ob_get_clean();
   return $html;
}
