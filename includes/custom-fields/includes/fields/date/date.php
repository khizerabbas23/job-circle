<?php

class cstmfield_date extends cstmfield_field
{

    function __construct() {
        $this->name = 'date';
        $this->label = __( 'Date', 'jobcircle-frame' );
    }


    function input_head( $field = null ) {
        $this->load_assets();
    ?>
        <link rel="stylesheet" type="text/css" href="<?php echo JOBCIRCLE_CFS_URL; ?>/includes/fields/date/datepicker.css" />
        <script>
        (function($) {
            $(function() {
                $(document).on('cstmfield/ready', '.cstmfield_add_field', function() {
                    $('.cstmfield_date:not(.ready)').init_date();
                });
                $('.cstmfield_date').init_date();
            });

            $.fn.init_date = function() {
                this.each(function() {
                    //$(this).find('input.date').datetime();
                    $(this).find('input.date').datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoclose: true,
                        clearBtn: true
                    });
                    $(this).addClass('ready');
                });
            };
        })(jQuery);
        </script>
    <?php
    }


    function load_assets() {
        wp_register_script( 'bootstrap-datepicker', JOBCIRCLE_CFS_URL . '/includes/fields/date/bootstrap-datepicker.js', [ 'jquery' ] );
        wp_enqueue_script( 'bootstrap-datepicker' );
    }
}
