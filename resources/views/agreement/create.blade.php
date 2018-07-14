<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/22/2018
 * Time: 4:52 PM
 */

use App\Http\Controllers\AgmtListController;

?>
@extends('layouts.app')

<style type="text/css">
    .remove_field {
        text-align: center;
        padding: 15px;
        cursor: pointer;
        color: red;
    }

    .mandatory-field {
        color: red;
        padding: 5px;
    }

    .input_fields_wrap {
        margin-bottom: 15px;
        display: contents;
    }

    .fields__wrap-1 {
        display: inline-table;
        margin-top: 25px;
    }

    .form-group {
        margin-bottom: 10px;
    }

</style>

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreement Add</h3></div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('agreement/list') }}">Agreement List</a></li>
                    <li class="breadcrumb-item active">Agreement Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h2 style="text-align: center;">StatCDR Agreement : {{ $agmt_type[0]['typeName'] }}</h2>
                        <h5 style="text-align: center;">Important Details.</h5>
                        <div class="card-body">
                            <form method="POST" action="{{ url('agreement') }}" accept-charset="UTF-8" class="form-0024"
                                  role="form" name="agreementAddPost">
                                @csrf
                                <div class="form-body">
                                    <div class="row p-t-20">

                                        <input type="hidden" name="agmtTypeID" value="{{ $agmtTypeID }}">
                                        <input type="hidden" name="agmtStatus"
                                               value="{{ $agmt_type[0]['adminApprove'] }}">

                                        @foreach($agmt_type_details as $key => $value)
                                            @php
                                                if($value['columnType'] == 2){
                                                    $fieldType = 'date';

                                                }elseif($value['columnType'] == 3){
                                                    $fieldType = 'email';

                                                }elseif($value['columnType'] == 4){
                                                    $fieldType = 'number';

                                                }else{
                                                    $fieldType = 'text';
                                                }

                                                if($value['mustFill'] == 1){
                                                    $mustFill = '<span class="mandatory-field">*</span>';
                                                    $required = 'required="required"';
                                                }else{
                                                    $mustFill = '';
                                                    $required = '';
                                                }
                                            @endphp
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="columnID[]" value="{{ $value['id'] }}">
                                                    <label class="control-label">{{ $value['columnName'] }} {!! $mustFill !!}</label>
                                                    <input type="{{ $fieldType }}" name="columnValue[]"
                                                           placeholder="{{ $value['columnName'] }}"
                                                           {!! $required !!} class="form-control">
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('signatureID', 'Select Signature <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::select('signatureID', $allSignature, old('signatureID'), ['class' => 'form-control custom-select', 'required' => 'required']) !!}

                                                @if($errors->has('signatureID'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('signatureID') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>



                                        <div class="col-md-12" style="margin-bottom: 10px;">
                                            <input id="button" type="button" onclick="trade()" class="btn btn-success"
                                                   value="Trade Reference(Optional)">
                                        </div>

                                    </div>


                                    <div class="col-md-12 input_fields_wrap" id="company">
                                        <!-- <h3>Treade reference</h3> -->

                                    </div>
                                </div>
                                <hr>
                                <div class="form-actions">
                                    <input name="agreementAddSubmit" class="btn btn-success" type="submit"
                                           value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('layouts.footer_note')
    </div>
@endsection

@push('scripts')
    <script>
        var add = 0;

        function trade() {
            add++;

            var txt1 = "<div class='col-md-4 fields__wrap-1 remove" + add + "' id='trade_div_" + add + "' >";


            txt1 += "<div class='form-group'>";
            txt1 += "<label class='control-label'>Name <span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_name[]' placeholder='reference name' class='form-control'>";
            txt1 += "</div>";


            txt1 += "<div class='form-group'>";
            txt1 += "<label class='control-label'>Company Name <span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_company[]' placeholder='reference company name' class='form-control'>";
            txt1 += "</div>";


            txt1 += "<div class='form-group'>";
            txt1 += "<label class='control-label'>Designation<span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_designation[]' placeholder='job title' class='form-control'>";
            txt1 += "</div>";
            txt1 += "<div class='form-group'>";
            txt1 += "<label class='control-label'>Phone<span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_phone[]' placeholder='reference phone number' class='form-control'>";
            txt1 += "</div>";
            txt1 += "<div class='form-group'>";
            txt1 += "<label class='control-label'>Email <span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='email' name='ref_email[]' placeholder='Reference company email' class='form-control'>";
            txt1 += "</div>";


            txt1 += "<div class='remove_field'>";
            txt1 += "<a class='fa fa-trash' data-toggle='tooltip'  title='Delete' onclick='delete_div(" + add + ")'></a>";
            txt1 += "</div>";


            txt1 += "</div>";


            //alert(txt1);


            $(".input_fields_wrap").append(txt1);

        }

        function delete_div(id) {

            $(".remove" + id).remove();
        }
    </script>
@endpush