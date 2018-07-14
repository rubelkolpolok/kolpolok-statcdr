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
                <h3 class="text-primary">Create Ticket</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("tickets") }}">Ticket List</a></li>
                    <li class="breadcrumb-item active">Ticket Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url'=>'tickets', 'class'=>'form-0024', 'role'=>'form','name'=>'createTicket']) !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('evtName', 'Support Email <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('supportEmail', old('supportEmail'), ['class' => 'form-control', 'placeholder' => 'Support Email', 'required' => 'required']) !!}

                                            @if($errors->has('supportEmail'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('supportEmail') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('Customer Email', 'Customer Email <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('customerEmail', old('customerEmail'), ['class' => 'form-control', 'placeholder' => 'Customer Email', 'required' => 'required']) !!}

                                            @if($errors->has('customerEmail'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('customerEmail') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('subject', 'Ticket Subject <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('subject', old('subject'), ['class' => 'form-control', 'placeholder' => 'Ticket Subject', 'required' => 'required']) !!}

                                            @if($errors->has('subject'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('subject') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('description', 'Ticket Details <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Description', 'required' => 'required']) !!}

                                            @if($errors->has('description'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Submit', ['name' => 'createTicketSubmit', 'class' => 'btn btn-success']) !!}
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