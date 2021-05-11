<?php $__env->startSection('content'); ?>


<?php if(session()->get('success')): ?>
<div class="alert alert-success">
<?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>

<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary box-body">
    <div class="row">
            <div class="col-xs-4">
                <p><b>Employee Name: </b><?php echo e($user->display_name); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Employee ID: </b><?php echo e($user->emp_id); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Date of Joining: </b><?php echo e($converted_dates['joining_date']); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <p><b>Designation: </b><?php echo e($user->designation); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Department: </b><?php echo e($user->department_name); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Lead: </b><?php echo e(($user->lead == NULL) ? 'Not Assigned' : $user->lead); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- No Due status -->




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
                                <td <?php if(isset($nodueAttribute['id_card'])): ?> class="<?php echo e(($nodueAttribute['id_card'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >ID Card</td>
                                <td <?php if(isset($nodueAttribute['salary_advance_due'])): ?> class="<?php echo e(($nodueAttribute['salary_advance_due'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Salary Advance Due</td>
                                <td <?php if(isset($nodueAttribute['laptop'])): ?> class="<?php echo e(($nodueAttribute['laptop'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Laptop</td>
                                <td <?php if(isset($nodueAttribute['exit_process_completion'])): ?> class="<?php echo e(($nodueAttribute['exit_process_completion'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Exit Process Completion from Core Departments</td>

                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['nda'])): ?> class="<?php echo e(($nodueAttribute['nda'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >NDA</td>
                                <td <?php if(isset($nodueAttribute['income_tax_due'])): ?> class="<?php echo e(($nodueAttribute['income_tax_due'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Income Tax Due</td>
                                <td <?php if(isset($nodueAttribute['data_card'])): ?> class="<?php echo e(($nodueAttribute['data_card'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Data Card</td>
                                <td <?php if(isset($nodueAttribute['isms_qms'])): ?> class="<?php echo e(($nodueAttribute['isms_qms'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >ISMS/QMS Incidents & Tickets Closure Status</td>

                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['professional_tax'])): ?> class="<?php echo e(($nodueAttribute['professional_tax'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Professional Tax</td>
                                <td <?php if(isset($nodueAttribute['documents_it'])): ?> class="<?php echo e(($nodueAttribute['documents_it'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Documents for IT</td>
                                <td <?php if(isset($nodueAttribute['official_property'])): ?> class="<?php echo e(($nodueAttribute['official_property'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Official Property If Any</td>
                                <td <?php if(isset($nodueAttribute['disable_access'])): ?> class="<?php echo e(($nodueAttribute['disable_access'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Disable all Access Control</td>

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
                                <td <?php if(isset($nodueAttribute['official_email_id'])): ?> class="<?php echo e(($nodueAttribute['official_email_id'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Official Email Account</td>
                                <td <?php if(isset($nodueAttribute['kt_completion'])): ?> class="<?php echo e(($nodueAttribute['kt_completion'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >KT completed for all the current and old projects</td>
                                <td <?php if(isset($nodueAttribute['client_details_handle'])): ?> class="<?php echo e(($nodueAttribute['client_details_handle'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Handing over CLIENT details (Excel)</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['skype_account'])): ?> class="<?php echo e(($nodueAttribute['skype_account'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Skype Account</td>
                                <td <?php if(isset($nodueAttribute['relieving_date_informed'])): ?> class="<?php echo e(($nodueAttribute['relieving_date_informed'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Relieving date informed and accepted by client</td>
                                <td <?php if(isset($nodueAttribute['kt_hot_warm'])): ?> class="<?php echo e(($nodueAttribute['kt_hot_warm'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >KT on HOT & WARM prospects</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['gmail_yahoo'])): ?> class="<?php echo e(($nodueAttribute['gmail_yahoo'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Gmail or Yahoo Testing Purpose</td>
                                <td <?php if(isset($nodueAttribute['internal_client_souce_code'])): ?> class="<?php echo e(($nodueAttribute['internal_client_souce_code'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)</td>
                                <td <?php if(isset($nodueAttribute['intro_new_acc_manager'])): ?> class="<?php echo e(($nodueAttribute['intro_new_acc_manager'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Introducing new account manager to CLIENTS via Email</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['testing_tools'])): ?> class="<?php echo e(($nodueAttribute['testing_tools'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Testing Tools</td>
                                <td <?php if(isset($nodueAttribute['project_detail_document'])): ?> class="<?php echo e(($nodueAttribute['project_detail_document'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)</td>
                                <td <?php if(isset($nodueAttribute['data_categorization'])): ?> class="<?php echo e(($nodueAttribute['data_categorization'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Completion of Data Categorization</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['linux_mac_password'])): ?> class="<?php echo e(($nodueAttribute['linux_mac_password'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Linux or Mac machine Password</td>
                                <td></td>
                                <td <?php if(isset($nodueAttribute['rfp_system'])): ?> class="<?php echo e(($nodueAttribute['rfp_system'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >RFP System updation</td>

                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['renewal_tools'])): ?> class="<?php echo e(($nodueAttribute['renewal_tools'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Specific tools for renewal details</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['testing_device'])): ?> class="<?php echo e(($nodueAttribute['testing_device'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Handover Testing Device</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['headset'])): ?> class="<?php echo e(($nodueAttribute['headset'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Headset</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['machine_port_forwarding'])): ?> class="<?php echo e(($nodueAttribute['machine_port_forwarding'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Machine Port Forwarding</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['svn_vss_tfs'])): ?> class="<?php echo e(($nodueAttribute['svn_vss_tfs'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >SVN & VSS & TFS Login Details</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['rdp_vpn'])): ?> class="<?php echo e(($nodueAttribute['rdp_vpn'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >RDP, VPN Connection</td>
                            </tr>
                            <tr>
                                <td <?php if(isset($nodueAttribute['laptop_datacard'])): ?> class="<?php echo e(($nodueAttribute['laptop_datacard'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Laptop and Data card</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/resignation/noDueStatus.blade.php ENDPATH**/ ?>