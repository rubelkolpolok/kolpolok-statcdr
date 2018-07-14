<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/22/2018
 * Time: 3:08 PM
 */
?>
@extends('guest.layout')

@section('content')
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

                        <div class="table-responsive m-t-40">
                            <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                            <a href="{{ url('agreements/'.$value->id) }}">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection