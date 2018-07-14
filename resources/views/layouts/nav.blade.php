<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 5/14/2018
 * Time: 12:54 PM
 */
?>
<div class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li><a href="{{ route('dashboard') }}" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu"> Dashboard</span></a></li>

                @if(Auth::user()->authorizeFlag(["admin"]))

                    @if(Session::get('userPlan') >= 1)
                        <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-product-hunt"></i><span class="hide-menu">Plan 1</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a class="has-arrow" href="#"><i class="fa fa-check-square"></i> Appointments</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="{{ url('appointments/events') }}">Events</a></li>
                                        <li><a href="{{ url('appointments/timeslot') }}">Datetime slot</a></li>
                                        <li><a href="{{ url('appointments/list') }}">Appointment List</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="has-arrow" href="#"><i class="fa fa-check-square"></i> Agreements</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="{{ url('agreement/type') }}">Type</a></li>
                                        <li><a href="{{ url('agreement/list') }}">Agreements List</a></li>
                                    </ul>
                                </li>
                                
                                <li>
                                    <a class="has-arrow" href="#"><i class="fa fa-check-square"></i> Signatures</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="{{ url('documents') }}">Documents</a></li>
                                        <li><a href="{{ url('signature') }}">Signature List</a></li>
                                    </ul>
                                </li>
                                
                                
                                
                                <li><a href="#"><i class="fa fa-check-square"></i> Attendance</a></li>
                                <li>
                                    <a class="has-arrow" href="#"><i class="fa fa-check-square"></i> Trouble Tickets</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="{{ url('ticket/create') }}">Add Ticket</a></li>
                                        <li><a href="{{ url('tickets') }}">All Tickets</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-check-square"></i> Billing</a></li>
                            </ul>
                        </li>
                    @endif

                    @if(Session::get('userPlan') >= 2)
                        <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-product-hunt"></i><span class="hide-menu">Plan 2</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a class="has-arrow" href="#"><i class="fa fa-check-square"></i> Disputes</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="{{ url('dispute/create') }}">Add</a></li>
                                        <li><a href="{{ url('dispute') }}">List</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-check-square"></i> TOP lists</a></li>
                            </ul>
                        </li>
                    @endif

                    @if(Session::get('userPlan') == 3)
                        <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-product-hunt"></i><span class="hide-menu">Plan 3</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="#"><i class="fa fa-check-square"></i> Rates</a></li>
                                <li><a href="#"><i class="fa fa-check-square"></i> LCR</a></li>
                            </ul>
                        </li>
                    @endif

                @endif

                <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu">Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if(Auth::user()->authorizeFlag(["superadmin"]))
                            <li><a href="{{ url('users') }}"><i class="fa fa-check-square"></i> Users</a></li>
                        @elseif(Auth::user()->authorizeFlag(["admin"]))
                            <li><a href="{{ url('users') }}"><i class="fa fa-check-square"></i> Users</a></li>
                            <li><a class="has-arrow" href="#"><i class="fa fa-check-square"></i> Tickets</a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="settings_tic_assign.php">Auto Assign</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="#"><i class="fa fa-check-square"></i> Main Settings</a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="settings_general.php">General</a></li>
                                    <li><a href="settings_organization.php">Organization Profile</a></li>
                                    <li><a href="settings_preferences.php">Preferences</a></li>
                                    <li><a href="settings_routing.php">Routing</a></li>
                                    <li><a href="settings_trunk_list.php">Trunk</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>