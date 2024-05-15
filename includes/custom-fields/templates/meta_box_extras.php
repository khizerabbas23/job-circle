<?php

global $wpdb;

// Post types
$post_types = [];
$types = get_post_types( [ 'public' => true ] );

foreach ( $types as $post_type ) {
    if ( ! in_array( $post_type, [ 'cstmfield', 'attachment' ] ) ) {
        $post_types[] = $post_type;
    }
}

$extras = (array) get_post_meta( $post->ID, 'cstmfield_extras', true );

if ( ! isset( $extras['hide_editor'] ) ) {
    $extras['hide_editor'] = '';
}
if ( ! isset( $extras['order'] ) ) {
    $extras['order'] = 0;
}
if ( ! isset( $extras['context'] ) ) {
    $extras['context'] = 'normal';
}

?>

<table>
    <tr>
        <td class="label">
            <label>
                <?php _e( 'Order', 'jobcircle-frame' ); ?>
                <div class="cstmfield_tooltip">?
                    <div class="tooltip_inner"><?php _e( 'The field group with the lowest order will appear first.', 'jobcircle-frame' ); ?></div>
                </div>
            </label>
        </td>
        <td style="vertical-align:top">
            <input type="text" name="cstmfield[extras][order]" value="<?php echo $extras['order']; ?>" style="width:80px" />
        </td>
    </tr>
    <tr>
        <td class="label">
            <label><?php _e( 'Position', 'jobcircle-frame' ); ?></label>
        </td>
        <td style="vertical-align:top">
            <input type="radio" name="cstmfield[extras][context]" value="normal"<?php echo ( $extras['context'] == 'normal' ) ? ' checked' : ''; ?> /> <?php _e( 'Normal', 'jobcircle-frame' ); ?> &nbsp; &nbsp;
            <input type="radio" name="cstmfield[extras][context]" value="side"<?php echo ( $extras['context'] == 'side' ) ? ' checked' : ''; ?> /> <?php _e( 'Side', 'jobcircle-frame' ); ?>
        </td>
    </tr>
    <tr>
        <td class="label">
            <label><?php _e( 'Display Settings', 'jobcircle-frame' ); ?></label>
        </td>
        <td style="vertical-align:top">
            <div>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type'          => 'true_false',
                        'input_name'    => "cstmfield[extras][hide_editor]",
                        'input_class'   => 'true_false',
                        'value'         => $extras['hide_editor'],
                        'options'       => [ 'message' => __( 'Hide the content editor', 'jobcircle-frame' ) ],
                    ] );
                ?>
            </div>
        </td>
    </tr>

</table>
