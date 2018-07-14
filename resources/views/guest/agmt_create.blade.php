<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/19/2018
 * Time: 10:35 AM
 */
?>
@extends('guest.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h2 style="text-align: center;">StatCDR Agreement : {{ $agmt_type[0]['typeName'] }}</h2>
                    <h5 style="text-align: center;">Important Details.</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ url('agreements') }}" accept-charset="UTF-8" class="form-0024" role="form" name="agreementAddPost">
                            @csrf
                            <div class="form-body">
                                <div class="row p-t-20">

                                    <input type="hidden" name="agmtTypeID" value="{{ $agmtTypeID }}">
                                    <input type="hidden" name="agmtStatus" value="{{ $agmt_type[0]['adminApprove'] }}">

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
                                                <input type="{{ $fieldType }}" name="columnValue[]" placeholder="{{ $value['columnName'] }}" {!! $required !!} class="form-control">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                <input name="agreementAddSubmit" class="btn btn-success" type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection