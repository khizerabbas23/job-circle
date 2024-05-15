<?php

class cstmfield_tab extends cstmfield_field
{

    function __construct() {
        $this->name = 'tab';
        $this->label = __( 'Tab', 'jobcircle-frame' );
    }


    // Prevent tabs from inheriting the parent field HTML
    function html( $field ) {

    }


    // Prevent tabs from inheriting the parent options HTML
    function options_html( $key, $field ) {

    }


    // Tab handling javascript
    function input_head( $field = null ) {
    ?>
        <script>
        (function($) {
            $(document).on('click', '.cstmfield-tab', function() {
                var tab = $(this).attr('rel'),
                    $context = $(this).parents('.cstmfield_input');
                $context.find('.cstmfield-tab').removeClass('active');
                $context.find('.cstmfield-tab-content').removeClass('active');
                $(this).addClass('active');
                $context.find('.cstmfield-tab-content-' + tab).addClass('active');
            });

            $(function() {
                $('.cstmfield-tabs').each(function(){
                    $(this).find('.cstmfield-tab:first').click();
                });
            });
        })(jQuery);
        </script>
    <?php
    }
}
