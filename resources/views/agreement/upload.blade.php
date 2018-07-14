<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 6/22/2018
 * Time: 4:04 PM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreement File Upload</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('agreement/list') }}">Agreement List</a></li>
                    <li class="breadcrumb-item active">Agreement File Upload</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url'=>'agreement/upload/files', 'class'=>'form-0024', 'role'=>'form', 'name'=>'filesAddPost', 'enctype'=>'multipart/form-data']) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <input type="hidden" name="agmtListID" value="{{ $agmtListID }}">

                                            {!! Html::decode(Form::label('uploadFiles', 'Browse File <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::file('uploadFiles', ['required' => 'required']) !!}
                                            <small class="form-control-feedback"> image/*, .pdf, .doc, .docx, .xls, .xlsx, .csv, zip files are allowed. </small>

                                            @if($errors->has('sigFile'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('uploadFiles') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Submit', ['name' => 'filesAddSubmit', 'class' => 'btn btn-success']) !!}
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