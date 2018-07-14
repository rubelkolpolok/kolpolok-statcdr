<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 6/8/2018
 * Time: 5:21 PM
 */
?>
<!--script>
    $('#agentID').change(function() {
        var eventID = $('#evtID').val();
        var id      = $('#agentID').val();
        if(eventID && id){
            var ajax_url = '{{url('timeSlots')}}'+'/'+eventID+'/'+id;
            $.ajax({
                url: ajax_url,
                type: "GET",
                success: function(data){
                    $('#timeSlotLoad').hide().html(data).fadeIn();
                }
            });
        }
    });
</script-->
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="agentID"]').on('change', function() {
            var eventID = $('#evtID').val();
            var id      = $(this).val();
            if(eventID && id) {
                var ajax_url = '{{url('timeSlotsDate')}}'+'/'+eventID+'/'+id;
                $.ajax({
                    url: ajax_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="slotDate"]').empty();
                        $('select[name="slotID"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="slotDate"]').append('<option value="'+ value['date_slot'] +'">'+ value['date_slot'] +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="slotDate"]').empty();
                $('select[name="slotID"]').empty();
            }
        });

        $('select[name="slotDate"]').on('change', function() {
            var eventID = $('#evtID').val();
            var agentID = $('#agentID').val();
            var dateM   = $(this).val();
            if(eventID && agentID && dateM) {
                var ajax_url = '{{url('timeSlots')}}'+'/'+eventID+'/'+agentID+'/'+dateM;
                $.ajax({
                    url: ajax_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="slotID"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="slotID"]').append('<option value="'+ value['id'] +'">'+ value['time_slot'] +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="slotID"]').empty();
            }
        });
    });
</script>
