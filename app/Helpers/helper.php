<?php
namespace App\Helpers;
use App\Support\Facades\DB;

class Helper{
    public static function leadsList(){
        $leads_from_users_table = \DB::table( 'users' )
        ->select(\DB::raw('DISTINCT(`designation`),`designation_id`,`emp_id`,`department_id`'))
        ->where('designation','like','%lead%')
        ->get();

        return $leads_from_users_table;
    }
}

?>