<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Synergysystem;
use App\User;
use Redirect;
use Session;
use Illuminate\Support\Facades\Hash;

use Auth;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use App\UserDetails;
use App\UserDesignation;
use App\Lead;

//use DB;

class UserDetailsController extends Controller
 {
    //protected $user;

    public function __construct( Request $request )
 {
    }

    public function index()
 {
        $user_details = UserDetails::select( 'CGVak_EmployeeMaster.EmployeeNumber', 'CGVak_EmployeeMaster.EmployeeFirstName', 'CGVak_EmployeeMaster.EmployeeLastName', 'CGVak_EmployeeMaster.EmployeeDisplayName', 'CGVak_EmployeeMaster.DesignationICode', 'CGVak_EmployeeMaster.EmployeeDateOfJoining', 'CGVak_EmployeeMaster.LoginUserName', 'CGVak_DesignationMaster.Designation', 'CGVak_EmployeeMaster.EmployeeCorporateEmailId',  'CGVak_EmployeeMaster.LoginPassword','CGVak_DepartmentMaster.DepartmentICode','CGVak_DepartmentMaster.DepartmentName' )->join( 'CGVak_DesignationMaster', 'CGVak_EmployeeMaster.DesignationICode', '=', 'CGVak_DesignationMaster.DesignationICode' )->join( 'CGVak_DepartmentMaster', 'CGVak_DepartmentMaster.DepartmentICode', '=', 'CGVak_DesignationMaster.DepartmentICode' ) ->where( 'CGVak_EmployeeMaster.IsActive', '=', 'true' )->orderby( 'CGVak_EmployeeMaster.EmployeeNumber' )->get();
        foreach ( $user_details as $users ) {
            if ( ( isset( $users->EmployeeNumber ) ) && ( isset( $users->EmployeeCorporateEmailId ) ) ) {
                $save = User::updateOrCreate(
                    ['emp_id' => $users->EmployeeNumber],
                    [
                        'first_name' => $users->EmployeeFirstName,
                        'last_name' => $users->EmployeeLastName,
                        'display_name' => $users->EmployeeDisplayName,
                        'name' => $users->LoginUserName,
                        'designation' => $users->Designation,
                        'designation_id' => $users->DesignationICode,
                        'department_id' => $users->DepartmentICode,
                        'department_name' => $users->DepartmentName,
                        'joining_date' => $users->EmployeeDateOfJoining,
                        'email' => $users->EmployeeCorporateEmailId,
                        'password' =>Hash::make( $users->LoginPassword ),
                    ]
                );
            }
        }
        echo 'successfully completed';
    }
}
