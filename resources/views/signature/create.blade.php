<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/19/2018
 * Time: 4:22 PM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Signature Add</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("signature") }}">Signature List</a></li>
                    <li class="breadcrumb-item active">Signature Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url'=>'signature', 'class'=>'form-0024', 'role'=>'form', 'name'=>'signatureAddPost', 'enctype'=>'multipart/form-data']) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('sigTitle', 'Signature Title <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('sigTitle', old('sigTitle'), ['class' => 'form-control', 'placeholder' => 'Signature Title', 'required' => 'required']) !!}

                                            @if($errors->has('sigTitle'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('sigTitle') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('sigFile', 'Browse Signature File <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::file('sigFile', ['required' => 'required']) !!}
                                            <small class="form-control-feedback"> Only .png formats are allowed. </small>

                                            @if($errors->has('sigFile'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('sigFile') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Submit', ['name' => 'signatureAddSubmit', 'class' => 'btn btn-success']) !!}
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