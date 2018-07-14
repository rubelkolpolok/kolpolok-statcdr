<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
    $("#signature_section").draggable();
    $("#image").resizable();
});
</script>
<script>
    $(document).ready(function () {
        $('#signature').change(function () {
            var signature_id = $(this).val();

            $.ajax({
                url: '{{ url('document/get_signature') }}',
                type: 'POST',
                cache: false,
                data: {
                    signature_id:signature_id,
                    _token : '{{csrf_token()}}'
                },
                beforeSend: function () {
                    $('#signature_section').html('<img width="50px;" id="loading" src="{{asset('images/loading_h.gif')}}" alt="Logo">');
                },
                success: function (response) {
                    //console.log(response);
                    $('#loading').remove();
                    $('#image').attr('src', '{{ asset("storage/signatures" )}}/' + response.name);
                    
                }
            });
        });

    });
   
</script>