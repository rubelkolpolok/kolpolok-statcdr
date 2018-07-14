<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/18/2018
 * Time: 11:25 AM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreements Types</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Agreements Types</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Agreements Types</h4>
                            <h6 class="card-subtitle">All agreements types listed in here</h6>

                            @if(session('status'))
                            <div class="alert alert-primary alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong>Success !!!</strong> {{ session('status') }}
                            </div>
                            @endif

                            <div>
                                <a href="{{ url('agreement/type/create') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Add Agreements Type</button></a>
                            </div>
                            <div class="table-responsive m-t-40">
                                <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Agreements Type</th>
                                        <th class="tdCenter">Admin Approval</th>
                                        <th class="tdCenter">Showing Order in Website</th>
                                        <th class="tdCenter">Edit</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $SN = 1;
                                    @endphp
                                    @foreach($allAgmtTypes as $key => $value)
                                        <tr>
                                            <td class="tdCenter">{{ $SN }}</td>
                                            <td>{{ $value->typeName }}</td>

                                            @if($value->adminApprove == 1)
                                                <td class="tdCenter">Yes</td>
                                            @else
                                                <td class="tdCenter">No</td>
                                            @endif

                                            <td class="tdCenter">{{ $value->showOrder }}</td>
                                            <td class="tdCenter">
                                                <a href="{{ url('agreement/type/'.$value->id.'/edit') }}">
                                                    <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button>
                                                </a>
                                            </td>
                                            <td class="tdCenter">
                                                {{ Form::open(array('url' => 'agreement/type/' . $value->id, 'class' => 'pull-right')) }}
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
                                    {{$allAgmtTypes->links()}}
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