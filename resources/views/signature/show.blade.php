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
                <h3 class="text-primary">Document Details</h3></div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("documents") }}">Document List</a></li>
                    <li class="breadcrumb-item active">Document Details</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <div class="card" style="height:500px">
                        <embed src="{{ URL::asset($document->docName) }}#toolbar=0" width="100%" height="100%"/>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <select id="signature" name="signature" class="form-control">
                            <option value="0">Select Signature</option>
                            @foreach($signatures as $key => $value)
                                <option value="{{$value->id}}">{{$value->sigTitle}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card" id="signature_section" style="display:inline-block;">
                        <img id="image" width="100px;" src="" alt="signature"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('signature.sig_script')
@endsection
@include('layouts.footer_note')
