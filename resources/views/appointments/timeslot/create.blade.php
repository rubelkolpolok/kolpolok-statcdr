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
                <h3 class="text-primary">Datetime Slot Add</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("appointments/timeslot") }}">Datetime Slot List</a></li>
                    <li class="breadcrumb-item active">Datetime Slot Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url'=>'appointments/timeslot', 'class'=>'form-0024', 'role'=>'form', 'name'=>'timeslotAddPost']) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtID', 'Select Event <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::select('evtID', $allEvents, old('evtID'), ['class' => 'form-control custom-select', 'required' => 'required']) !!}

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

                                            {!! Form::select('agentID', $allEmployee, old('agentID'), ['class' => 'form-control custom-select', 'required' => 'required']) !!}

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
                                            {!! Html::decode(Form::label('time_slot', 'Time slots starting date & time <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('time_slot', old('time_slot'), ['class' => 'form-control', 'id' => 'dateTimePicker', 'placeholder' => 'Time slots starting date & time', 'required' => 'required']) !!}

                                            @if($errors->has('time_slot'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('time_slot') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('time_slot_no', 'Number of Time Slots', ['class' => 'control-label'])) !!}
                                            {!! Form::number('time_slot_no', 1, ['class' => 'form-control', 'placeholder' => 'Number of Time Slots']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('slot_duration', 'Appointments Duration (In minutes) <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('slot_duration', old('slot_duration'), ['class' => 'form-control', 'placeholder' => 'Appointments Duration', 'required' => 'required']) !!}

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
                                {!! Form::submit('Submit', ['name' => 'timeslotAddSubmit', 'class' => 'btn btn-success']) !!}
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