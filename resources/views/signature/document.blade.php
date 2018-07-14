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
            <h3 class="text-primary">Documents</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Document List</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Document List</h4>
                        <h6 class="card-subtitle">All document listed in here</h6>

                        @if(session('status'))
                        <div class="alert alert-primary alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong>Success !!!</strong> {{ session('status') }}
                        </div>
                        @endif

                        <div class="row">
                            <div id="upload"  class="col-3">
                                {{ Form::open(array('url' => 'signature', 'class' => '','files' => true)) }}
                                {{ Form::file('upload_doc',['id' => 'upload_doc','class' => 'btn btn-xs btn-success']) }}
                                {{ Form::close() }}
                            </div>


                        </div>
                        <div class="table-responsive m-t-40">
                            <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Document Title</th>
                                        <th class="tdCenter">File</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $SN = 1;
                                    @endphp
                                    @foreach($allDocument as $key => $value)
                                    <tr>
                                        <td class="tdCenter">{{ $SN }}</td>
                                        <td>{{ $value->title }}</td>
                                        <td class="tdCenter"><a href="{{ url('/document/'.$value->id.'/show') }}">{{ $value->title }}</a></td>
                                        
                                        <td class="tdCenter">
                                            <a href="{{ url('document/'.$value->id.'/delete') }}"><button class="btn btn-danger btn-xs">Delete</button></a>
                                        </td>
                                    </tr>
                                    @php
                                    $SN++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{$allDocument->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
    @include('signature.doc_script')
    @endsection
    @include('layouts.footer_note')
</div>
@endsection
