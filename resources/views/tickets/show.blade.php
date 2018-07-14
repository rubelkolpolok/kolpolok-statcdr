<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/18/2018
 * Time: 11:26 AM
 */
?>
@extends('layouts.app')

@section('content')
<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Ticket Details</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url("dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url("tickets") }}">Ticket List</a></li>
                <li class="breadcrumb-item active">Ticket Details</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['url'=>'ticket/reply', 'class'=>'form-0024', 'role'=>'form','name'=>'replyTicket']) !!}
                        <div class="form-body">
                            <div class="form-group">
                                <p style="position:absolute;right: 10px;;">{{ $ticket['created_at']->format('j F Y h:i:s a')}}</p>
                                <label>Ticket Subject</label>
                                <h4 class="media-heading">{{ $ticket['subject'] }}</h4> 
                            </div>
                            <div class="form-group">
                                <label>Ticket Description</label>
                                <h4 class="media-heading">{!! nl2br($ticket['description']) !!}</h4>
                            </div>
                            <p>Discussions</p>
                            <div class="form-group ">
                                <div class="recent-comment">
                                    @foreach($replies as $key => $value)
                                    <div style="padding: 10px;margin: 5px 0;border-radius: 4px;" class="media {{ $value['repliedBy'] == 2 ? 'bg-light-info':'bg-light-danger'}}">
                                        <div class="media-body">
                                            <h4 class="media-heading">{{ $value['replyEmail'] }}</h4>
                                            <p>{{ $value['description'] }}</p>
                                            <p class="comment-date" style="position: relative;">{{ $value['created_at']->format('j F Y h:i:s a')}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="col-md-10 offset-1">
                                <div class="form-group">
                                    {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Reply to this Ticket', 'required' => 'required']) !!}

                                    @if($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                {{ Form::hidden('ticketID', $ticket['id']) }}
                                {!! Form::submit('Reply', ['name' => 'replyTicketSubmit', 'class' => 'btn btn-success']) !!}
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer_note')
</div>
@endsection