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
                <h3 class="text-primary">Datetime Slot Update</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("appointments/timeslot") }}">Datetime Slot List</a></li>
                    <li class="breadcrumb-item active">Datetime Slot Update</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($timeslot, array('route' => array('timeslot.update', $timeslot->id), 'method' => 'PUT', 'class'=>'form-0024', 'role'=>'form', 'name'=>'timeslotUpdatePost')) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtID', 'Select Event <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::select('evtID', $allEvents, null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

                                            @if($errors->has('evtID'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('evtID') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('agentID', 'Select Agent <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}

                                            {!! Form::select('agentID', $allEmployee, null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

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
                                            {!! Html::decode(Form::label('time_slot', 'Time Slots <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('time_slot', null, ['class' => 'form-control', 'id' => 'dateTimePicker', 'placeholder' => 'Time Slots', 'required' => 'required']) !!}

                                            @if($errors->has('time_slot'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('time_slot') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('slot_duration', 'Appointments Duration (In minutes) <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('slot_duration', null, ['class' => 'form-control', 'placeholder' => 'Appointments Duration', 'required' => 'required']) !!}

                                            @if($errors->has('slot_duration'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('slot_duration') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Update', ['name' => 'timeslotUpdateSubmit', 'class' => 'btn btn-success']) !!}
                            </div>
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