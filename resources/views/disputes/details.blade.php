<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/17/2018
 * Time: 3:47 PM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dispute Details Report</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('dispute') }}">Dispute List</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('dispute/summery/'.$disputeDetails['ID']) }}">Dispute Summery</a></li>
                    <li class="breadcrumb-item active">Dispute Details Report</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Dispute Name : {{ $disputeDetails['dName'] }}</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table-0024 display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>Type</th>
                                            <th>Reported Dispute</th>
                                            <th>CDR Dispute</th>
                                            <th>Dispute (%)</th>
                                            <th>From</th>
                                            <th>to</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ $disputeDetails['prtName'] }}</td>
                                            <td>{{ $disputeDetails['dType'] == 1 ? "Customer" : "Supplier" }}</td>
                                            <td>{{ $disputeTable['amount'] }} USD</td>
                                            <td>{{ round($disputeTable['dispute'],2) }} USD</td>
                                            <td>{{ round($disputeTable['percent'],2) }} %</td>
                                            <td>{{ $disputeDetails['fromDate'] }}</td>
                                            <td>{{ $disputeDetails['toDate'] }}</td>
                                            <td>{{ $disputeDetails['created_at'] }}</td>
                                            <td>{!! $disputeTable['status'] !!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <h5>{{ $dynamicField['columnTableOne'] }} Details</h5>
                                    <table class="table-0024 display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Filename</th>
                                            <th>Prefix</th>
                                            <th>Total Call</th>
                                            <th>CDR Amount</th>
                                            <th>Total Duration</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ $disputeDetails['aFileName'] }}</td>
                                            <td>{{ $disputeDetails['aCalledPrefix'] }}</td>
                                            <td>{{ $disputeDetails['aTotalCall'] }}</td>
                                            <td>{{ round($disputeDetails['aTotalCost'],2) }}</td>
                                            <td>{{ round($disputeDetails['aTotalSec'],2)." Secs / ".round(($disputeDetails['aTotalSec']/60),2)." Mins" }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $dynamicField['columnTableTwo'] }} Details</h5>
                                    <table class="table-0024 display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Filename</th>
                                            <th>Prefix</th>
                                            <th>Total Call</th>
                                            <th>CDR Amount</th>
                                            <th>Total Duration</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ $disputeDetails['bFileName'] }}</td>
                                            <td>{{ $disputeDetails['bCalledPrefix'] }}</td>
                                            <td>{{ $disputeDetails['bTotalCall'] }}</td>
                                            <td>{{ round($disputeDetails['bTotalCost'],2) }}</td>
                                            <td>{{ round($disputeDetails['bTotalSec'],2)." Secs / ".round(($disputeDetails['bTotalSec']/60),2)." Mins" }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {!! Form::open(['url'=>'dispute/details/'.$disputeDetails['ID']."/".$mismatchType, 'class'=>'form-0024', 'role'=>'form', 'name'=>'disputeDetailsReport', 'id'=>'disputeDetailsReport']) !!}
                            <div class="card-body">
                                <div class="table-responsive m-t-40">
                                    <h2 style="text-align: center;">Mismatch Type : {{ $mismatchTypeName }}</h2>
                                    <table class="table-0024 display table-0024-rap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="tdSN tdCenter">S/N</th>
                                            <th class="tdSN tdCenter">Called Time</th>
                                            <th class="tdSN tdCenter">Call Form</th>
                                            <th class="tdSN tdCenter">Call To</th>
                                            <th class="tdSN tdCenter">{{ $dynamicField['columnTableOne'] }} (Sec)</th>
                                            <th class="tdSN tdCenter">{{ $dynamicField['columnTableTwo'] }} (Sec)</th>
                                            <th class="tdSN tdCenter">Delta (Sec)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $page = (isset($_REQUEST["page"]) && ($_REQUEST["page"] != NULL)) ? $_REQUEST["page"] : NULL ;
                                            if(is_null($page)){
                                                $SN = 1;
                                            }else{
                                                $SN = (10*($page-1))+1;
                                            }
                                        @endphp
                                        @foreach( $mismatchData as $data )
                                            <tr>
                                                <td>{{ $SN }}</td>
                                                <td>{{ $data->A1 }}</td>
                                                <td>{{ $data->A2 }}</td>
                                                <td>{{ $data->A3 }}</td>
                                                @if (($mismatchType == 5) || ($data->B1 == 'zyz'))
                                                    <td>0</td>
                                                    <td>{{ $data->A4 }}</td>
                                                    <td>{{ 0 - $data->A4 }}</td>
                                                @else
                                                    <td>{{ $data->A4 }}</td>
                                                    <td>{{ $data->B1 }}</td>
                                                    <td>{{ ($data->A4 - $data->B1) }}</td>
                                                @endif
                                            </tr>
                                            @php
                                                $SN++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if (($mismatchType != 6))
                                    {{ $mismatchData->links() }}
                                @endif
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer_note')
    </div>
@endsection