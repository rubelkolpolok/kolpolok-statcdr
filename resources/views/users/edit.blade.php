<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/29/2018
 * Time: 3:02 PM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">User Edit</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("users") }}">Users List</a></li>
                    <li class="breadcrumb-item active">User Edit</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT', 'class'=>'form-0024', 'role'=>'form', 'name'=>'userUpdatePost', 'enctype'=>'multipart/form-data')) !!}
                            <div class="form-body">
                                <div class="row p-t-20">

                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    @if($userType)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('userType', 'Select User Type <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::select('userType', $userType, null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

                                                @if($errors->has('userType'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('userType') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="userType" value="0">
                                    @endif

                                    @if($userPlan)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('userPlan', 'Select User Plan <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::select('userPlan', $userPlan, null, ['class' => 'form-control custom-select', 'required' => 'required']) !!}

                                                @if($errors->has('userPlan'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('userPlan') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="userPlan" value="0">
                                    @endif

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('name', 'Full Name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Full Name', 'required' => 'required']) !!}

                                            @if($errors->has('name'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('email', 'User Email <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'User Email', 'required' => 'required', 'autocomplete' => 'off']) !!}

                                            @if($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                {!! Form::submit('Update', ['name' => 'userUpdateSubmit', 'class' => 'btn btn-success']) !!}
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