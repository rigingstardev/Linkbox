<?php namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * EmailHelper - Helper class used for sending emails
 *
 */
class AutoSuggestHelper
{

    /**
     * sendEmail
     *
     * Method uder for sending emails to users
     * 
     */
    public static function autoSuggest($data)
    {
        // dd($data);
        $term    = $data['q'];
        $type    = $data['type'];
        $results = array();
        switch ($type) {
            case 'chiefComplaint':
                $queries = DB::table('chief_complaints')
                        ->select('id', 'cc_text as value')
                        ->where('cc_text', 'LIKE', '%' . $term . '%')
                        ->take(15)->get();
                break;
            case 'physicianEmail':
                $queries = DB::table('users')
                        ->select('id', 'email as value')
                        ->where('email', 'LIKE', '%' . $term . '%')
                        ->where('user_role', '=', 'D')
                        ->where('is_account_active', '=', 'Y')
                        ->take(15)->get();
                break;
            case 'patientEmail':
                $queries = DB::table('patients')
                        ->select('id', 'email as value')
                        ->where('email', 'LIKE', '%' . $term . '%')
                        ->where('is_account_active', '=', 'Y')
                        ->take(15)->get();
                break;


            case 'patientPhone':
                $queries = DB::table('patients')
                        //->select('id', 'contact_number as value')
                        ->select('id', DB::raw('TRIM(LEADING "+" FROM SUBSTRING_INDEX(`contact_number`, "-", -1)) as value'))
                        ->where('contact_number', 'LIKE', '%' . $term . '%')
                        ->take(15)->get();
                break;
        }
        foreach ($queries as $query) {
            $results[] = $query->value;
        }
        return $results;
    }
}
