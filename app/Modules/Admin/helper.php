<?php
/**
 * 	Admin Helper  
 */
if (!function_exists('convertDateToMMDDYYYY')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function convertDateToMMDDYYYY($date, $separator)
    {
        if ($separator == '-')
            return date("m-d-Y", strtotime($date));
        elseif ($separator == 'withTime')
            if ($date != '0000-00-00 00:00:00')
                return date("d M Y, h. i a", strtotime($date));
            else
                return '-';
        elseif ($separator == 'at')
            return date("F d \a\\t h:i A", strtotime($date));
        elseif ($separator == 'MFirst')//Nov 21, 2016 10:20 AM
            return date("M d, Y h:i A", strtotime($date));
        else
            return date("m/d/Y", strtotime($date));
    }
}
/**
 * 	Admin Helper  
 */
if (!function_exists('getValueOf')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function getValueOf($input, $checkType)
    {
        $return = '';
        if ($checkType == 'Gender' && $input != '') {
            if ($input == 'M')
                $return = 'Male';
            else if ($input == 'F')
                $return = 'Female';
        }else if ($checkType == 'Age' && $input != '') {
            $from   = new DateTime($input);
            $to     = new DateTime('today');
            $return = $from->diff($to)->y . ' years';
            if ($return == 0)
                $return = $from->diff($to)->m . ' months';
            if ($return == 0)
                $return = $from->diff($to)->d . ' days';
        }
        return $return;
//            return date("m-d-Y", strtotime($date));
//        elseif ($separator == 'withTime')
//            return date("d M Y, h. i a", strtotime($date));
//        else
//            return date("m/d/Y", strtotime($date));
    }
}

/**
 * 	Admin Helper  
 */
if (!function_exists('adminClassActive')) {

    /**
     * Setting active menu class
     * 
     * @return string
     *    
     */
    function adminClassActive()
    {
        if (
            Request::is('admin/home') ||
            Request::is('admin/physicianProfileView/*') ||
            Request::is('admin/listPhysicians')) {
            return 'menu_physicians';
        }
        if (
            Request::is('admin/listPatients') ||
            Request::is('admin/patientProfileView/*')) {
            return 'menu_patients';
        }
        if (
            Request::is('admin/manageLibrary') ||
            Request::is('admin/editLibrary/*')) {
            return 'menu_library';
        }
    }
}