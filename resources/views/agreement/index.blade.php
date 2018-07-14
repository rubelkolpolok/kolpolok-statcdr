<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/22/2018
 * Time: 2:54 PM
 */
use App\Http\Controllers\AgmtListController;
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreement List</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Agreement List</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Agreement List</h4>
                            <h6 class="card-subtitle">All Agreement listed in here</h6>

                            @if(session('status'))
                            <div class="alert alert-primary alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong>Success !!!</strong> {{ session('status') }}
                            </div>
                            @endif

                            <div>
                                <a href="{{ url('agreement/all') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Add Agreement</button></a>
                            </div>
                            <div style="margin-top: 10px;">
                                <a href="{{ url('agreements/all') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Add Agreement [This is for Website Viewer]</button></a>
                            </div>
                            <div class="table-responsive m-t-40">
                                <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Type</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th style="text-align: left; width: 240px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $SN = 1;
                                    @endphp
                                    @foreach($allAgmtList as $key => $value)
                                        <tr>
                                            <td class="tdCenter">{{ $SN }}</td>
                                            <td>{{ AgmtListController::agmtTypeName($value->agmtTypeID) }}</td>
                                            <td>{{ $value->created_at }}</td>

                                            @if($value->status == 1)
                                                <td>AGREE</td>
                                            @else
                                                <td>PENDING</td>
                                            @endif

                                            <td class="multipleButton" style="text-align: left;">
                                                <a href="{{ url('agreement/'.$value->id.'/edit') }}">
                                                    <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i> Edit</button>
                                                </a>
                                                <a href="{{ route('askTr',$value->id) }}">
                                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope"></i> Ask TR</button>
                                                </a>
                                                <a href="{{ url('agreement/'.$value->id.'/edit') }}">
                                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope"></i> Send</button>
                                                </a>
                                                <a href="{{ url('agreement/'.$value->id.'/download') }}">
                                                    <button class="btn btn-success btn-xs"><i class="fa fa-download"></i> Download</button>
                                                </a>
                                                <a href="{{ url('agreement/'.$value->id.'/upload') }}">
                                                    <button class="btn btn-info btn-xs"><i class="fa fa-upload"></i> Upload</button>
                                                </a>
                                                {{ Form::open(array('url' => 'agreement/' . $value->id, 'style' => 'display:inline;')) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::button('<i class="fa fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'style' => 'margin:0 5px 5px 0;'] )  }}
                                                {{ Form::close() }}
                                            </td>
                                        </tr>
                                        @php
                                            $SN++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer_note')
    </div>
@endsection