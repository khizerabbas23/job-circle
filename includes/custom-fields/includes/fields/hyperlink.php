<?php

class cstmfield_hyperlink extends cstmfield_field
{


    function __construct() {
        $this->name = 'hyperlink';
        $this->label = __( 'Hyperlink', 'jobcircle-frame' );
    }


    function html( $field ) {
        $field->value = [
            'url'    => isset( $field->value['url'] ) ? $field->value['url'] : '',
            'text'   => isset( $field->value['text'] ) ? $field->value['text'] : '',
            'class'  => isset( $field->value['class'] ) ? $field->value['class'] : '',
            'target' => isset( $field->value['target'] ) ? $field->value['target'] : '',
        ];
    ?>
        <div class="cstmfield-hyperlink" style="overflow:hidden;">
            <div class="cstmfield-hyperlink-url" style="width:39%;float:left;">
                <div><?php _e( 'URL', 'jobcircle-frame' ); ?></div>
                <input type="text" name="<?php echo esc_attr( $field->input_name ); ?>[url]" class="link-url" value="<?php echo esc_url( $field->value['url'] ); ?>" placeholder="http://" />
            </div>
            <div class="cstmfield-hyperlink-text" style="width:39%;float:left;margin-left:1%;">
                <div><?php _e( 'Link Text', 'jobcircle-frame' ); ?></div>
                <input type="text" name="<?php echo esc_attr( $field->input_name ); ?>[text]" class="link-text" value="<?php echo esc_attr( $field->value['text'] ); ?>" />
            </div>
            <div class="cstmfield-hyperlink-target" style="width:19%;float:left;margin-left:1%;">
                <div><?php _e( 'Link Target', 'jobcircle-frame' ); ?></div>
                <select class="link-target widefat" name="<?php echo esc_attr( $field->input_name ); ?>[target]">
                    <option value="none" <?php selected( 'none', esc_attr( $field->value['target'] ) ); ?>>None</option>
                    <option value="_blank" <?php selected( '_blank', esc_attr( $field->value['target'] ) ); ?>>_blank</option>
                    <option value="_self" <?php selected( '_self', esc_attr( $field->value['target'] ) ); ?>>_self</option>
                    <option value="_top" <?php selected( '_top', esc_attr( $field->value['target'] ) ); ?>>_top</option>
                </select>
            </div>
        </div>
    <?php
    }


    function options_html( $key, $field = null ) {
    ?>
        <tr class="field_option field_option_<?php echo jobcircle_esc_the_html($this->name); ?>">
            <td class="label">
                <label><?php _e('Output format', 'jobcircle-frame'); ?></label>
            </td>
            <td>
                <?php
                    JOBCIRCLE_CFS()->create_field( [
                        'type' => 'select',
                        'input_name' => "cstmfield[fields][$key][options][format]",
                        'options' => [
                            'choices' => [
                                'html' => __( 'HTML', 'jobcircle-frame' ),
                                'php' => __( 'PHP Array', 'jobcircle-frame' )
                            ],
                            'force_single' => true,
                        ],
                        'value' => $this->get_option( $field, 'format', 'html' ),
                    ] );
                ?>
            </td>
        </tr>
    <?php
    }


    function pre_save( $value, $field = null ) {
        // convert to a proper associative array when inside a Loop
        if ( isset( $value[0]['url'], $value[1]['text'], $value[2]['target'] ) ) {
            $value = [
                'url'    => $value[0]['url'],
                'text'   => $value[1]['text'],
                'target' => $value[2]['target'],
            ];
        }
        return serialize( $value );
    }


    function prepare_value( $value, $field = null ) {
        return unserialize( $value[0] );
    }


    function format_value_for_api( $value, $field = null ) {
        $url    = isset( $value['url'] ) ? $value['url'] : '';
        $text   = isset( $value['text'] ) ? $value['text'] : $value['url'];
        $target = isset( $value['target'] ) ? $value['target'] : '';
        $format = $this->get_option( $field, 'format', 'html' );
        
        // target="none" (sometimes?) opens a new tab
        if ( 'none' == $target ) {
            $target = '';
        }

        // Return an HTML string
        if ( 'html' == $format ) {
            $output = '';
            if ( ! empty( $url ) ) {
                $output = '<a class="cstmfield-hyperlink" href="' . esc_url( $url ) . '" target="' . $target . '"><span class="text">' . esc_html( $text ) . '</span></a>';
            }
        }

        // Return an associative array
        elseif ( 'php' == $format ) {
            $output = $value;
        }

        return $output;
    }
}
