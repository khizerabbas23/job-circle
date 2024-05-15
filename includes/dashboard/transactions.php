<?php

add_filter('jobcircle_dashboard_candidate_transactions_html', 'jobcircle_dashboard_transactions_html');
add_filter('jobcircle_dashboard_employer_transactions_html', 'jobcircle_dashboard_transactions_html');
add_filter('jobcircle_dashboard_transaction_detail_html', 'jobcircle_dashboard_transaction_detail_html', 10, 2);

function jobcircle_dashboard_transactions_html(){

    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $jobcircle_account_tab = isset( $_GET['account_tab'] ) ? sanitize_text_field($_GET['account_tab']) : '';
        $jobcircle_order_id = isset( $_GET['order_id'] ) ? intval($_GET['order_id']) : '';

        if($jobcircle_account_tab == 'transactions' && !empty($jobcircle_order_id)){
            echo apply_filters('jobcircle_dashboard_transaction_detail_html', '', $jobcircle_order_id);       
        } else {
            $jobcircle_dashboard_page   = get_permalink();
            $order_count = 50;               
            $jobcircle_user_id = get_current_user_id();

            if (jobcircle_user_account_type($jobcircle_user_id) == 'employer') {
                $jobcircle_user_packages = apply_filters('jobcircle_employer_packages', array());
            } elseif (jobcircle_user_account_type($jobcircle_user_id) == 'candidate') {
                $jobcircle_user_packages = apply_filters('jobcircle_candidate_packages', array());
            }

            $jobcircle_args = array(
                'limit' => -1,
                'post_status' => array('wc-completed'),
                'customer_id' => $jobcircle_user_id,
                'order' => 'DESC',
                'orderby' => 'ID',
                'meta_query' => array(
                    array(
                        'key' => 'order_attach_with_pkg',
                        'value' => 'yes',
                        'compare' => '=',
                    ),
                    array(
                        'key'     => 'order_pkg_type',
                        'value'   => array_keys( $jobcircle_user_packages ), // get all package types
                        'compare' => 'IN',
                    ),
                    array(
                        'key' => 'order_user_id',
                        'value' => $jobcircle_user_id,
                        'compare' => '=',
                    ),
                ),
            );                                
            $jobcircle_query = new WC_Order_Query($jobcircle_args);
            $customer_orders = $jobcircle_query->get_orders();       
            
            ob_start();
            
            if ( $customer_orders ) : ?>

                <div class="jobcirlce-user-transactions">
                    <h2><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', esc_html__( 'Recent orders', 'jobcirlce-frame' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
                
                    <table class="shop_table shop_table_responsive my_account_orders">
                
                        <thead>
                            <tr>
                                <?php 
                                $my_orders_columns = apply_filters(
                                    'woocommerce_my_account_my_orders_columns',
                                    array(
                                        'order-number'  => esc_html__( 'Order', 'jobcirlce-frame' ),
                                        'order-date'    => esc_html__( 'Date', 'jobcirlce-frame' ),
                                        'order-status'  => esc_html__( 'Status', 'jobcirlce-frame' ),
                                        'order-total'   => esc_html__( 'Total', 'jobcirlce-frame' ),
                                        'order-actions' => '&nbsp;',
                                    )
                                );    
                                foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
                                    <th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                
                        <tbody>
                            <?php
                            foreach ( $customer_orders as $customer_order ) :
                                $order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                                if (is_a($order, 'WC_Order')) {
                                    $item_count = $order->get_item_count();
                                    ?>
                                    <tr class="order">
                                        <?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
                                            <td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
                                                <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                                                    <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>
                    
                                                <?php elseif ( 'order-number' === $column_id ) : ?>
                                                    <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
                                                        <?php echo _x( '#', 'hash before order number', 'jobcirlce-frame' ) . $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                    </a>
                    
                                                <?php elseif ( 'order-date' === $column_id ) : ?>
                                                    <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
                    
                                                <?php elseif ( 'order-status' === $column_id ) : ?>
                                                    <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
                    
                                                <?php elseif ( 'order-total' === $column_id ) : ?>
                                                    <?php
                                                    /* translators: 1: formatted order total 2: total order items */
                                                    printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'jobcirlce-frame' ), $order->get_formatted_order_total(), $item_count ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                    ?>
                    
                                                <?php elseif ( 'order-actions' === $column_id ) : ?>
                                                    <?php
                
                                                        
                                                    $jobcircle_transaction_detail = add_query_arg(
                                                        array(
                                                            'account_tab'=>$jobcircle_account_tab,
                                                            'order_id'=>$order->get_id(),
                                                        ),
                                                        $jobcircle_dashboard_page
                                                    );
                                                    $actions = wc_get_account_orders_actions( $order );
                
                                                    //print_r($actions);
                    
                                                    if ( ! empty( $actions ) ) {
                                                        echo '<a href="' . esc_url( $jobcircle_transaction_detail ) . '" class="button view">' . esc_html__( 'View', 'jobcircle-frame' ) . '</a>';
                                                        
                                                    }
                                                    ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php 
                                }
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            
                <?php 
            endif;
            $jobcircle_html = ob_get_clean();
            return apply_filters('jobcircle_dashboard_transactions_html', $jobcircle_html);
        }
    } else {
        ?>
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="postjob-pakges-nofound">
                    <span><?php esc_html_e('You can\'t view package transactions. Please contact to the administrator.', 'jobcircle-frame') ?></span>
                </div>
            </div>
        </div>
        <?php
    }

}

