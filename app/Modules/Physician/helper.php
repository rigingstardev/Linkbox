<?php
/**
 * 	Physician Helper  
 */
if (!function_exists('permission')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function permission($permissions)
    {
        $permissionArr  = explode("_", $permissions);
        $permission_val = preg_replace('/(?<!\ )[A-Z]/', ' $0', ucfirst(array_pop($permissionArr)));
        return $permission_val;
    }
}
if (!function_exists('hasPermission')) {

    /**
     * String value of Permission
     *
     * @param  int     $permissions    
     * @return string
     *    
     */
    function hasPermission($permissions = null)
    {
        $can = true;
        if ('S' == \Auth::user()->user_role) {
            $can = false;
            if (\Auth::user()->hasPermission($permissions)) {
                $can = true;
            }
        }
        return $can;
    }
}
/**
 * 	Physician Helper  
 */
if (!function_exists('replaceTextWithActualValue')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function replaceTextWithActualValue($stepCompleted, $checkText, $replaceWith, $replaceIn, $textType)
    {
        $returnText = str_replace($checkText, $replaceWith, $replaceIn);
        return $returnText;
    }
}



/**
 * 	Physician Helper  
 */
if (!function_exists('showQusetionCategoryComments')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function showQusetionCategoryComments($comment, $commentType)
    {
//        if ($textType == 'cc') {
//            if ($stepCompleted == 'N')
//                return $replaceIn;
//            else
        if ($comment != '')
            return '<a href="javascript:void(0)" class="txt-large mrgn-lft-15" data-toggle="tooltip" data-placement="right" title="' . $comment . '"><i class="fa fa-info-circle"></i></a>';
//        }
    }
}


/**
 * 	Physician Helper  
 */
if (!function_exists('encryptString')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function encryptString($str, $encType)
    {
        if ($encType == 'base64') {
            $encryptedString = base64_encode($str);
            $reversedString  = strrev($encryptedString);
            return $reversedString;
        }
    }
}
/**
 * 	Physician Helper  
 */
if (!function_exists('decryptString')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function decryptString($str, $encType)
    {
        if ($encType == 'base64') {
            $inversedString  = strrev($str);
            $decryptedString = base64_decode($inversedString);
            return $decryptedString;
        }
    }
}
/**
 * 	Physician Helper  
 */
if (!function_exists('isLinkBoxMember')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function isLinkBoxMember($str)
    {
        if ($str == 'Y')
            return 'Yes';
        else if ($str == 'P')
            return 'No';
    }
}


/**
 * 	Physician Helper  
 */
if (!function_exists('setYesOrNo')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function setYesOrNo($str)
    {
        if ($str == 'Y' || $str == 1)
            return 'Yes';
        else if ($str == 'P' || $str == 0)
            return 'No';
    }
}



/**
 * 	Physician Helper  
 */
if (!function_exists('physicianClassActive')) {

    /**
     * Setting active menu class
     * 
     * @return string
     *    
     */
    function physicianClassActive()
    {
        if (
            Request::is('physician/questionSet') ||
            Request::is('physician/questionSetPreview/*') ||
            Request::is('physician/question-set-detail/*') ||
            Request::is('physician/createQuestionSet') ||
            Request::is('physician/createQuestionSetNext/*') ||
            Request::is('physician/sendQuestionSet/*') ||
            Request::is('physician/home')) {
            return 'menu_question_set';
        }
        if (
            Request::is('physician/patients') ||
            Request::is('physician/viewMedicalRecord/*') ||
            Request::is('physician/patients/*')
        ) {
            return 'menu_patients';
        }
        if (
            Request::is('physician/adminstaff/*') ||
            Request::is('physician/adminstaff')) {
            return 'menu_adminstaff';
        }
        if (
            Request::is('physician/listNotifications')) {
            return 'menu_notifications';
        }
        if (
            Request::is('physician/profile')) {
            return 'menu_profile';
        }
        if (
            Request::is('physician/subscription')) {
            return 'menu_subscription';
        }
    }
}
/**
 * 	Physician Helper  
 */
if (!function_exists('convertDateToMMDDYYYY')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function convertDateToMMDDYYYY($date)
    {
        return date("m/d/Y", strtotime($date));
    }
}
/**
 *  Physician Helper  
 */
if (!function_exists('subscribed')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function subscribed()
    {
        if (\Auth::user()->user_role == 'S') {
            // if (Auth::user()->is_subscribed == 'N')
            //     return false;
            // else 
                return \Auth::user()->isParentIsSubscribed();
                
        } elseif (\Auth::user()->user_role == 'D') {  // check if parent is authorized          
            return \Auth::user()->isSubscribed();
        }
    }
}
/**
 *  Physician Helper  
 */
if (!function_exists('splitContactNumber')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function splitContactNumber($contact, $type = 'number')
    {
        $contact = ltrim($contact, '+');
        $code    =  $res =  "";
        $number  = $contact;
        if ($contact) {
            if (str_contains($contact, '-')) {
                list($code, $number) = explode('-', $contact);
            }
            $res = $$type;
        }
        return ($res) ? $res : null;
    }
}
/**
 *  Physician Helper  
 */
if (!function_exists('extractRequiredColumn')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function extractRequiredColumn($inputData, $requiredColumn)
    {
        $returnData = array();
        if (count($inputData) > 0) {
            $inputData = $inputData->toArray();
            for ($i = 0; $i < count($inputData); $i++) {
                $returnData[] = $inputData[$i][$requiredColumn];
            }
        }
        return $returnData;
    }
}

/**
 *  Physician Helper  
 */
if (!function_exists('formatData')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function formatData($patientStatus, $entryType, $textType, $inputData)
    {
        $invalid = '-';
        if ($patientStatus == 'P') {
            if ($textType == 'text')
                $inputData = trans("Physician::messages.span_registration_pending");
            else if ($textType == 'phone') {
                if ($entryType == 'T')
                    $inputData = $inputData;
                else
                    $inputData = $invalid;
            }
            else if ($textType == 'email') {
                if ($entryType == 'E')
                    $inputData = $inputData;
                else
                    $inputData = $invalid;
            } else
                $inputData = $invalid;
        } else {
            if ($textType == 'gender') {
                if ('M' == $inputData)
                    $inputData = 'Male';
                else
                    $inputData = 'Female';
            }
            return $inputData;
        }
        return $inputData;
    }
}