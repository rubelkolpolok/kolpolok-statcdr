<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/19/2018
 * Time: 3:03 PM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Appointment Update</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("appointments/list") }}">Appointment List</a></li>
                    <li class="breadcrumb-item active">Appointment Update</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($appointment, array('route' => array('appointment.update', $appointment->id), 'method' => 'PUT', 'class'=>'form-0024', 'role'=>'form', 'name'=>'appointmentUpdatePost')) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::hidden('evtID', $appointment->evtID, ['id' => 'evtID']) !!}

                                            {!! Html::decode(Form::label('cusName', 'Your name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('cusName', null, ['class' => 'form-control', 'placeholder' => 'Your name', 'required' => 'required']) !!}

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
                                            {!! Form::text('cusCom', null, ['class' => 'form-control', 'placeholder' => 'Company name', 'required' => 'required']) !!}

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
                                            {!! Form::email('cusEmail', null, ['class' => 'form-control', 'placeholder' => 'Your Email', 'required' => 'required']) !!}

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
                                            {!! Form::text('cusSkype', null, ['class' => 'form-control', 'placeholder' => 'Your Skype ID', 'required' => 'required']) !!}

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
                                            {!! Form::text('cusPhn', null, ['class' => 'form-control', 'placeholder' => 'Your Phone/What\'s App', 'required' => 'required']) !!}

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
                                            {!! Form::select('agentID', $agentList, null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

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

                                            {!! Form::select('slotDate', $dateList, null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('slotID', 'Meeting Time <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::select('slotID', $timeList, null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

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
                            <div class="form-actions">
                                {!! Form::submit('Update', ['name' => 'appointmentUpdateSubmit', 'class' => 'btn btn-success']) !!}
                            </div>

                            @include('guest.apt_script')

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
            @include('appointments.timeslot.script')
        @endsection

        @include('layouts.footer_note')
    </div>
@endsection