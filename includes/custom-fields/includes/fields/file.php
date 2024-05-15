<?php

class cstmfield_file extends cstmfield_field
{

    function __construct() {
        $this->name = 'file';
        $this->label = __( 'File Upload', 'jobcircle-frame' );
    }


    function html( $field ) {
        $file_url = $field->value;

        if ( ctype_digit( $field->value ) ) {
            if ( wp_attachment_is_image( $field->value ) ) {
                $file_url = wp_get_attachment_image_src( $field->value );
                $file_url = '<img src="' . $file_url[0] . '" />';
            }
            else
            {
                $file_url = wp_get_attachment_url( $field->value );
                $filename = substr( $file_url, strrpos( $file_url, '/' ) + 1 );
                $file_url = '<a href="'. $file_url .'" target="_blank">'. $filename .'</a>';
            }
        }

        // CSS logic for "Add" / "Remove" buttons
        $css = empty( $field->value ) ? [ '', ' hidden' ] : [ ' hidden', '' ];
    ?>
        <span class="file_url"><?php echo jobcircle_esc_the_html($file_url); ?></span>
        <input type="button" class="media button add<?php echo jobcircle_esc_the_html($css[0]); ?>" value="<?php _e( 'Add File', 'jobcircle-frame' ); ?>" />
        <input type="button" class="media button remove<?php echo jobcircle_esc_the_html($css[1]); ?>" value="<?php _e( 'Remove', 'jobcircle-frame' ); ?>" />
        <input type="hidden" name="<?php echo jobcircle_esc_the_html($field->input_name); ?>" class="file_value" value="<?php echo jobcircle_esc_the_html($field->value); ?>" />
    <?php
    }


    function options_html( $key, $field ) {
    ?>
        <tr class="field_option field_option_<?php echo jobcircle_esc_the_html($this->name); ?>">
            <td class="label">
                <label><?php _e( 'File Type', 'jobcircle-frame' ); ?></label>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'select',
                        'input_name' => "cstmfield[fields][$key][options][file_type]",
                        'options' => [
                            'choices' => [
                                'file'  => __( 'Any', 'jobcircle-frame' ),
                                'image' => __( 'Image', 'jobcircle-frame' ),
                                'audio' => __( 'Audio', 'jobcircle-frame' ),
                                'video' => __( 'Video', 'jobcircle-frame' )
                            ],
                            'force_single' => true,
                        ],
                        'value' => $this->get_option( $field, 'file_type', 'file' ),
                    ] );
                ?>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo jobcircle_esc_the_html($this->name); ?>">
            <td class="label">
                <label><?php _e( 'Return Value', 'jobcircle-frame' ); ?></label>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'select',
                        'input_name' => "cstmfield[fields][$key][options][return_value]",
                        'options' => [
                            'choices' => [
                                'url' => __( 'File URL', 'jobcircle-frame' ),
                                'id' => __( 'Attachment ID', 'jobcircle-frame' )
                            ],
                            'force_single' => true,
                        ],
                        'value' => $this->get_option( $field, 'return_value', 'url' ),
                    ] );
                ?>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo jobcircle_esc_the_html($this->name); ?>">
            <td class="label">
                <label><?php _e( 'Validation', 'jobcircle-frame' ); ?></label>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'true_false',
                        'input_name' => "cstmfield[fields][$key][options][required]",
                        'input_class' => 'true_false',
                        'value' => $this->get_option( $field, 'required' ),
                        'options' => [ 'message' => __( 'This is a required field', 'jobcircle-frame' ) ],
                    ] );
                ?>
            </td>
        </tr>
    <?php
    }


    function input_head( $field = null ) {
        wp_enqueue_media();
    ?>
        <style>
        .cstmfield_frame .media-frame-menu {
            display: none;
        }
        
        .cstmfield_frame .media-frame-title,
        .cstmfield_frame .media-frame-router,
        .cstmfield_frame .media-frame-content,
        .cstmfield_frame .media-frame-toolbar {
            left: 0;
        }
        </style>

        <script>
        (function($) {
            $(function() {

                var cstmfield_frame;

                $(document).on('click', '.cstmfield_input .media.button.add', function(e) {
                    $this = $(this);

                    if (cstmfield_frame) {
                        cstmfield_frame.open();
                        return;
                    }

                    cstmfield_frame = wp.media.frames.cstmfield_frame = wp.media({
                        className: 'media-frame cstmfield_frame',
                        frame: 'post',
                        multiple: false,
                        library: {
                            type: 'image'
                        }
                    });

                    cstmfield_frame.on('insert', function() {
                        var attachment = cstmfield_frame.state().get('selection').first().toJSON();
                        if ('image' == attachment.type && 'undefined' != typeof attachment.sizes) {
                            file_url = attachment.sizes.full.url;
                            if ('undefined' != typeof attachment.sizes.thumbnail) {
                                file_url = attachment.sizes.thumbnail.url;
                            }
                            file_url = '<img src="' + file_url + '" />';
                        }
                        else {
                            file_url = '<a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a>';
                        }
                        $this.hide();
                        $this.siblings('.media.button.remove').show();
                        $this.siblings('.file_value').val(attachment.id);
                        $this.siblings('.file_url').html(file_url);
                    });

                    cstmfield_frame.open();
                    cstmfield_frame.content.mode('upload');
                });

                $(document).on('click', '.cstmfield_input .media.button.remove', function() {
                    $(this).siblings('.file_url').html('');
                    $(this).siblings('.file_value').val('');
                    $(this).siblings('.media.button.add').show();
                    $(this).hide();
                });
            });
        })(jQuery);
        </script>
    <?php
    }


    function format_value_for_api( $value, $field = null ) {
        if ( ctype_digit( $value ) ) {
            $return_value = $this->get_option( $field, 'return_value', 'url' );
            return ( 'id' == $return_value ) ? (int) $value : wp_get_attachment_url( $value );
        }
        return $value;
    }
}
