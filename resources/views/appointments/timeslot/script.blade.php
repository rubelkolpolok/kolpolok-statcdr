<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/15/2018
 * Time: 3:02 PM
 */
?>
<link href="{{ asset('js/lib/jquery/jquery.datetimepicker.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/lib/jquery/jquery.datetimepicker.full.min.js') }}"></script>
<script>
    jQuery('#dateTimePicker').datetimepicker({
        format:'Y-m-d H:i'
    });
</script>