function jobcircle_dashboard_transaction_detail_html($jobcirlce_html, $jobcircle_order_id){
    $order = wc_get_order( $jobcircle_order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

    if ( ! $order ) {
        return;
    }    
    $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
    $show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
    $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
    ob_start();
    ?>
    <div class="jobcirlce-user-transaction-detail">
        <section class="jobcircle-transaction-detials woocommerce-order-details">
            <?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
        
            <h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'jobcirlce-frame' ); ?></h2>
        
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
        
                <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'jobcirlce-frame' ); ?></th>
                        <th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'jobcirlce-frame' ); ?></th>
                    </tr>
                </thead>
        
                <tbody>
                    <?php
                    do_action( 'woocommerce_order_details_before_order_table_items', $order );
        
                    foreach ( $order_items as $item_id => $item ) {
                        $product = $item->get_product();
        
                        wc_get_template(
                            'order/order-details-item.php',
                            array(
                                'order'              => $order,
                                'item_id'            => $item_id,
                                'item'               => $item,
                                'show_purchase_note' => $show_purchase_note,
                                'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                'product'            => $product,
                            )
                        );
                    }
        
                    do_action( 'woocommerce_order_details_after_order_table_items', $order );
                    ?>
                </tbody>
        
                <tfoot>
                    <?php
                    foreach ( $order->get_order_item_totals() as $key => $total ) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
                                <td><?php echo wp_kses_post( $total['value'] ); ?></td>
                            </tr>
                            <?php
                    }
                    ?>
                    <?php if ( $order->get_customer_note() ) : ?>
                        <tr>
                            <th><?php esc_html_e( 'Note:', 'jobcirlce-frame' ); ?></th>
                            <td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
                        </tr>
                    <?php endif; ?>
                </tfoot>
            </table>
        </section>    
        <?php
        /**
         * Action hook fired after the order details.
         *
         * @since 4.4.0
         * @param WC_Order $order Order data.
         */
        do_action( 'woocommerce_after_order_details', $order );
        
        if ( $show_customer_details ) {
            wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
        }
        ?>
    </div>
    <?php
    $jobcircle_html = ob_get_clean();
    return apply_filters('jobcircle_dashboard_transaction_detail_html_filter', $jobcircle_html, $order);
}
