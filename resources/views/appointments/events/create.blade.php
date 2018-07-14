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
                <h3 class="text-primary">Event Add</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("appointments/events") }}">Event List</a></li>
                    <li class="breadcrumb-item active">Event Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url'=>'appointments/events', 'class'=>'form-0024', 'role'=>'form', 'name'=>'eventAddPost']) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtName', 'Event Name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('evtName', old('evtName'), ['class' => 'form-control', 'placeholder' => 'Event Name', 'required' => 'required']) !!}

                                            @if($errors->has('evtName'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('evtName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtAddr', 'Event Address <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('evtAddr', old('evtAddr'), ['class' => 'form-control', 'placeholder' => 'Event Address', 'required' => 'required']) !!}

                                            @if($errors->has('evtAddr'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('evtAddr') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtStart', 'Starting Date <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::date('evtStart', old('evtStart'), ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required' => 'required']) !!}

                                            @if($errors->has('evtStart'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('evtStart') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtEnd', 'Ending Date <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::date('evtEnd', old('evtEnd'), ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required' => 'required']) !!}

                                            @if($errors->has('evtEnd'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('evtEnd') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtShowWeb', 'Showing in Website Date <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::date('evtShowWeb', old('evtShowWeb'), ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required' => 'required']) !!}

                                            @if($errors->has('evtShowWeb'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('evtShowWeb') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Submit', ['name' => 'eventAddSubmit', 'class' => 'btn btn-success']) !!}
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