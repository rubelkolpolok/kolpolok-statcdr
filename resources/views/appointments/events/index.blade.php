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
                <h3 class="text-primary">Event List</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Event List</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Event List</h4>
                            <h6 class="card-subtitle">All appointments events listed in here</h6>

                            @if(session('status'))
                            <div class="alert alert-primary alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong>Success !!!</strong> {{ session('status') }}
                            </div>
                            @endif

                            <div>
                                <a href="{{ url('appointments/events/create') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Add Event</button></a>
                            </div>
                            <div class="table-responsive m-t-40">
                                <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Event name</th>
                                        <th>Event Addr</th>
                                        <th>Starting Date</th>
                                        <th>Ending Date</th>
                                        <th>Start Show in Website</th>
                                        <th>Status</th>
                                        <th class="tdCenter">Edit</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $SN = 1;
                                    @endphp
                                    @foreach($allEvents as $key => $value)
                                        @php
                                            if((date('Y-m-d') >= date('Y-m-d', strtotime($value->evtStart))) && (date('Y-m-d') <= date('Y-m-d', strtotime($value->evtEnd)))){
                                                $eventStatus = 1;
                                                $eventStsTyp = 'Running';

                                            }elseif(date('Y-m-d') > date('Y-m-d', strtotime($value->evtEnd))){
                                                $eventStatus = 2;
                                                $eventStsTyp = 'Expired';

                                            }elseif(date('Y-m-d') < date('Y-m-d', strtotime($value->evtStart))){
                                                $eventStatus = 3;
                                                $eventStsTyp = 'Opening Soon';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="tdCenter">{{ $SN }}</td>
                                            <td>{{ $value->evtName }}</td>
                                            <td>{{ $value->evtAddr }}</td>
                                            <td>{{ $value->evtStart }}</td>
                                            <td>{{ $value->evtEnd }}</td>
                                            <td>{{ $value->evtShowWeb }}</td>
                                            <td>{{ $eventStsTyp }}</td>
                                            @if($eventStatus)
                                                <td class="tdCenter">
                                                    <a href="{{ url('appointments/events/'.$value->id.'/edit') }}">
                                                        <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button>
                                                    </a>
                                                </td>
                                                <td class="tdCenter">
                                                    {{ Form::open(array('url' => 'appointments/events/' . $value->id, 'class' => 'pull-right')) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}
                                                    {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-xs')) }}
                                                    {{ Form::close() }}
                                                </td>
                                            @else
                                                <td class="tdCenter"></td>
                                                <td class="tdCenter"></td>
                                            @endif
                                        </tr>
                                        @php
                                            $SN++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    {{$allEvents->links()}}
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