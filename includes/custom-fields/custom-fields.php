<?php

class Custom_Field_Suite
{

    public $api;
    public $form;
    public $fields;
    public $field_group;
    private static $instance;


    function __construct() {

        // setup variables
        define( 'JOBCIRCLE_CFS_VERSION', '2.7' );
        define( 'JOBCIRCLE_CFS_DIR', dirname( __FILE__ ) );
        define( 'JOBCIRCLE_CFS_URL', plugins_url( '', __FILE__ ) );

        // get the gears turning
        include( JOBCIRCLE_CFS_DIR . '/includes/init.php' );
    }


    /**
     * Singleton
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * Public API methods
     */
    function get( $field_name = false, $post_id = false, $options = [] ) {
        return JOBCIRCLE_CFS()->api->get( $field_name, $post_id, $options );
    }


    function get_field_info( $field_name = false, $post_id = false ) {
        return JOBCIRCLE_CFS()->api->get_field_info( $field_name, $post_id );
    }


    function get_reverse_related( $post_id, $options = [] ) {
        return JOBCIRCLE_CFS()->api->get_reverse_related( $post_id, $options );
    }


    function save( $field_data = [], $post_data = [], $options = [] ) {
        return JOBCIRCLE_CFS()->api->save_fields( $field_data, $post_data, $options );
    }


    function find_fields( $params = [] ) {
        return JOBCIRCLE_CFS()->api->find_input_fields( $params );
    }


    function form( $params = [] ) {
        ob_start();
        JOBCIRCLE_CFS()->form->render( $params );
        return ob_get_clean();
    }


    /**
     * Render a field's admin settings HTML
     */
    function field_html( $field ) {
        include( JOBCIRCLE_CFS_DIR . '/templates/field_html.php' );
    }


    /**
     * Trigger the field type "html" method
     */
    function create_field( $field ) {
        $defaults = [
            'type'          => 'text',
            'input_name'    => '',
            'input_class'   => '',
            'options'       => [],
            'value'         => '',
        ];

        $field = (object) array_merge( $defaults, (array) $field );
        JOBCIRCLE_CFS()->fields[ $field->type ]->html( $field );
    }
}


function JOBCIRCLE_CFS() {
    return Custom_Field_Suite::instance();
}


$cstmfield = JOBCIRCLE_CFS();
