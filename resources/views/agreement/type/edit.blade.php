<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/18/2018
 * Time: 11:39 AM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreements Type Update</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("agreement/type") }}">Agreements Types</a></li>
                    <li class="breadcrumb-item active">Agreements Type Update</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($agmt_type, array('route' => array('type.update', $agmt_type->id), 'method' => 'PUT', 'class'=>'form-0024', 'role'=>'form', 'name'=>'agmtTypeUpdatePost')) !!}

                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('typeName', 'Agreements Type Name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('typeName', null, ['class' => 'form-control', 'placeholder' => 'Agreements Type Name', 'required' => 'required']) !!}

                                            @if($errors->has('typeName'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('typeName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('adminApprove', 'Admin Approval <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::select('adminApprove', [
                                                '' => '--Select--',
                                                '1' => 'Yes',
                                                '0' => 'No'
                                                ], null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

                                            @if($errors->has('adminApprove'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('adminApprove') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('pdfDetails', 'Agreements PDF Description(HTML Supported) <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::textarea('pdfDetails', null) !!}

                                            @if($errors->has('pdfDetails'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('pdfDetails') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('showOrder', 'Showing Order in Website <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('showOrder', null, ['class' => 'form-control', 'placeholder' => 'Showing Order in Website', 'required' => 'required']) !!}

                                            @if($errors->has('showOrder'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('showOrder') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="columnID[]" value="">
                                        <input type="hidden" name="columnName[]" value="">
                                        <input type="hidden" name="placeHolder[]" value="">
                                        <input type="hidden" name="columnType[]" value="">
                                        <input type="hidden" name="mustFill[]" value="">
                                        <div class="form-group">
                                            <label class="control-label">Edit Agreements Dynamic Field Here</label>
                                        </div>

                                        @foreach($agmt_type_details as $key => $value)
                                            <hr style="margin-bottom: 30px;">
                                            <div class="row">
                                                <input type="hidden" name="columnID[]" value="{{ $value['id'] }}">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">No {{ ++$key }} Column Name<span class="mandatory-field">*</span></label>
                                                        <input type="text" class="form-control" name="columnName[]" value="{{ $value['columnName'] }}" placeholder="No {{ $key }} Column Name" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">No {{ $key }} Placeholder Name </label>
                                                        <input type="text" class="form-control" name="placeHolder[]" value="{{ $value['placeHolder'] }}" placeholder="No {{ $key }} Placeholder Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Column {{ $key }} Type</label>
                                                        <select name="columnType[]" class="form-control custom-select" title="Column {{ $key }} Type">
                                                            <option value="1" @if($value['columnType'] == '1') selected @endif>Text</option>
                                                            <option value="2" @if($value['columnType'] == '2') selected @endif>Date</option>
                                                            <option value="3" @if($value['columnType'] == '3') selected @endif>Email</option>
                                                            <option value="4" @if($value['columnType'] == '4') selected @endif>Number</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="margin-top: 10px;" class="control-label">Column {{ $key }} : Mandatory ?</label>
                                                        <select name="mustFill[]" class="form-control custom-select" title="Column {{ $key }} : Mandatory ?">
                                                            <option value="1" @if($value['mustFill'] == '1') selected @endif>Yes</option>
                                                            <option value="0" @if($value['mustFill'] == '0') selected @endif>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Update', ['name' => 'agmtTypeUpdateSubmit', 'class' => 'btn btn-success']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
            @include('agreement.type.script')
        @endsection

        @include('layouts.footer_note')
    </div>
@endsection