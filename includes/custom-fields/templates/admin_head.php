<?php

global $post;

/*---------------------------------------------------------------------------------------------
    Field management screen
---------------------------------------------------------------------------------------------*/

if ( 'cstmfield' == $screen->post_type ) {
    foreach ( JOBCIRCLE_CFS()->fields as $field_name => $field_data ) {
        ob_start();
        JOBCIRCLE_CFS()->fields[ $field_name ]->options_html( 'clone', $field_data );
        $options_html[ $field_name ] = ob_get_clean();
    }

    $field_count = get_post_meta( $post->ID, 'cstmfield_fields', true );
    $field_count = is_array( $field_count ) ? count( $field_count ) : 0;

    // Build clone HTML
    $field = (object) [
        'id'            => 0,
        'parent_id'     => 0,
        'name'          => 'new_field',
        'label'         => __( 'New Field', 'jobcircle-frame' ),
        'type'          => 'text',
        'notes'         => '',
        'weight'        => 'clone',
    ];

    ob_start();
    JOBCIRCLE_CFS()->field_html( $field );
    $field_clone = ob_get_clean();
?>

<script>
var JOBCIRCLE_CFS = JOBCIRCLE_CFS || {};
JOBCIRCLE_CFS['field_index'] = <?php echo $field_count; ?>;
JOBCIRCLE_CFS['field_clone'] = <?php echo json_encode( $field_clone ); ?>;
JOBCIRCLE_CFS['options_html'] = <?php echo json_encode( $options_html ); ?>;
</script>
<script src="<?php echo JOBCIRCLE_CFS_URL; ?>/assets/js/fields.js"></script>
<script src="<?php echo JOBCIRCLE_CFS_URL; ?>/assets/js/select2/select2.min.js"></script>
<script src="<?php echo JOBCIRCLE_CFS_URL; ?>/assets/js/jquery-powertip/jquery.powertip.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JOBCIRCLE_CFS_URL; ?>/assets/css/fields.css" />
<link rel="stylesheet" type="text/css" href="<?php echo JOBCIRCLE_CFS_URL; ?>/assets/js/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="<?php echo JOBCIRCLE_CFS_URL; ?>/assets/js/jquery-powertip/jquery.powertip.css" />

<?php
}

/*---------------------------------------------------------------------------------------------
    Field input
---------------------------------------------------------------------------------------------*/

else {
    $hide_editor = false;
    $field_groups = JOBCIRCLE_CFS()->api->get_matching_groups( $post->ID );

    if ( ! empty( $field_groups ) ) {

        // Store field group IDs as an array for front-end forms
        JOBCIRCLE_CFS()->group_ids = array_keys( $field_groups );

        // Support for multiple metaboxes
        foreach ( $field_groups as $group_id => $title ) {

            // Get field group options
            $extras = get_post_meta( $group_id, 'cstmfield_extras', true );
            $context = isset( $extras['context'] ) ? $extras['context'] : 'normal';
            $priority = ( 'normal' == $context ) ? 'high' : 'core';

            if ( isset( $extras['hide_editor'] ) && 0 < (int) $extras['hide_editor'] ) {
                $hide_editor = true;
            }

            $args = [ 'box' => 'input', 'group_id' => $group_id ];
            add_meta_box( "cstmfield_input_$group_id", $title, [ $this, 'meta_box' ], $post->post_type, $context, $priority, $args );
            add_filter( "postbox_classes_{$post->post_type}_cstmfield_input_{$group_id}", 'cstmfield_postbox_classes' );
        }

        // Force editor support
        $has_editor = post_type_supports( $post->post_type, 'editor' );
        add_post_type_support( $post->post_type, 'editor' );

        if ( ! $has_editor || $hide_editor ) {
            echo '<style type="text/css">#poststuff .postarea { display: none; }</style>';
        }
    }
}

function cstmfield_postbox_classes( $classes ) {
    $classes[] = 'cstmfield_input';
    return $classes;
}
