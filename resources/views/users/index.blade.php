<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/29/2018
 * Time: 11:50 AM
 */
use App\Http\Controllers\UserController;
?>
@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Users List</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users List</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Users List</h4>
                            <h6 class="card-subtitle">All users listed in here</h6>

                            @if(session('status'))
                                <div class="alert alert-primary alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <strong>Success !!!</strong> {{ session('status') }}
                                </div>
                            @endif

                            <div>
                                <a href="{{ url('users/create') }}"><button class="btn btn-success"> <i class="fa fa-plus"></i> Add User</button></a>
                            </div>
                            <div class="table-responsive m-t-40">
                                <table class="table-0024 display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="tdSN tdCenter">S/N</th>
                                        <th>Name</th>
                                        <th>Email</th>

                                        @if($userRole == 1)
                                            <th>Plan Included</th>
                                        @else
                                            <th>Parent</th>
                                            <th>User Type</th>
                                        @endif

                                        <th class="tdCenter">Edit</th>
                                        <th style="text-align: right;">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $SN = 1;
                                    @endphp
                                    @foreach($userList as $key => $value)
                                        <tr>
                                            <td class="tdCenter">{{ $SN }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->email }}</td>

                                            @if($userRole == 1)
                                                @if($value->userPlan == 1) <td>Plan 1</td>
                                                @elseif($value->userPlan == 2) <td>Plan 2</td>
                                                @elseif($value->userPlan == 3) <td>Plan 3</td>
                                                @else <td></td> @endif
                                            @else
                                                @if(isset($value->parentID) && ($value->parentID != NULL)) <td>{{ UserController::parentName($value->parentID) }}</td>
                                                @else <td></td> @endif

                                                @if($value->userType == 1) <td>Customer</td>
                                                @elseif($value->userType == 2) <td>Vendor</td>
                                                @elseif($value->userType == 3) <td>Bilateral</td>
                                                @elseif($value->userType == 4) <td>Employee</td>
                                                @else <td></td> @endif
                                            @endif

                                            <td class="tdCenter">
                                                <a href="{{ url('users/'.$value->id.'/edit') }}">
                                                    <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button>
                                                </a>
                                            </td>
                                            <td class="tdCenter">
                                                {{ Form::open(array('url' => 'users/' . $value->id, 'class' => 'pull-right')) }}
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
                            </div>
                            {{ $userList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer_note')
    </div>
@endsection