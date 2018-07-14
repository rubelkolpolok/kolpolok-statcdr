<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/18/2018
 * Time: 11:25 AM
 */
use App\Http\Controllers\AptTimeSlotController;
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Datetime Slot List</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Datetime Slot List</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Datetime Slot List</h4>
                            <h6 class="card-subtitle">All appointments Datetime Slot listed in here</h6>

                            @if(session('status'))
                            <div class="alert alert-primary alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong>Success !!!</strong> {{ session('status') }}
                            </div>
                            @endif

                            <div>
                                <a href="{{ url('appointments/timeslot/create') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Add Datetime Slot</button></a>
                                <button class="btn btn-danger delete_bulk" data-url="{{ url('timeslotDeleteBulk') }}">Delete All Selected</button>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                            </div>
                            <div class="table-responsive m-t-40">
                                <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="tdCenter">
                                            <input placeholder="Timeslot ID Select All Button" name="selectAll" id="selectAll" type="checkbox" />
                                        </th>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Event name</th>
                                        <th>Agent Name</th>
                                        <th class="tdCenter">Duration (minutes)</th>
                                        <th class="tdCenter">Start Time</th>
                                        <th class="tdCenter">End Time</th>
                                        <th class="tdCenter">Edit</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $SN = 1;
                                    @endphp
                                    @foreach($allTimeslot as $key => $value)
                                        <tr id="tr_{{ $value->id }}">
                                            <td class="tdCenter">
                                                <input placeholder="Timeslot ID" name="timeSlotIDs[]" type="checkbox" class="checkActiveAll" value="{{ $value->id }}"/>
                                            </td>
                                            <td class="tdCenter">{{ $SN }}</td>
                                            <td>{{ AptTimeSlotController::eventName($value->evtID) }}</td>
                                            <td>{{ AptTimeSlotController::agentName($value->agentID) }}</td>
                                            <td class="tdCenter">{{ $value->slot_duration }}</td>
                                            <td class="tdCenter">{{ $value->time_slot }}</td>
                                            <td class="tdCenter">{{ date('Y-m-d H:i:s', strtotime($value->time_slot.' + '.$value->slot_duration.' minute')) }}</td>
                                            <td class="tdCenter">
                                                <a href="{{ url('appointments/timeslot/'.$value->id.'/edit') }}">
                                                    <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button>
                                                </a>
                                            </td>
                                            <td class="tdCenter">
                                                {{ Form::open(array('url' => 'appointments/timeslot/' . $value->id, 'class' => 'pull-right')) }}
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
                                    {{$allTimeslot->links()}}
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('#selectAll').click(function (event) {
                                            if (this.checked) {
                                                $('.checkActiveAll').each(function () {
                                                    this.checked = true;
                                                });
                                            } else {
                                                $('.checkActiveAll').each(function () {
                                                    this.checked = false;
                                                });
                                            }
                                        });

                                        $('.delete_bulk').on('click', function(e) {
                                            var allValue = [];
                                            $('.table-0024 tbody tr input:checkbox').each(function() {
                                                if ($(this).is(':checked')) {
                                                    allValue.push(this.value);
                                                }
                                            });

                                            if(allValue.length <= 0){
                                                alert("Please select row.");
                                            }else{
                                                var deleteConfirmation = confirm("Are you sure you want to delete?");
                                                if(deleteConfirmation){
                                                    var comma_separated_values = allValue.join(",");
                                                    $.ajax({
                                                        url: $(this).data('url'),
                                                        type: 'DELETE',
                                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                        data: 'ids='+comma_separated_values,
                                                        success: function (data) {
                                                            $.each(allValue, function( index, value ) {
                                                                document.getElementById("tr_" + value).remove();
                                                            });
                                                            alert(data['success']);
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer_note')
    </div>
@endsection