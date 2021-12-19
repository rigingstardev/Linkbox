<?php

/**
 * 	Patient Helper  
 */
if (!function_exists('strReplaceCC')) {

    /**
     * String to Replace CC
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function strReplaceCC($question, $replaceStr = null) {

        if (str_contains($question, '[CC]')) {
            $question = str_replace("[CC]", $replaceStr, $question);
        }
        return $question;
    }

}
/**
 *  Patient Helper  
 */
if (!function_exists('getAnswersAsString')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function getAnswersAsString($ansArray) {
        $str = $ansArray;
        if(is_array($ansArray)) {           
            $str = implode(',', $ansArray);           
        }
        if( "" == str_replace(',', '', $str))
            return "___";

        return '<span class="txt-blue">'.$str.'</span>';
    }

}
/**
 *  Physician Helper  
 */
if (!function_exists('formatSummary')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function formatSummary($question,$answer = null) {

        
        //getAnswersAsString($answer);
        if (str_contains($question, '[X]')) {
            $question = str_replace("[X]", $answer, $question);
        }
        
        return $question;
        //return '<span class="txt-blue">'.$str.'</span>';
    }

}
/**
 *  Physician Helper  
 */
if (!function_exists('formatSummaryOptions')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function formatSummaryOptions($summary,$replaceData) {
     
        $name = $replaceData['name'];
        $age = 0;
        if($replaceData['dob']) {
            $age = Carbon\Carbon::parse($replaceData['dob'])->diff(Carbon\Carbon::now())->format('%y');
        }
        $array_to_replace   =  array('[name]','[Name]','[NAME]','[age]','[Age]','[AGE]');
        $array_with_replace =  array($name,$name,$name,$age,$age,$age);   
        $summary = str_replace($array_to_replace, $array_with_replace, $summary);
        return $summary;        
    }

}
/**
 *  Physician Helper  
 */
if (!function_exists('formatGender')) {

    /**
     * String value of Summary
     *
     * @param  string   $summary    
     * @param  string   $gender    
     * @return string
     *    
     */
    function formatGender($summary,$patGender = 'M') {          

        $subject = ($patGender == 'M') ? 'He' : 'She';
        $subjectSmall  = ($patGender == 'M') ? 'he' : 'she';
        $possessive  = ($patGender == 'M') ? 'His' : 'Her';
        $possessiveSmall  = ($patGender == 'M') ? 'his' : 'her'; 
        $pronounce = ($patGender == 'M') ? 'Mr.' : 'Mrs.';
        $gender = ($patGender == 'M') ? 'Male' : 'Female';
        $genderSmall = ($patGender == 'M') ? 'male' : 'female';
        $himorher =  ($patGender == 'M') ? 'Him' : " Her";
        $himorherSmall =  ($patGender == 'M') ? 'him' : 'her';   

        $trans = [          
            '[He/She]'      =>  $subject, 
            '[HE/SHE]'      =>  $subject,
            '[He / She]'    =>  $subject,
            '[His/Her]'     =>  $possessive,
            '[His / Her]'   =>  $possessive,
            '[HIS/HER]'     =>  $possessive,
            '[His /Her]'    =>  $possessive,
            '[His/ Her]'    =>  $possessive,
            '[he/she]'      =>  $subjectSmall,
            '[his/her]'     =>  $possessiveSmall,
            '[his / her]'   =>  $possessiveSmall,
            '[his/ her]'    =>  $possessiveSmall,
            '[his /her]'    =>  $possessiveSmall,
            '[Mr/Mrs]'      =>  $pronounce,
            '[Mr/ Mrs]'     =>  $pronounce,
            '[Mr /Mrs]'     =>  $pronounce,
            '[Mr / Mrs]'    =>  $pronounce,
            '[MR/MRS]'      =>  $pronounce,
            '[Male/Female]' =>  $gender,
            '[MALE/FEMALE]' =>  $gender,
            '[Male /Female]' =>  $gender,
            '[Male/ Female]' =>  $gender,
            '[male/female]' =>  $genderSmall,           
            '[Him/Her]'     =>  $himorher,
            '[him/her]'     =>  $himorherSmall

        ];   
        $summary = strtr($summary,$trans);         
        return $summary;       
    }
}
/**
 * 	Physician Helper  
 */
if (!function_exists('patientClassActive')) {

    /**
     * Setting active menu class
     * 
     * @return string
     *    
     */
    function patientClassActive() {
        if (
                Request::is('patient/questions') ||
                Request::is('patient/questions/*') ||
                Request::is('patient')) {
            return 'menu_question_set';
        }
        if (
                Request::is('patient/profile')) {
            return 'menu_profile';
        }
        if (
                Request::is('patient/medicalRecords')) {
            return 'menu_medical_records';
        }
        if (
                Request::is('patient/notifications')) {
            return 'menu_notifications';
        }
    }

}

/**
 *  Physician Helper for Test Preview
 */
if (!function_exists('formatTestPreviewGender')) {

    /**
     * String value of Summary
     *
     * @param  string   $summary    
     * @param  string   $gender    
     * @return string
     *    
     */
    function formatTestPreviewGender($summary,$patGender = 'M') {          

        $subject = ($patGender == 'M') ? 'He' : 'She';
        $subjectSmall  = ($patGender == 'M') ? 'he' : 'she';
        $possessive  = ($patGender == 'M') ? 'His' : 'Her';
        $possessiveSmall  = ($patGender == 'M') ? 'his' : 'her'; 
        $pronounce = ($patGender == 'M') ? '' : '';
        $gender = ($patGender == 'M') ? 'Male' : 'Female';
        $genderSmall = ($patGender == 'M') ? 'male' : 'female';
        $himorher =  ($patGender == 'M') ? 'Him' : " Her";
        $himorherSmall =  ($patGender == 'M') ? 'him' : 'her';   

        $trans = [          
            '[He/She]'      =>  $subject, 
            '[HE/SHE]'      =>  $subject,
            '[He / She]'    =>  $subject,
            '[His/Her]'     =>  $possessive,
            '[His / Her]'   =>  $possessive,
            '[HIS/HER]'     =>  $possessive,
            '[His /Her]'    =>  $possessive,
            '[His/ Her]'    =>  $possessive,
            '[he/she]'      =>  $subjectSmall,
            '[his/her]'     =>  $possessiveSmall,
            '[his / her]'   =>  $possessiveSmall,
            '[his/ her]'    =>  $possessiveSmall,
            '[his /her]'    =>  $possessiveSmall,
            '[Mr/Mrs]'      =>  $pronounce,
            '[Mr/ Mrs]'     =>  $pronounce,
            '[Mr /Mrs]'     =>  $pronounce,
            '[Mr / Mrs]'    =>  $pronounce,
            '[MR/MRS]'      =>  $pronounce,
            '[Male/Female]' =>  $gender,
            '[MALE/FEMALE]' =>  $gender,
            '[Male /Female]' =>  $gender,
            '[Male/ Female]' =>  $gender,
            '[male/female]' =>  $genderSmall,           
            '[Him/Her]'     =>  $himorher,
            '[him/her]'     =>  $himorherSmall

        ];   
        $summary = strtr($summary,$trans);         
        return $summary;       
    }
}
/**
 *  Physician Helper for Test Preview Summary  
 */
if (!function_exists('formatTestPreviewSummaryOptions')) {

    /**
     * String value of Permission
     *
     * @param  string   $permissions    
     * @return string
     *    
     */
    function formatTestPreviewSummaryOptions($summary,$replaceData) {
     
        $name               = $replaceData['name'];
        $age                = $replaceData['age'];
        $array_to_replace   =  array('[name]','[Name]','[NAME]','[age]','[Age]','[AGE]');
        $array_with_replace =  array($name,$name,$name,$age,$age,$age);   
        $summary            = str_replace($array_to_replace, $array_with_replace, $summary);
        return $summary;        
    }

}
