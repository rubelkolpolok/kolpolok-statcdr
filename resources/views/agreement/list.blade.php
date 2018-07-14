<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/22/2018
 * Time: 4:55 PM
 */

use App\Http\Controllers\AgmtListController;

?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Agreement Add</h3></div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('agreement/list') }}">Agreement List</a></li>
                    <li class="breadcrumb-item active">Agreement Add</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Select Agreement</h4>
                            <div class="table-responsive m-t-40">
                                <table class="table-0024 display nowrap table table-hover table-striped table-bordered"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th class="tdCenter">Agreements Type</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $SN = 1;
                                    @endphp
                                    @foreach($allAgmtTypes as $key => $value)
                                        <tr>
                                            <td class="tdCenter">{{ $SN }}</td>
                                            <td class="tdCenter">
                                                <a href="{{ url('agreement/create/'.$value->id) }}">
                                                    {{ $value->typeName }}
                                                </a>
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