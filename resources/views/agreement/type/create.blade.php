<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/18/2018
 * Time: 11:26 AM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreements Type Add</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("agreement/type") }}">Agreements Types</a></li>
                    <li class="breadcrumb-item active">Agreements Type Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url'=>'agreement/type', 'class'=>'form-0024', 'role'=>'form', 'name'=>'agmtTypeAddPost']) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('typeName', 'Agreements Type Name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('typeName', old('typeName'), ['class' => 'form-control', 'placeholder' => 'Agreements Type Name', 'required' => 'required']) !!}

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
                                                ], old('adminApprove'), ['class' => 'form-control custom-select', 'required' => 'required']) !!}

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
                                            {!! Form::textarea('pdfDetails', old('pdfDetails')) !!}

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
                                            {!! Form::text('showOrder', old('showOrder'), ['class' => 'form-control', 'placeholder' => 'Showing Order in Website', 'required' => 'required']) !!}

                                            @if($errors->has('showOrder'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('showOrder') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="dynamicFieldTable">
                                            <div class="form-group">
                                                <label class="control-label">Add Agreements Dynamic Field Here</label>
                                            </div>
                                            <table id="dynamicField">
                                                <tr>
                                                    <td style="padding: 0;">
                                                        <input type="hidden" name="columnName[]" value="">
                                                        <input type="hidden" name="placeHolder[]" value="">
                                                        <input type="hidden" name="columnType[]" value="">
                                                        <input type="hidden" name="mustFill[]" value="">
                                                    </td>
                                                </tr>
                                            </table>
                                            <a class="agmtFieldCut">
                                                <i class="fa fa-minus-square"></i>
                                            </a>
                                            <a class="agmtFieldAdd">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Submit', ['name' => 'agmtTypeAddSubmit', 'class' => 'btn btn-success']) !!}
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