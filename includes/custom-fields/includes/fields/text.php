<?php

class cstmfield_text extends cstmfield_field
{

    function __construct() {
        $this->name = 'text';
        $this->label = __( 'Text', 'jobcircle-frame' );
    }


    function options_html( $key, $field ) {
    ?>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Default Value', 'jobcircle-frame' ); ?></label>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'text',
                        'input_name' => "cstmfield[fields][$key][options][default_value]",
                        'value' => $this->get_option( $field, 'default_value' ),
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
}
