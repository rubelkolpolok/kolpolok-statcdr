<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/15/2018
 * Time: 3:02 PM
 */
?>
<script src="{{ asset('js/lib/SheetJS/shim.js') }}"></script>
<script src="{{ asset('js/lib/SheetJS/xlsx.full.min.js') }}"></script>
<script>

    function browseTextChange() {
        var selectVal = $("#disputeType :selected").val();
        if(selectVal == 1){
            $("#placeABrowse").text("Customer");
            $("#placeBBrowse").text("Supplier");

        }else if(selectVal == 2){
            $("#placeABrowse").text("Supplier");
            $("#placeBBrowse").text("Customer");

        }else{
            $("#placeABrowse").text("");
            $("#placeBBrowse").text("");
        }
    }

    var X = XLSX;
    var process_wb = (function() {
        return function process_wb(wb, outputDiv) {
            /* get data */
            var ws = wb.Sheets[wb.SheetNames[0]];
            var data = XLSX.utils.sheet_to_json(ws, {header:1});

            var HTMLOUT = document.getElementById(outputDiv);
            var tbl = document.createElement("table");
            var tblBody = document.createElement("tbody");
            for (var i = 0; i < data.length; i++) {
                var rowS = document.createElement("tr");
                var row = document.createElement("tr");
                for (var j = 0; j < data[i].length; j++) {

                    // Create Select & DIV Element - Start
                    if(i == 0){
                        var cellS = document.createElement("td");

                        var selectID = null;
                        var divID = null;
                        var ideXL = null;
                        if(outputDiv == 'fileNoBHtmlOut'){
                            ideXL    = 'Bee';
                        }else{
                            ideXL    = 'Aaa';
                        }

                        // Create Select - Start
                        var selectValue = ["--Select--","Datetime","ANI(Caller_number)","Called Number","Duration","Call Rate","Call Cost"];
                        var cellSelect = document.createElement("select");
                        cellSelect.id = "selectID"+ideXL+(j+1);
                        cellSelect.setAttribute("class", "xlLoadSelect");
                        cellSelect.setAttribute("onchange", "xlFieldLoad('"+ideXL+"',"+(j+1)+",this.selectedIndex);");
                        for (var k = 0; k < selectValue.length; k++) {
                            var selectOption = document.createElement("option");
                            selectOption.value = k;
                            selectOption.text = selectValue[k];
                            cellSelect.appendChild(selectOption);
                        }
                        // Create Select - End

                        // Create DIV - Start
                        var cellSelectDiv = document.createElement("div");
                        cellSelectDiv.id = "divID"+ideXL+(j+1);
                        // Create DIV - End

                        cellS.appendChild(cellSelect);
                        cellS.appendChild(cellSelectDiv);
                        rowS.appendChild(cellS);
                        tblBody.appendChild(rowS);
                    }
                    // Create Select & DIV Element - End


                    var cell = document.createElement("td");
                    var cellText = document.createTextNode(data[i][j]);
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                }
                tblBody.appendChild(row);
                if (i === 10) { break; }
            }
            tbl.appendChild(tblBody);
            HTMLOUT.innerHTML = "";
            HTMLOUT.appendChild (tbl);
        };
    })();

    var do_file = (function() {
        var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;

        return function do_file(files, outputDiv) {
            rABS = true;
            var f = files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                if(typeof console !== 'undefined') console.log("onload", new Date(), rABS);
                var data = e.target.result;
                if(!rABS) data = new Uint8Array(data);
                process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}), outputDiv);
            };
            if(rABS) reader.readAsBinaryString(f);
            else reader.readAsArrayBuffer(f);
        };
    })();

    (function() {
        var xlf = document.getElementById('fileNoA');
        if(!xlf.addEventListener) return;
        function handleFile(e) { do_file(e.target.files, 'fileNoAHtmlOut'); }
        xlf.addEventListener('change', handleFile, false);
    })();

    (function() {
        var xlf2 = document.getElementById('fileNoB');
        if(!xlf2.addEventListener) return;
        function handleFile2(e) { do_file(e.target.files, 'fileNoBHtmlOut'); }
        xlf2.addEventListener('change', handleFile2, false);
    })();

    var xlGlobalAaa = [];
    var xlGlobalBee = [];
    function xlFieldLoad(selector, ID, value) {
        var selectID    = "selectID"+selector+ID;
        var divID       = "divID"+selector+ID;
        var globalArray = null;
        if(selector == 'Aaa'){
            globalArray = xlGlobalAaa;
        }else{
            globalArray = xlGlobalBee;
        }
        var divValue = null;
        if(value == 1){
            divValue = '<input type="hidden" name="col1'+selector+'" value="'+ID+'">'+
                '<select style="margin-top:5px;" class="xlLoadSelect" name="col11'+selector+'">'+
                '<option value="Etc/GMT+12">(GMT-12:00) International Date Line West</option>'+
                '<option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>'+
                '<option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>'+
                '<option value="US/Alaska">(GMT-09:00) Alaska</option>'+
                '<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>'+
                '<option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California</option>'+
                '<option value="US/Arizona">(GMT-07:00) Arizona</option>'+
                '<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>'+
                '<option value="US/Mountain">(GMT-07:00) Mountain Time (US & Canada)</option>'+
                '<option value="America/Managua">(GMT-06:00) Central America</option>'+
                '<option value="US/Central">(GMT-06:00) Central Time (US & Canada)</option>'+
                '<option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>'+
                '<option value="Canada/Saskatchewan">(GMT-06:00) Saskatchewan</option>'+
                '<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>'+
                '<option value="US/Eastern">(GMT-05:00) Eastern Time (US & Canada)</option>'+
                '<option value="US/East-Indiana">(GMT-05:00) Indiana (East)</option>'+
                '<option value="Canada/Atlantic">(GMT-04:00) Atlantic Time (Canada)</option>'+
                '<option value="America/Caracas">(GMT-04:00) Caracas, La Paz</option>'+
                '<option value="America/Manaus">(GMT-04:00) Manaus</option>'+
                '<option value="America/Santiago">(GMT-04:00) Santiago</option>'+
                '<option value="Canada/Newfoundland">(GMT-03:30) Newfoundland</option>'+
                '<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>'+
                '<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires, Georgetown</option>'+
                '<option value="America/Godthab">(GMT-03:00) Greenland</option>'+
                '<option value="America/Montevideo">(GMT-03:00) Montevideo</option>'+
                '<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>'+
                '<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>'+
                '<option value="Atlantic/Azores">(GMT-01:00) Azores</option>'+
                '<option value="Africa/Casablanca">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>'+
                '<option value="Etc/Greenwich" selected>(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>'+
                '<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>'+
                '<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>'+
                '<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>'+
                '<option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>'+
                '<option value="Africa/Lagos">(GMT+01:00) West Central Africa</option>'+
                '<option value="Asia/Amman">(GMT+02:00) Amman</option>'+
                '<option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>'+
                '<option value="Asia/Beirut">(GMT+02:00) Beirut</option>'+
                '<option value="Africa/Cairo">(GMT+02:00) Cairo</option>'+
                '<option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>'+
                '<option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>'+
                '<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>'+
                '<option value="Europe/Minsk">(GMT+02:00) Minsk</option>'+
                '<option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>'+
                '<option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>'+
                '<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>'+
                '<option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>'+
                '<option value="Asia/Tbilisi">(GMT+03:00) Tbilisi</option>'+
                '<option value="Asia/Tehran">(GMT+03:30) Tehran</option>'+
                '<option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>'+
                '<option value="Asia/Baku">(GMT+04:00) Baku</option>'+
                '<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>'+
                '<option value="Asia/Kabul">(GMT+04:30) Kabul</option>'+
                '<option value="Asia/Yekaterinburg">(GMT+05:00) Yekaterinburg</option>'+
                '<option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi, Tashkent</option>'+
                '<option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>'+
                '<option value="Asia/Calcutta">(GMT+05:30) Sri Jayawardenapura</option>'+
                '<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>'+
                '<option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>'+
                '<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>'+
                '<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>'+
                '<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>'+
                '<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>'+
                '<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>'+
                '<option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur, Singapore</option>'+
                '<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>'+
                '<option value="Australia/Perth">(GMT+08:00) Perth</option>'+
                '<option value="Asia/Taipei">(GMT+08:00) Taipei</option>'+
                '<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>'+
                '<option value="Asia/Seoul">(GMT+09:00) Seoul</option>'+
                '<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>'+
                '<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>'+
                '<option value="Australia/Darwin">(GMT+09:30) Darwin</option>'+
                '<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>'+
                '<option value="Australia/Canberra">(GMT+10:00) Canberra, Melbourne, Sydney</option>'+
                '<option value="Australia/Hobart">(GMT+10:00) Hobart</option>'+
                '<option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>'+
                '<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>'+
                '<option value="Asia/Magadan">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>'+
                '<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>'+
                '<option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>'+
                '<option value="Pacific/Tongatapu">(GMT+13:00) Nuku\'alofa</option></select>';

        }else if(value == 2){
            divValue = '<input type="hidden" name="col2'+selector+'" value="'+ID+'">';

        }else if(value == 3){
            divValue = '<input type="hidden" name="col3'+selector+'" value="'+ID+'">'+
                '<input type="text" class="xlInput" name="col33'+selector+'" placeholder="Prefix">';

        }else if(value == 4){
            divValue = '<input type="hidden" name="col4'+selector+'" value="'+ID+'">'+
                '<select style="margin-top:5px;" class="xlLoadSelect" name="col44'+selector+'">'+
                '<option value="1">Second</option>'+
                '<option value="2">Minute</option></select>';

        }else if(value == 5){
            divValue = '<input type="hidden" name="col5'+selector+'" value="'+ID+'">';

        }else if(value == 6){
            divValue = '<input type="hidden" name="col6'+selector+'" value="'+ID+'">';
        }
        document.getElementById(divID).innerHTML = divValue;
    }
</script>
