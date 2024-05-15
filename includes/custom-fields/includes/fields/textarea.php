<?php

class cstmfield_textarea extends cstmfield_field
{

    function __construct() {
        $this->name = 'textarea';
        $this->label = __( 'Textarea', 'jobcircle-frame' );
    }


    function html( $field ) {
    ?>
        <textarea name="<?php echo $field->input_name; ?>" class="<?php echo $field->input_class; ?>" rows="4"><?php echo $field->value; ?></textarea>
    <?php
    }


    function options_html($key, $field) {
    ?>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Default Value', 'jobcircle-frame' ); ?></label>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'textarea',
                        'input_name' => "cstmfield[fields][$key][options][default_value]",
                        'value' => $this->get_option( $field, 'default_value' ),
                    ] );
                ?>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Formatting', 'jobcircle-frame' ); ?></label>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'select',
                        'input_name' => "cstmfield[fields][$key][options][formatting]",
                        'options' => [
                            'choices' => [
                                'none' => __( 'None', 'jobcircle-frame' ),
                                'auto_br' => __( 'Convert newlines to <br />', 'jobcircle-frame' )
                            ],
                            'force_single' => true,
                        ],
                        'value' => $this->get_option( $field, 'formatting', 'auto_br' ),
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


    function format_value_for_input( $value, $field = null ) {
        return htmlspecialchars( $value, ENT_QUOTES );
    }


    function format_value_for_api( $value, $field = null ) {
        $formatting = $this->get_option( $field, 'formatting', 'none' );
        return ( 'none' == $formatting ) ? $value : nl2br( $value );
    }
}
