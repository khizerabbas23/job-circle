<?php

class cstmfield_true_false extends cstmfield_field
{

    function __construct() {
        $this->name = 'true_false';
        $this->label = __('True / False', 'jobcircle-frame');
    }




    function html( $field ) {
        $field->value = ( 0 < (int) $field->value ) ? 1 : 0;
    ?>
		<label>
			<input type="checkbox" <?php echo $field->value ? ' checked' : ''; ?>>
			<span><?php echo $field->options['message']; ?></span>
			<input type="hidden" name="<?php echo $field->input_name; ?>" class="<?php echo $field->input_class; ?>" value="<?php echo $field->value; ?>" />
		</label>
    <?php
    }




    function options_html( $key, $field ) {
    ?>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Message', 'jobcircle-frame' ); ?></label>
                <p class="description"><?php _e( 'The text beside the checkbox', 'jobcircle-frame' ); ?></p>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'text',
                        'input_name' => "cstmfield[fields][$key][options][message]",
                        'value' => $this->get_option( $field, 'message' ),
                    ] );
                ?>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
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
    ?>
        <script>
        (function($) {
            $(function() {
                $(document).on('cstmfield/ready', '.cstmfield_add_field', function() {
                    $('.cstmfield_true_false:not(.ready)').init_true_false();
                });
                $('.cstmfield_true_false').init_true_false();
            });

            $.fn.init_true_false = function() {
                this.each(function() {
                    var $this = $(this);
                    $this.addClass('ready');

                    // handle click
                    $this.find('input[type="checkbox"]').on('change click', function() {
                        var val = $(this).prop('checked') ? 1 : 0;
                        $(this).siblings('.true_false').val(val);
                    });
                });
            }
        })(jQuery);
        </script>
    <?php
    }




    function format_value_for_api( $value, $field = null ) {
        return ( 0 < (int) $value ) ? 1 : 0;
    }
}
