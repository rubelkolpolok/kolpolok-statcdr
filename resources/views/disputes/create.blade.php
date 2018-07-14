<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/14/2018
 * Time: 5:26 PM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dispute Add</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Dispute Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url'=>'dispute', 'class'=>'form-0024', 'role'=>'form', 'name'=>'xlLoadPost', 'enctype'=>'multipart/form-data']) !!}
                                <div class="form-body">
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('disputeType', 'Dispute Type <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}

                                                {!! Form::select('disputeType', [
                                                    '' => '--Select Dispute Type--',
                                                    '1' => 'Customer',
                                                    '2' => 'Supplier'
                                                    ], null,['class' => 'form-control custom-select', 'onchange' => 'browseTextChange();', 'required' => 'required']) !!}

                                                @if($errors->has('disputeType'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('disputeType') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('disputeName', 'Dispute Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('disputeName', '', ['class' => 'form-control', 'placeholder' => 'Dispute Name']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('prtName', 'Partner Name <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::text('prtName', '', ['class' => 'form-control', 'placeholder' => 'Partner Name', 'required' => 'required']) !!}

                                                @if($errors->has('prtName'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('prtName') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('fromDate', 'From Date <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::date('fromDate', '', ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required' => 'required']) !!}

                                                @if($errors->has('fromDate'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('fromDate') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('toDate', 'To Date <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::date('toDate', '', ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required' => 'required']) !!}

                                                @if($errors->has('toDate'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('toDate') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('dAmount', 'Amount', ['class' => 'control-label']) !!}
                                                {!! Form::text('dAmount', '', ['class' => 'form-control', 'placeholder' => 'Amount']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('dDue', 'Due Date', ['class' => 'control-label']) !!}
                                                {!! Form::date('dDue', '', ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('fileNoA', 'Browse <span id="placeABrowse"></span> File <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::file('fileNoA', ['id' => 'fileNoA', 'required' => 'required']) !!}
                                                <small class="form-control-feedback"> Only .xlsx, .xls formats are allowed. </small>
                                            </div>
                                            <div id="fileNoAHtmlOut" class="table-Xl-load" style="margin-bottom: 20px;">
                                                File Load in here.
                                            </div>
                                            @if($errors->has('fileNoA'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('fileNoA') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col1Aaa'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col1Aaa') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col11Aaa'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col11Aaa') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col2Aaa'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col2Aaa') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col3Aaa'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col3Aaa') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col4Aaa'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col4Aaa') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col44Aaa'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col44Aaa') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('fileNoB', 'Browse <span id="placeABrowse"></span> File <span class="mandatory-field">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::file('fileNoB', ['id' => 'fileNoB', 'required' => 'required']) !!}
                                                <small class="form-control-feedback"> Only .xlsx, .xls formats are allowed. </small>
                                            </div>
                                            <div id="fileNoBHtmlOut" class="table-Xl-load" style="margin-bottom: 20px;">
                                                File Load in here.
                                            </div>

                                            @if($errors->has('fileNoB'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('fileNoB') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col1Bee'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col1Bee') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col11Bee'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col11Bee') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col2Bee'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col2Bee') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col3Bee'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col3Bee') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col4Bee'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col4Bee') }}</strong>
                                                </span>
                                            @endif

                                            @if($errors->has('col44Bee'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('col44Bee') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-actions">
                                    {!! Form::submit('Submit', ['name' => 'xlLoadSubmit', 'class' => 'btn btn-success']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
            @include('disputes.create_script')
        @endsection

        @include('layouts.footer_note')
    </div>
@endsection