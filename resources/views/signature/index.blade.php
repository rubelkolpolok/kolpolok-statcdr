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
            <h3 class="text-primary">Signature List</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Signature List</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Signature List</h4>
                        <h6 class="card-subtitle">All signature listed in here</h6>

                        @if(session('status'))
                        <div class="alert alert-primary alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong>Success !!!</strong> {{ session('status') }}
                        </div>
                        @endif

                        <div class="row">

                            <div class="col-9">
                                <a href="{{ url('signature/create') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Add Signature</button></a>
                            </div>


                        </div>
                        <div class="table-responsive m-t-40">
                            <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Signatures Title</th>
                                        <th class="tdCenter">Files</th>
                                        <th class="tdCenter">Edit</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $SN = 1;
                                    @endphp
                                    @foreach($allSignature as $key => $value)
                                    <tr>
                                        <td class="tdCenter">{{ $SN }}</td>
                                        <td>{{ $value->sigTitle }}</td>
                                        <td class="tdCenter">
                                            <img src="{{ asset('/storage/signatures/'.$value->sigFile)}}" alt="{{$value->sigTitle}}" width="70px;" class="img-thumbnail">
                                        </td>
                                        <td class="tdCenter">
                                            <a href="{{ url('signature/'.$value->id.'/edit') }}">
                                                <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button>
                                            </a>
                                        </td>
                                        <td class="tdCenter">
                                            {{ Form::open(array('url' => 'signature/' . $value->id, 'class' => 'pull-right')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-xs')) }}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    @php
                                    $SN++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{$allSignature->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer_note')
</div>
@endsection
