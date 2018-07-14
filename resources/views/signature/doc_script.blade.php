<script>
    $(document).ready(function () {
        $('#upload_doc').change(function () {
            var file = this.files[0];
            var real_file = file.name;
            var file_type = real_file.split('.').pop().toLowerCase();
            var arr = ['pdf'];
            if (file === '' || $.inArray(file_type, arr) === -1) {
                alert('Only PDF allowed');
                return false;
            }

            var form_data = new FormData();
            form_data.append('upload_doc', file);
            form_data.append('_token', '{{csrf_token()}}');
            
            $.ajax({
                url: '{{ url('document/upload') }}',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                beforeSend: function () {
                    $('#upload').append('<img id="loading" src="{{asset('images/loading_h.gif')}}" alt="Logo">');
                },
                success: function (response) {
                    console.log(response);
                    document.getElementById('upload_doc').value = '';
                    $('#loading').remove();
                    location.reload();
                }
            });
        });

    });
   
</script>