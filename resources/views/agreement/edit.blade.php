<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/22/2018
 * Time: 4:21 PM
 */
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
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 10px;
    }



</style>

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreement Details</h3></div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('agreement/list') }}">Agreement List</a></li>
                    <li class="breadcrumb-item active">Agreement Details</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($agmt_list, array('route' => array('agreement.update', $agmt_list->id), 'method' => 'PUT', 'class'=>'form-0024', 'role'=>'form', 'name'=>'agmtListUpdatePost')) !!}
                            <div class="form-body">
                                @if($agmt_list->status == 0)
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('status', 'Accept this Agreement <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::select('status', [
                                                    '1' => 'Yes',
                                                    '0' => 'No'
                                                    ], null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

                                                @if($errors->has('status'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('status') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @else
                                    <input type="hidden" name="status" value="1">
                                @endif

                                <div class="row">
                                    @foreach($agmt_list_type as $key => $value)
                                        @php
                                            if($value->columnType == 2){
                                                $fieldType = 'date';

                                            }elseif($value->columnType == 3){
                                                $fieldType = 'email';

                                            }elseif($value->columnType == 4){
                                                $fieldType = 'number';

                                            }else{
                                                $fieldType = 'text';
                                            }

                                            if($value->mustFill == 1){
                                                $mustFill = '<span class="mandatory-field">*</span>';
                                                $required = 'required="required"';
                                            }else{
                                                $mustFill = '';
                                                $required = '';
                                            }
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="hidden" name="columnID[]" value="{{ $value->id }}">
                                                <label class="control-label">{{ $value->columnName }} {!! $mustFill !!}</label>
                                                <input type="{{ $fieldType }}" name="columnValue[]"
                                                       placeholder="{{ $value->columnName }}"
                                                       value="{{ $value->columnValue }}"
                                                       {!! $required !!} class="form-control">
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-md-12" style="margin-bottom: 10px;">
                                        <input id="button" type="button" onclick="trade()" class="btn btn-success"
                                               value="Trade Reference(Optional)">
                                    </div>

                                    <div class="col-md-12 input_fields_wrap" id="company">
                                        @if(isset($agmt_list->references) && $agmt_list->references->count() > 0)
                                            @foreach($agmt_list->references as $reference)
                                                <div class='col-md-4 fields__wrap-1'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Name <span class='mandatory-field'>*</span></label>
                                                        <input type='text' name='ref_name[]'
                                                               placeholder='reference name' value="{{$reference->name}}"
                                                               class='form-control'>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Company Name <span
                                                                    class='mandatory-field'>*</span></label>
                                                        <input type='text' name='ref_company[]'
                                                               placeholder='reference company name'
                                                               value="{{$reference->company}}" class='form-control'>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Designation<span
                                                                    class='mandatory-field'>*</span></label>
                                                        <input type='text' name='ref_designation[]'
                                                               placeholder='job title'
                                                               value="{{$reference->designation}}" class='form-control'>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Phone<span class='mandatory-field'>*</span></label>
                                                        <input type='text' name='ref_phone[]'
                                                               placeholder='reference phone number'
                                                               value="{{$reference->phone}}" class='form-control'>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Email <span
                                                                    class='mandatory-field'>*</span></label>
                                                        <input type='email' name='ref_email[]'
                                                               placeholder='Reference company email'
                                                               value="{{$reference->email}}" class='form-control'>
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif
                                    </div>

                                </div>

                            </div>
                            <div class="form-actions">
                                {!! Form::submit('Update', ['name' => 'agmtListUpdateSubmit', 'class' => 'btn btn-success']) !!}
                            </div>
                            {!! Form::close() !!}
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

            console.log('hello');

            var txt1 = "<div class='col-md-4 fields__wrap-1 remove" + add + "' id='trade_div_" + add + "' >";


            txt1 += "<div class='form-group'>";
            txt1 += "<label class='control-label'>Name <span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_name[]' placeholder='reference name' class='form-control'>";
            txt1 += "</div>";


            txt1 += "<div class=form-group'>";
            txt1 += "<label class='control-label'>Company Name <span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_company[]' placeholder='reference company name' class='form-control'>";
            txt1 += "</div>";


            txt1 += "<div class=form-group'>";
            txt1 += "<label class='control-label'>Designation<span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_designation[]' placeholder='job title' class='form-control'>";
            txt1 += "</div>";
            txt1 += "<div class=form-group'>";
            txt1 += "<label class='control-label'>Phone<span class='mandatory-field'>*</span></label>";
            txt1 += "<input type='text' name='ref_phone[]' placeholder='reference phone number' class='form-control'>";
            txt1 += "</div>";
            txt1 += "<div class=form-group'>";
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