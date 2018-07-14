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
                    <h2 style="text-align: center;">StatCDR Appointment Scheduler</h2>
                    <h5 style="text-align: center;">{{ $eventDetails->evtName }}, {{ $eventDetails->evtAddr }}.</h5>

                    @if(session('status'))
                        <div class="alert alert-primary alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong>Success !!!</strong> {{ session('status') }}
                        </div>
                    @endif

                    <div class="card-body">
                        {!! Form::open(['url'=>'appointments', 'class'=>'form-0024', 'role'=>'form', 'name'=>'appointmentAddPost']) !!}
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::hidden('evtID', $eventDetails->id, ['id' => 'evtID']) !!}

                                        {!! Html::decode(Form::label('cusName', 'Your name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                        {!! Form::text('cusName', old('cusName'), ['class' => 'form-control', 'placeholder' => 'Your name', 'required' => 'required']) !!}

                                        @if($errors->has('evtID'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('evtID') }}</strong>
                                            </span>
                                        @endif

                                        @if($errors->has('cusName'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cusName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('cusCom', 'Company name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                        {!! Form::text('cusCom', old('cusCom'), ['class' => 'form-control', 'placeholder' => 'Company name', 'required' => 'required']) !!}

                                        @if($errors->has('cusCom'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cusCom') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('cusEmail', 'Your Email <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                        {!! Form::email('cusEmail', old('cusEmail'), ['class' => 'form-control', 'placeholder' => 'Your Email', 'required' => 'required']) !!}

                                        @if($errors->has('cusEmail'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cusEmail') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('cusSkype', 'Your Skype ID <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                        {!! Form::text('cusSkype', old('cusSkype'), ['class' => 'form-control', 'placeholder' => 'Your Skype ID', 'required' => 'required']) !!}

                                        @if($errors->has('cusSkype'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cusSkype') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('cusPhn', 'Your Phone/What\'s App <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                        {!! Form::text('cusPhn', old('cusPhn'), ['class' => 'form-control', 'placeholder' => 'Your Phone/What\'s App', 'required' => 'required']) !!}

                                        @if($errors->has('cusPhn'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cusPhn') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('agentID','Whom you wish to meet <span class="mandatory-field">*</span>',['class' => 'control-label'])) !!}
                                        {!! Form::select('agentID', $agentList, old('agentID'), ['placeholder' => 'Select agent', 'class' => 'form-control custom-select', 'required' => 'required']) !!}

                                        @if($errors->has('agentID'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('agentID') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('slotDate', 'Meeting Date <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}

                                        {!! Form::select('slotDate', $dateList, old('slotDate'), ['placeholder' => 'Select agent first', 'class' => 'form-control custom-select', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('slotID', 'Meeting Time <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}

                                        {!! Form::select('slotID', $dateList, old('slotID'), ['placeholder' => 'Select date first', 'class' => 'form-control custom-select', 'required' => 'required']) !!}

                                        @if($errors->has('slotID'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('slotID') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-actions" style="text-align: center;">
                            {!! Form::submit('Submit for Appointment', ['name' => 'appointmentAddSubmit', 'class' => 'btn btn-success']) !!}
                        </div>

                        @include('guest.apt_script')

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection