function default_load_products_by_category() {
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : '';
    $min_price = isset($_POST['min_price']) ? floatval($_POST['min_price']) : 0;
    $max_price = isset($_POST['max_price']) ? floatval($_POST['max_price']) : PHP_INT_MAX;

   $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10, // Set a default number of products to show
        'tax_query' => array(),
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        )
    );
    if (!empty($category_id)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => $category_id,
            )
        );
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) : 
        while ($query->have_posts()) : $query->the_post();
            $product = wc_get_product(get_the_ID());
            $rating_count = $product->get_rating_count();
            $average = $product->get_average_rating();
            $image_url = wp_get_attachment_image_url($product->get_image_id(), 'full');
            ?>
            <li class="grid-list">
                <div class="d-flex align-items-center">
                  <img alt="product" src="<?php echo esc_url($image_url); ?>">
                  <div class="weekly-sellers-text">
                    <span><?php echo esc_html__('last ballons') ?></span>
                    <a href="<?php the_permalink(); ?>"><h5><?php echo esc_html(get_the_title()); ?></h5></a>
                    <div class="star">
                      <?php for ($i = 0; $i < 5; $i++): ?>
                          <i class="fa-solid fa-star" style="<?php echo ($i < $average) ? '' : 'color: #ccc;'; ?>"></i>
                      <?php endfor; ?>
                    </div>
                    <h6><?php echo wc_price($product->get_price()); ?></h6>
                  </div>
                </div>
                <div class="grid-list-text">
                  <ul class="color">
                    <!-- Colors can be fetched dynamically if you have them stored in a custom field -->
                    <li class="purple"></li>
                    <li class="blue"></li>
                    <li class="orange"></li>
                  </ul>
                  <span>SKU <?php echo esc_html($product->get_sku()); ?></span>
                  <div class="add-to-cart two">
                    <a href="#" class="btn"><span>Add to Cart</span></a>
                    <a href="#" class="heart-wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </a>
                  </div>
                </div>
              </li>
            <?php
        endwhile; 
    else:
        echo '<li>No products found in this category.</li>';
    endif;
    ?>
     
             
            </ul>
          </div>
          
        </div>
      </div>
      </div>

</section>
<?php
    wp_reset_postdata();
    echo ob_get_clean();
    die();
}