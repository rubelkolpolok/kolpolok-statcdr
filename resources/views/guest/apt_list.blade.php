<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/19/2018
 * Time: 10:35 AM
 */
?>
@extends('guest.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h2 style="text-align: center;">StatCDR Appointment Scheduler</h2>
                    @if($eventDetails != -1)
                        <h5 style="text-align: center;">All appointments listed in here</h5>

                        @if(session('status'))
                            <div class="alert alert-primary alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong>Success !!!</strong> {{ session('status') }}
                            </div>
                        @endif

                        <div class="table-responsive m-t-40">
                            <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="tdSN tdCenter">S/N</th>
                                    <th class="tdCenter">Events Name</th>
                                    <th class="tdCenter">Events Address</th>
                                    <th class="tdCenter">Starting Date</th>
                                    <th class="tdCenter">Ending Date</th>
                                    <th class="tdCenter">Schedule appointment</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $SN = 1;
                                @endphp
                                @foreach($eventDetails as $key => $value)
                                    <tr>
                                        <td class="tdCenter">{{ $SN }}</td>
                                        <td class="tdCenter">{{ $value->evtName }}</td>
                                        <td class="tdCenter">{{ $value->evtAddr }}</td>
                                        <td class="tdCenter">{{ $value->evtStart }}</td>
                                        <td class="tdCenter">{{ $value->evtEnd }}</td>
                                        <td class="tdCenter">
                                            <a href="{{ url('appointments/'.$value->id) }}">
                                                Schedule appointment
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        $SN++;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <h5 style="text-align: center;">Presently, no meetings are scheduled. We will come back with the next meetings.</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection