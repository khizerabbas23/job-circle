<?php

global $post, $wpdb, $wp_roles;

$equals_text = __( 'equals', 'jobcircle-frame' );
$not_equals_text = __( 'is not', 'jobcircle-frame' );
$rules = (array) get_post_meta( $post->ID, 'cstmfield_rules', true );

// Populate rules if empty
$rule_types = [
    'post_types'
];

foreach ( $rule_types as $type ) {
    if ( ! isset( $rules[ $type ] ) ) {
        $rules[ $type ] = [ 'operator' => [ '==' ], 'values' => [] ];
    }
}

// Post types
$post_types = [];
$types = get_post_types();
foreach ( $types as $post_type ) {
    if ( ! in_array( $post_type, [ 'cstmfield', 'attachment', 'revision', 'nav_menu_item' ] ) ) {
        $post_types[ $post_type ] = $post_type;
    }
}
$post_types = ['jobs' => 'Jobs', 'candidates' => 'Candidates', 'employer' => 'Employers'];

// Post formats
$post_formats = [];
if ( current_theme_supports( 'post-formats' ) ) {
    $post_formats = [ 'standard' => 'Standard' ];
    $post_formats_slugs = get_theme_support( 'post-formats' );

    if ( is_array( $post_formats_slugs[0] ) ) {
        foreach ( $post_formats_slugs[0] as $post_format ) {
            $post_formats[ $post_format ] = get_post_format_string( $post_format );
        }
    }
}

// User roles
foreach ( $wp_roles->roles as $key => $role ) {
    $user_roles[ $key ] = $key;
}

// Post IDs
$post_ids = [];
$json_posts = [];

if ( ! empty( $rules['post_ids']['values'] ) ) {
    $post_in = implode( ',', $rules['post_ids']['values'] );

    $sql = "
    SELECT ID, post_type, post_title, post_parent
    FROM $wpdb->posts
    WHERE ID IN ($post_in)
    ORDER BY post_type, post_title";
    $results = $wpdb->get_results( $sql );

    foreach ( $results as $result ) {
        $parent = '';

        if (
            isset( $result->post_parent ) &&
            absint( $result->post_parent ) > 0 &&
            $parent = get_post( $result->post_parent )
        ) {
            $parent = "$parent->post_title >";
        }

        $json_posts[] = [ 'id' => $result->ID, 'text' => "($result->post_type) $parent $result->post_title (#$result->ID)" ];
        $post_ids[] = $result->ID;
    }
}

// Term IDs
$sql = "
SELECT t.term_id, t.name, tt.taxonomy
FROM $wpdb->terms t
INNER JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id AND tt.taxonomy != 'post_tag'
ORDER BY tt.parent, tt.taxonomy, t.name";
$results = $wpdb->get_results( $sql );

foreach ( $results as $result ) {
    $term_ids[ $result->term_id ] = "($result->taxonomy) $result->name";
}

// Page templates
$page_templates = [];
$templates = get_page_templates();

foreach ( $templates as $template_name => $filename ) {
    $page_templates[ $filename ] = $template_name;
}

?>

<script>
(function($) {
    $(function() {
        var cstmfield_nonce = '<?php echo wp_create_nonce( 'cstmfield_admin_nonce' ); ?>';

        $('.select2').select2({
            placeholder: '<?php _e( 'Leave blank to skip this rule', 'jobcircle-frame' ); ?>'
        });

        $('.select2-ajax').select2({
            multiple: true,
            placeholder: '<?php _e( 'Leave blank to skip this rule', 'jobcircle-frame' ); ?>',
            minimumInputLength: 2,
            ajax: {
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: function(term, page) {
                    return {
                        q: term,
                        action: 'cstmfield_ajax_handler',
                        action_type: 'search_posts',
                        nonce: cstmfield_nonce
                    }
                },
                results: function(data, page) {
                    return { results: data };
                }
            },
            initSelection: function(element, callback) {
                var data = [];
                var post_ids = <?php echo json_encode( $json_posts ); ?>;
                $(post_ids).each(function(idx, val) {
                    data.push({ id: val.id, text: val.text });
                });
                callback(data);
            }
        });
    });
})(jQuery);
</script>

<table>
    <tr>
        <td class="label">
            <label><?php _e( 'Post Type', 'jobcircle-frame' ); ?></label>
        </td>
        <td style="width:80px; vertical-align:top; display:none;">
            <?php
                JOBCIRCLE_CFS()->create_field( [
                    'type' => 'select',
                    'input_name' => "cstmfield[rules][operator][post_types]",
                    'options' => [
                        'choices' => [
                            '==' => $equals_text,
                            //'!=' => $not_equals_text,
                        ],
                        'force_single' => true,
                    ],
                    'value' => $rules['post_types']['operator'],
                ] );
            ?>
        </td>
        <td>
            <?php
                JOBCIRCLE_CFS()->create_field( [
                    'type' => 'select',
                    'input_class' => 'select2',
                    'input_name' => "cstmfield[rules][post_types]",
                    'options' => [ 'multiple' => '0', 'choices' => $post_types ],
                    'value' => $rules['post_types']['values'],
                ] );
            ?>
        </td>
    </tr>
    
</table>
