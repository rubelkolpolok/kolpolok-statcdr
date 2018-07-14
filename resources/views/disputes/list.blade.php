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
                <h3 class="text-primary">Dispute List</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Dispute List</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Dispute List</h4>
                            <h6 class="card-subtitle">All disputes listed in here</h6>

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
                                        <th>Dispute name</th>
                                        <th>Company</th>
                                        <th>Type</th>
                                        <th>Reported Dispute</th>
                                        <th>CDR Dispute</th>
                                        <th>Dispute (%)</th>
                                        <th>From</th>
                                        <th>to</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th class="tdCenter">Details</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp

                                    @foreach($allDisputes as $dispute)

                                        @php
                                            if($dispute['uploadStatus'] == 1){
                                                $uploadStatus = '<span class="badge badge-success">Upload DONE</span>';
                                            }elseif($dispute['uploadStatus'] == -1){
                                                $uploadStatus = '<span class="badge badge-primary">Currently Uploading</span>';
                                            }else{
                                                $uploadStatus = '<span class="badge badge-danger">Upload pending</span>';
                                            }
                                            $disputeAmount = isset($dispute['dAmount'])?$dispute['dAmount']:1;
                                            $disputeCal    = $dispute['aTotalCost'] - $dispute['bTotalCost'];
                                            $disputePer    = ($disputeCal * 100)/$disputeAmount;
                                        @endphp

                                        <tr>
                                            <td class="tdCenter">{{ $sn }}</td>
                                            <td>{{ $dispute['dName'] }}</td>
                                            <td>{{ $dispute['prtName'] }}</td>
                                            <td>{{ $dispute['dType'] == 1 ? "Customer" : "Supplier" }}</td>
                                            <td>{{ $disputeAmount }} USD</td>
                                            <td>{{ round($disputeCal,2) }} USD</td>
                                            <td>{{ round($disputePer,2) }} %</td>
                                            <td>{{ $dispute['fromDate'] }}</td>
                                            <td>{{ $dispute['toDate'] }}</td>
                                            <td>{{ $dispute['created_at'] }}</td>
                                            <td>{!! $uploadStatus !!}</td>
                                            <td class="tdCenter">
                                                <a href="{{ url('dispute/summery/'.$dispute['ID']) }}"><i class="fa fa-file-text-o"></i></a>
                                            </td>
                                            <td class="tdCenter">
                                                {{ Form::open(array('url' => 'dispute/' . $dispute['ID'], 'class' => 'pull-right')) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-xs')) }}
                                                {{ Form::close() }}
                                            </td>
                                        </tr>

                                        @php
                                        $sn++;
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