<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/15/2018
 * Time: 3:02 PM
 */
?>
<script src="{{ asset('js/lib/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        height: 300,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools jbimages"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        relative_urls: false,
        remove_script_host : false,
        convert_urls : true,
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });

    $(function () {
        var column_length = $("#dynamicField tr").length;
        ClassShowHide(column_length,'.agmtFieldCut',1);

        $('.agmtFieldAdd').click(function() {
            $('#dynamicField tr:last-child').after(
                '<tr>'+
                    '<td style="padding: 0;">'+
                        '<hr style="margin-bottom: 30px;">'+
                        '<div class="row">'+
                            '<div class="col-md-6">'+
                                '<div class="form-group">'+
                                    '<label class="control-label">No '+column_length+' Column Name<span class="mandatory-field">*</span></label>'+
                                    '<input type="text" class="form-control" name="columnName[]" placeholder="No '+column_length+' Column Name" required>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label class="control-label">No '+column_length+' Placeholder Name </label>'+
                                    '<input type="text" class="form-control" name="placeHolder[]" placeholder="No '+column_length+' Placeholder Name">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-6">'+
                                '<div class="form-group">'+
                                    '<label class="control-label">Column '+column_length+' Type</label>'+
                                    '<select name="columnType[]" class="form-control custom-select" title="Column '+column_length+' Type">'+
                                        '<option value="1" selected >Text</option>'+
                                        '<option value="2">Date</option>'+
                                        '<option value="3">Email</option>'+
                                        '<option value="4">Number</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label style="margin-top: 10px;" class="control-label">Column '+column_length+' : Mandatory ?</label>'+
                                    '<select name="mustFill[]" class="form-control custom-select" title="Column '+column_length+' : Mandatory ?">'+
                                        '<option value="1">Yes</option>'+
                                        '<option value="0" selected >No</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</td>'+
                '</tr>');
            column_length++;
            ClassShowHide(column_length,'.agmtFieldCut',1);
        });

        $('.agmtFieldCut').click(function() {
            $('#dynamicField tr:last-child').remove();
            column_length--;
            ClassShowHide(column_length,'.agmtFieldCut',1);
        });

        function ClassShowHide(Myvalue,className,conditionalValue){
            if(Myvalue == conditionalValue){
                $(className).css( "display", "none" );
            }else{
                $(className).css( "display", "inline-block" );
            }
        }
    });
</script>
