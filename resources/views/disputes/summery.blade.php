<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/16/2018
 * Time: 6:21 PM
 */
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dispute Summery</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('dispute') }}">Dispute List</a></li>
                    <li class="breadcrumb-item active">Dispute Summery</li>
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
                        <div class="card-body">
                            <div class="table-responsive m-t-40">
                                <h2 style="text-align: center;">Report Over View</h2>
                                <table class="table-0024 display table-0024-rap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" class="tdSN tdCenter">Mismatch Type</th>
                                        <th colspan="3" class="tdSN tdCenter" style="border-bottom: 1px solid #e3e3e3;">Calls</th>
                                        <th colspan="3" class="tdSN tdCenter" style="border-bottom: 1px solid #e3e3e3;">Billsec</th>
                                        <th colspan="3" class="tdSN tdCenter" style="border-bottom: 1px solid #e3e3e3;">Price</th>
                                        <th rowspan="2" class="tdSN tdCenter">Details</th>
                                        <th rowspan="2" class="tdSN tdCenter">Export</th>
                                    </tr>
                                    <tr>
                                        <th class="tdCenter">{{ $dynamicField['columnOne'] }}</th>
                                        <th class="tdCenter">{{ $dynamicField['columnTwo'] }}</th>
                                        <th class="tdCenter">Delta</th>
                                        <th class="tdCenter">{{ $dynamicField['columnOne'] }}</th>
                                        <th class="tdCenter">{{ $dynamicField['columnTwo'] }}</th>
                                        <th class="tdCenter">Delta</th>
                                        <th class="tdCenter">{{ $dynamicField['columnOne'] }}</th>
                                        <th class="tdCenter">{{ $dynamicField['columnTwo'] }}</th>
                                        <th class="tdCenter">Delta</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    // Exact Match - START
                                    if(($disputeDone > 0) && isset($dispute[0]->disputeType) && ($dispute[0]->disputeType == 1)){
                                        $dExactMatch = $dispute[0];
                                        $delta_1_1 = $dExactMatch->A1 - $dExactMatch->B1;
                                        $delta_1_2 = $dExactMatch->A2 - $dExactMatch->B2;
                                        $delta_1_3 = $dExactMatch->A3 - $dExactMatch->B3;
                                        ?>
                                        <tr>
                                            <td class="tdCenter" style="background-color: #c4deb9;">Exact Match</td>
                                            <td class="tdCenter">{{ $dExactMatch->A1 }}</td>
                                            <td class="tdCenter">{{ $dExactMatch->B1 }}</td>
                                            <td class="tdCenter">{{ $delta_1_1 }}</td>
                                            <td class="tdCenter">{{ $dExactMatch->A2 }}</td>
                                            <td class="tdCenter">{{ $dExactMatch->B2 }}</td>
                                            <td class="tdCenter">{{ $delta_1_2 }}</td>
                                            <td class="tdCenter">{{ round($dExactMatch->A3,2) }}</td>
                                            <td class="tdCenter">{{ round($dExactMatch->B3,2) }}</td>
                                            <td class="tdCenter">{{ round($delta_1_3,2) }}</td>
                                            <td class="tdCenter"><a href="{{ url('dispute/details/'.$disputeDetails['ID']."/1") }}" target="_blank"><i class="fa fa-file-text-o"></i></a></td>
                                            <td class="tdCenter"><a href="{{ url('dispute/export/'.$disputeDetails['ID']."/1") }}" target="_blank"><i class="fa fa-file-excel-o"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    // Exact Match - END


                                    // Mismatch by Duration( = 1 Sec) - START
                                    if(($disputeDone > 1) && isset($dispute[1]->disputeType) && ($dispute[1]->disputeType == 2)){
                                        $dMissMatchOneSec = $dispute[1];
                                        $delta_2_1 = $dMissMatchOneSec->A1 - $dMissMatchOneSec->B1;
                                        $delta_2_2 = $dMissMatchOneSec->A2 - $dMissMatchOneSec->B2;
                                        $delta_2_3 = $dMissMatchOneSec->A3 - $dMissMatchOneSec->B3;
                                        ?>
                                        <tr>
                                            <td class="tdCenter" style="background-color: #fef5cc;">Mismatch by Billsec(=1Sec)</td>
                                            <td class="tdCenter">{{ $dMissMatchOneSec->A1 }}</td>
                                            <td class="tdCenter">{{ $dMissMatchOneSec->B1 }}</td>
                                            <td class="tdCenter">{{ $delta_2_1 }}</td>
                                            <td class="tdCenter">{{ $dMissMatchOneSec->A2 }}</td>
                                            <td class="tdCenter">{{ $dMissMatchOneSec->B2 }}</td>
                                            <td class="tdCenter">{{ $delta_2_2 }}</td>
                                            <td class="tdCenter">{{ round($dMissMatchOneSec->A3,2) }}</td>
                                            <td class="tdCenter">{{ round($dMissMatchOneSec->B3,2) }}</td>
                                            <td class="tdCenter">{{ round($delta_2_3,2) }}</td>
                                            <td class="tdCenter"><a href="{{ url('dispute/details/'.$disputeDetails['ID']."/2") }}" target="_blank"><i class="fa fa-file-text-o"></i></a></td>
                                            <td class="tdCenter"><a href="{{ url('dispute/export/'.$disputeDetails['ID']."/2") }}" target="_blank"><i class="fa fa-file-excel-o"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    // Mismatch by Duration( = 1 Sec) - END


                                    // Mismatch by Duration( = 2 Sec) - START
                                    if(($disputeDone > 2) && isset($dispute[2]->disputeType) && ($dispute[2]->disputeType == 3)){
                                        $dMissMatchGreOneSec = $dispute[2];
                                        $delta_3_1 = $dMissMatchGreOneSec->A1 - $dMissMatchGreOneSec->B1;
                                        $delta_3_2 = $dMissMatchGreOneSec->A2 - $dMissMatchGreOneSec->B2;
                                        $delta_3_3 = $dMissMatchGreOneSec->A3 - $dMissMatchGreOneSec->B3;
                                        ?>
                                        <tr>
                                            <td class="tdCenter" style="background-color: #f1bfbe;">Mismatch by Billsec(>1Sec)</td>
                                            <td class="tdCenter">{{ $dMissMatchGreOneSec->A1 }}</td>
                                            <td class="tdCenter">{{ $dMissMatchGreOneSec->B1 }}</td>
                                            <td class="tdCenter">{{ $delta_3_1 }}</td>
                                            <td class="tdCenter">{{ $dMissMatchGreOneSec->A2 }}</td>
                                            <td class="tdCenter">{{ $dMissMatchGreOneSec->B2 }}</td>
                                            <td class="tdCenter">{{ $delta_3_2 }}</td>
                                            <td class="tdCenter">{{ round($dMissMatchGreOneSec->A3,2) }}</td>
                                            <td class="tdCenter">{{ round($dMissMatchGreOneSec->B3,2) }}</td>
                                            <td class="tdCenter">{{ round($delta_3_3,2) }}</td>
                                            <td class="tdCenter"><a href="{{ url('dispute/details/'.$disputeDetails['ID']."/3") }}" target="_blank"><i class="fa fa-file-text-o"></i></a></td>
                                            <td class="tdCenter"><a href="{{ url('dispute/export/'.$disputeDetails['ID']."/3") }}" target="_blank"><i class="fa fa-file-excel-o"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    // Mismatch by Duration( = 2 Sec) - END



                                    // Present in Table One CDR Only - START
                                    if(($disputeDone > 3) && isset($dispute[3]->disputeType) && ($dispute[3]->disputeType == 4)){
                                        $dTableOneOnly = $dispute[3];
                                        $delta_4_1 = $dTableOneOnly->A1;
                                        $delta_4_2 = $dTableOneOnly->A2;
                                        $delta_4_3 = $dTableOneOnly->A3;
                                        ?>
                                        <tr>
                                            <td class="tdCenter" style="background-color: #ffd8d7;">Present in {{ $dynamicField['columnOne'] }} CDR Only</td>
                                            <td class="tdCenter">{{ $dTableOneOnly->A1 }}</td>
                                            <td class="tdCenter">0</td>
                                            <td class="tdCenter">{{ $delta_4_1 }}</td>
                                            <td class="tdCenter">{{ $dTableOneOnly->A2 }}</td>
                                            <td class="tdCenter">0</td>
                                            <td class="tdCenter">{{ $delta_4_2 }}</td>
                                            <td class="tdCenter">{{ round($dTableOneOnly->A3,2) }}</td>
                                            <td class="tdCenter">0</td>
                                            <td class="tdCenter">{{ round($delta_4_3,2) }}</td>
                                            <td class="tdCenter"><a href="{{ url('dispute/details/'.$disputeDetails['ID']."/4") }}" target="_blank"><i class="fa fa-file-text-o"></i></a></td>
                                            <td class="tdCenter"><a href="{{ url('dispute/export/'.$disputeDetails['ID']."/4") }}" target="_blank"><i class="fa fa-file-excel-o"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    // Present in Table One CDR Only - END


                                    // Present in Table Two CDR Only - START
                                    if(($disputeDone > 4) && isset($dispute[4]->disputeType) && ($dispute[4]->disputeType == 5)){
                                        $dTableTwoOnly = $dispute[4];
                                        $delta_5_1 = $dTableTwoOnly->A1;
                                        $delta_5_2 = $dTableTwoOnly->A2;
                                        $delta_5_3 = $dTableTwoOnly->A3;
                                        ?>
                                        <tr>
                                            <td class="tdCenter" style="background-color: #ffc4c3;">Present in {{ $dynamicField['columnTwo'] }} CDR Only</td>
                                            <td class="tdCenter">0</td>
                                            <td class="tdCenter">{{ $dTableTwoOnly->A1 }}</td>
                                            <td class="tdCenter">{{ $delta_5_1 }}</td>
                                            <td class="tdCenter">0</td>
                                            <td class="tdCenter">{{ $dTableTwoOnly->A2 }}</td>
                                            <td class="tdCenter">{{ $delta_5_2 }}</td>
                                            <td class="tdCenter">0</td>
                                            <td class="tdCenter">{{ round($dTableTwoOnly->A3,2) }}</td>
                                            <td class="tdCenter">{{ round($delta_5_3,2) }}</td>
                                            <td class="tdCenter"><a href="{{ url('dispute/details/'.$disputeDetails['ID']."/5") }}" target="_blank"><i class="fa fa-file-text-o"></i></a></td>
                                            <td class="tdCenter"><a href="{{ url('dispute/export/'.$disputeDetails['ID']."/5") }}" target="_blank"><i class="fa fa-file-excel-o"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    // Present in Table Two CDR Only - END


                                    // Exact Mismatch(All Mismatch) - START
                                    if($disputeDone > 4){

                                        $call_A = ($dMissMatchOneSec->A1 + $dMissMatchGreOneSec->A1 + $dTableOneOnly->A1 + 0);
                                        $call_B = ($dMissMatchOneSec->B1 + $dMissMatchGreOneSec->B1 + 0 + $dTableTwoOnly->A1);
                                        $call_D = ($dTableOneOnly->A1 + $dTableTwoOnly->A1 + $dMissMatchOneSec->A1 + $dMissMatchGreOneSec->A1);

                                        $sec_A = ($dMissMatchOneSec->A2 + $dMissMatchGreOneSec->A2 + $dTableOneOnly->A2 + 0);
                                        $sec_B = ($dMissMatchOneSec->B2 + $dMissMatchGreOneSec->B2 + 0 + $dTableTwoOnly->A2);
                                        $sec_D = (($dTableOneOnly->A2 - $dTableTwoOnly->A2) + $delta_2_2 + $delta_3_2);

                                        $prc_A = ($dMissMatchOneSec->A3 + $dMissMatchGreOneSec->A3 + $dTableOneOnly->A3 + 0);
                                        $prc_B = ($dMissMatchOneSec->B3 + $dMissMatchGreOneSec->B3 + 0 + $dTableTwoOnly->A3);
                                        $prc_D = (($dTableOneOnly->A3 - $dTableTwoOnly->A3) + $delta_1_3 + $delta_2_3 + $delta_3_3);
                                        ?>
                                        <tr>
                                            <td class="tdCenter" style="background-color: #ffa39b;">Exact Mismatch</td>
                                            <td class="tdCenter">{{ $call_A }}</td>
                                            <td class="tdCenter">{{ $call_B }}</td>
                                            <td class="tdCenter">{{ $call_D }}</td>
                                            <td class="tdCenter">{{ $sec_A }}</td>
                                            <td class="tdCenter">{{ $sec_B }}</td>
                                            <td class="tdCenter">{{ $sec_D }}</td>
                                            <td class="tdCenter">{{ round($prc_A,2) }}</td>
                                            <td class="tdCenter">{{ round($prc_B,2) }}</td>
                                            <td class="tdCenter">{{ round($prc_D,2) }}</td>
                                            <td class="tdCenter"><a href="{{ url('dispute/details/'.$disputeDetails['ID']."/6") }}" target="_blank"><i class="fa fa-file-text-o"></i></a></td>
                                            <td class="tdCenter"><a href="{{ url('dispute/export/'.$disputeDetails['ID']."/6") }}" target="_blank"><i class="fa fa-file-excel-o"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    // Exact Mismatch(All Mismatch) - END
                                    ?>
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