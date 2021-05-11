@extends('layouts.app_home')

@section('content')


@if(session()->get('success'))
<div class="alert alert-success">
{{ session()->get('success') }}
</div>
@endif

<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary box-body">
    <div class="row">
            <div class="col-xs-4">
                <p><b>Employee Name: </b>{{ $user->display_name }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Employee ID: </b>{{ $user->emp_id }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Date of Joining: </b>{{ $converted_dates['joining_date'] }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <p><b>Designation: </b>{{ $user->designation }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Department: </b>{{ $user->department_name }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Lead: </b>{{ ($user->lead == NULL) ? 'Not Assigned' : $user->lead }}</p>
            </div>
        </div>
    </div>
</div>

<!-- No Due status -->

{{-- <div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">No Due Status</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>Lead</th>
                            <th>Department Head / Unit Head</th>
                            <th>HR</th>
                            <th>SA</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td @if($nodue) class="{{ ($nodue->knowledge_transfer_lead == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Knowledge Transfer</td>
                                <td @if($nodue) class="{{ ($nodue->knowledge_transfer_head == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Knowledge Transfer</td>
                                <td @if($nodue) class="{{ ($nodue->id_card == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>ID Card</td>
                                <td @if($nodue) class="{{ ($nodue->official_email_id == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Official Email ID</td>
                            </tr>
                            <tr>
                                <td @if($nodue) class="{{ ($nodue->mail_id_closure_lead == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Mail ID Closure</td>
                                <td @if($nodue) class="{{ ($nodue->mail_id_closure_head == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Mail ID Closure</td>
                                <td @if($nodue) class="{{ ($nodue->nda == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>NDA</td>
                                <td @if($nodue) class="{{ ($nodue->skype_account == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Skype Account</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    @if($completed_no_due)
                    <a href="{{ route('questions.index')}}" class="btn btn-primary" style="float: right;" @if($answers) disabled title="You have already done this!" @endif>Exit Interview</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> --}}


<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">No Due Status</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>HR</th>
                            <th>Accounts</th>
                            <th>Admin</th>

                            <th>Qulaity</th>

                        </thead>
                        <tbody>
                            <tr>
                                <td @if(isset($nodueAttribute['id_card'])) class="{{ ($nodueAttribute['id_card'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >ID Card</td>
                                <td @if(isset($nodueAttribute['salary_advance_due'])) class="{{ ($nodueAttribute['salary_advance_due'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Salary Advance Due</td>
                                <td @if(isset($nodueAttribute['laptop'])) class="{{ ($nodueAttribute['laptop'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Laptop</td>
                                <td @if(isset($nodueAttribute['exit_process_completion'])) class="{{ ($nodueAttribute['exit_process_completion'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Exit Process Completion from Core Departments</td>

                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['nda'])) class="{{ ($nodueAttribute['nda'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >NDA</td>
                                <td @if(isset($nodueAttribute['income_tax_due'])) class="{{ ($nodueAttribute['income_tax_due'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Income Tax Due</td>
                                <td @if(isset($nodueAttribute['data_card'])) class="{{ ($nodueAttribute['data_card'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Data Card</td>
                                <td @if(isset($nodueAttribute['isms_qms'])) class="{{ ($nodueAttribute['isms_qms'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >ISMS/QMS Incidents & Tickets Closure Status</td>

                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['professional_tax'])) class="{{ ($nodueAttribute['professional_tax'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Professional Tax</td>
                                <td @if(isset($nodueAttribute['documents_it'])) class="{{ ($nodueAttribute['documents_it'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Documents for IT</td>
                                <td @if(isset($nodueAttribute['official_property'])) class="{{ ($nodueAttribute['official_property'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Official Property If Any</td>
                                <td @if(isset($nodueAttribute['disable_access'])) class="{{ ($nodueAttribute['disable_access'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Disable all Access Control</td>

                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <th>SA</th>
                            <th>Technical Team</th>
                            <th>Marketing Team</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td @if(isset($nodueAttribute['official_email_id'])) class="{{ ($nodueAttribute['official_email_id'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Official Email Account</td>
                                <td @if(isset($nodueAttribute['kt_completion'])) class="{{ ($nodueAttribute['kt_completion'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >KT completed for all the current and old projects</td>
                                <td @if(isset($nodueAttribute['client_details_handle'])) class="{{ ($nodueAttribute['client_details_handle'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Handing over CLIENT details (Excel)</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['skype_account'])) class="{{ ($nodueAttribute['skype_account'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Skype Account</td>
                                <td @if(isset($nodueAttribute['relieving_date_informed'])) class="{{ ($nodueAttribute['relieving_date_informed'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Relieving date informed and accepted by client</td>
                                <td @if(isset($nodueAttribute['kt_hot_warm'])) class="{{ ($nodueAttribute['kt_hot_warm'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >KT on HOT & WARM prospects</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['gmail_yahoo'])) class="{{ ($nodueAttribute['gmail_yahoo'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Gmail or Yahoo Testing Purpose</td>
                                <td @if(isset($nodueAttribute['internal_client_souce_code'])) class="{{ ($nodueAttribute['internal_client_souce_code'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)</td>
                                <td @if(isset($nodueAttribute['intro_new_acc_manager'])) class="{{ ($nodueAttribute['intro_new_acc_manager'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Introducing new account manager to CLIENTS via Email</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['testing_tools'])) class="{{ ($nodueAttribute['testing_tools'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Testing Tools</td>
                                <td @if(isset($nodueAttribute['project_detail_document'])) class="{{ ($nodueAttribute['project_detail_document'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)</td>
                                <td @if(isset($nodueAttribute['data_categorization'])) class="{{ ($nodueAttribute['data_categorization'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Completion of Data Categorization</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['linux_mac_password'])) class="{{ ($nodueAttribute['linux_mac_password'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Linux or Mac machine Password</td>
                                <td></td>
                                <td @if(isset($nodueAttribute['rfp_system'])) class="{{ ($nodueAttribute['rfp_system'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >RFP System updation</td>

                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['renewal_tools'])) class="{{ ($nodueAttribute['renewal_tools'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Specific tools for renewal details</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['testing_device'])) class="{{ ($nodueAttribute['testing_device'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Handover Testing Device</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['headset'])) class="{{ ($nodueAttribute['headset'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Headset</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['machine_port_forwarding'])) class="{{ ($nodueAttribute['machine_port_forwarding'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Machine Port Forwarding</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['svn_vss_tfs'])) class="{{ ($nodueAttribute['svn_vss_tfs'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >SVN & VSS & TFS Login Details</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['rdp_vpn'])) class="{{ ($nodueAttribute['rdp_vpn'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >RDP, VPN Connection</td>
                            </tr>
                            <tr>
                                <td @if(isset($nodueAttribute['laptop_datacard'])) class="{{ ($nodueAttribute['laptop_datacard'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Laptop and Data card</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
