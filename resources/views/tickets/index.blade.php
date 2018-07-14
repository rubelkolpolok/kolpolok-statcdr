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
            <h3 class="text-primary">Ticket List</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Ticket List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ticket List</h4>

                        @if(session('status'))
                        <div class="alert alert-primary alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            {{ session('status') }}
                        </div>
                        @endif

                        <div>
                            <a href="{{ url('ticket/create') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Create Ticket</button></a>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Subject</th>
                                        <th>Support Email</th>
                                        <th>Customer Email</th>
                                        <th>Created at</th>
                                        <th>Details</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $SN = 1;
                                    @endphp
                                    @foreach($allTickets as $key => $value)

                                    <tr>
                                        <td class="tdCenter">{{ $SN }}</td>
                                        <td>{{ $value->subject }}</td>
                                        <td>{{ $value->supportEmail }}</td>
                                        <td>{{ $value->customerEmail }}</td>
                                        <td>{{ $value->created_at }}</td>
                                        <td class="tdCenter">
                                            <a href="{{ url('ticket/'.$value->id.'/show/') }}"><i class="fa fa-file-text-o"></i></a>
                                        </td>
                                        <td class="tdCenter">
                                            {{ Form::open(array('url' => 'dispute/', 'class' => 'pull-right')) }}
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
                                {{$allTickets->links()}}
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