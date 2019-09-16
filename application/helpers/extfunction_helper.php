<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function GET_LANG() {
    $CI = get_instance();

    if(GET_COMPANY('multilanguage') == 'Y') {
        $GET_LANG = $CI->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
    } else {
        $GET_LANG = $CI->db->query("SELECT * FROM cd_language WHERE language_default = 'Y'");
    }
    
    return $GET_LANG;
}

function SET_LANG($language = '') {
    $CI = get_instance();
    
    $SESSION_MEMBER	        = $CI->session->userdata('LANGUAGE_FI');
    $GET_DEFAULT_LANG       = $CI->db->get_where('cd_language', array('language_default' => 'Y'));

    if ($language == '') {
        if($CI->session->userdata('LANGUAGE_FI') == FALSE) {
            $LANG['code']           = $GET_DEFAULT_LANG->row()->language_code;
            $LANG['name']           = $GET_DEFAULT_LANG->row()->language_name;
        } else {
            $LANG['code']           = $SESSION_MEMBER['code'];
            $LANG['name']           = $SESSION_MEMBER['name'];
        }
    } else {
        $check_language     = $CI->db->get_where('cd_language', array('language_code' => $language, 'language_status' => 'Y'));
        
        if ($check_language->num_rows() > 0) {
            $LANG['code']           = $check_language->row()->language_code;
            $LANG['name']           = $check_language->row()->language_name;
        } else {
            $LANG['code']           = $GET_DEFAULT_LANG->row()->language_code;
            $LANG['name']           = $GET_DEFAULT_LANG->row()->language_name;
        }
    }
    
    $CI->session->set_userdata('LANGUAGE_FI', $LANG); 
}

function GET_CURRENT_LANG() {
    $CI = get_instance();
    $GET_DEFAULT_LANG       = $CI->db->get_where('cd_language', array('language_default' => 'Y'));
    
    if ($CI->session->userdata('LANGUAGE_FI') == FALSE) {
        $LANG['code']               = $GET_DEFAULT_LANG->row()->language_code;
        $LANG['name']               = $GET_DEFAULT_LANG->row()->language_name;
    } else {
        $LANG                       = $CI->session->userdata('LANGUAGE_FI');
    }
    
    return $LANG;
}

function GET_LANG_FLAG($code) {
    $CI = get_instance();
    
    $GET_LANG   = $CI->db->query("SELECT * FROM cd_language WHERE language_code = '".$code."'")->row();
    
    $LANG_FLAG  = $GET_LANG->language_flag;
    
    //var_dump($LANG_FLAG);
    
    return $LANG_FLAG;
}

function GET_CURRENCY() {
    $CI = get_instance();

    $GET_CURRENCY = $CI->db->query("SELECT * FROM cd_currency WHERE currency_status = 'Y'");
    
    return $GET_CURRENCY;
}

function SET_CURRENCY($CURR = '') {
    $CI = get_instance();
    
    $get_default_currency    = $CI->db->get_where('cd_currency', array('currency_status' => 'Y', 'currency_default' => 'Y'))->row();
    
    if ($CURR == '') {
        if ( $CI->session->userdata('currency') == FALSE ) {
            $currency['code']           = $get_default_currency->currency_code;
            $currency['name']           = $get_default_currency->currency_name;
            
            $CI->session->set_userdata('currency', $currency);
        }
    } else {
        $check_currency      = $CI->db->get_where('cd_currency', array('currency_code' => $CURR, 'currency_status' => 'Y'));
        
        if ($check_currency->num_rows() > 0) {
            $currency['code']           = $check_currency->row()->currency_code;
            $currency['name']           = $check_currency->row()->currency_name;
            
            $CI->session->set_userdata('currency', $currency);
        }
    }
}

function GET_CURRENT_CURRENCY() {
    $CI = get_instance();
    
    $get_default_currency    = $CI->db->get_where('cd_currency', array('currency_status' => 'Y', 'currency_default' => 'Y'))->row();
    
    if ( $CI->session->userdata('currency') == FALSE ) {
        $currency['code']           = $get_default_currency->currency_code;
        $currency['name']           = $get_default_currency->currency_name;
    } else {
        $currency                   = $CI->session->userdata('currency');
    }
    
    return $currency;
}

function getDateTime() {
    
    $DATE_FORMAT = "%Y-%m-%d %H:%i:%s";
	$TIME        = time();

    return mdate($DATE_FORMAT, $TIME);
    
}

function GET_COMPANY($FLAG, $LANG = '') {
    
    $CI = get_instance();
    
    if ($LANG == '') {
        $CMD_CAPT   = $CI->db->get_where('cd_company', array('company_tags' => $FLAG));
    } else {
        $CMD_CAPT   = $CI->db->get_where('cd_company', array('company_tags' => $FLAG, 'company_lang' => $LANG));
    }
    
    if($CMD_CAPT->num_rows() > 0) {
        $CAPTION    = $CMD_CAPT->row()->company_caption;
        return $CAPTION;
    } else {
        return $FLAG;
    }
    
}

function GET_GENERAL($FLAG) {
    
    $CI = get_instance();
    
        $CMD_CAPT   = $CI->db->get_where('cd_general', array('general_tags' => $FLAG));
    
    if($CMD_CAPT->num_rows() > 0) {
        $CAPTION    = $CMD_CAPT->row()->general_caption;
        return $CAPTION;
    } else {
        return $FLAG;
        
    }
    
}

function GET_LABEL($FLAG, $LANG = '') {
    
    $CI = get_instance();
    /** if(GET_SETTING('multilanguage') == 'Y') {
        $LANG       = $CI->session->userdata('LANGUAGE');
    } else {
        $LANG       = $CI->db->get_where('cd_language', array('language_default' => 'Y'))->row()->language_code;
    } */

    $CMD_CAPT   = $CI->db->get_where('cd_label', array('label_flag' => $FLAG, 'label_lang' => $LANG));
    
    if($CMD_CAPT->num_rows() > 0) {
        $CAPTION    = $CMD_CAPT->row()->label_caption;
        return $CAPTION;
    } else {
        return $FLAG;
        
    }
    
}


function GET_DEFAULT_LANG() {
    
    $CI = get_instance();
    
    $CMD_CAPT   = $CI->db->get_where('cd_language', array('language_default' => 'Y'));
    if($CMD_CAPT->num_rows() > 0) {
        $CAPTION    = $CMD_CAPT->row()->language_code;
        return $CAPTION;
        
    } else {
        return $FLAG;
        
    }
    
}

function sendEmail($NICKNAME, $SENDER, $EMAIL_TO, $SUBJECT, $CONTENT, $EMAIL_CC = '', $EMAIL_BCC = '') {

	$CI =& get_instance();
	$CI->load->library('email');
    
	$config['mailtype']		= 'html';
	$config['charset'] 		= 'iso-8859-1';
	$config['wordwrap'] 	= TRUE;
	$CI->email->initialize($config);

	$CI->email->from($SENDER, $NICKNAME);
	$CI->email->to($EMAIL_TO);
    if ( $EMAIL_CC != '' ) {
	   $CI->email->cc($EMAIL_CC);
    }
    if ( $EMAIL_BCC != '' ) {
	   $CI->email->bcc($EMAIL_BCC);
    }

	$CI->email->subject($SUBJECT);
	$CI->email->message($CONTENT);

	$CI->email->send();
}

function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
        $time1 = strtotime($time1);
    }
    
    if (!is_int($time2)) {
        $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
    }
    
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
        // Create temp time from time1 and interval
        $ttime = strtotime('+1 ' . $interval, $time1);
        // Set initial values
        $add = 1;
        $looped = 0;
        
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
            // Create new temp time from time1 and interval
            $add++;
            $ttime = strtotime("+" . $add . " " . $interval, $time1);
            $looped++;
        }
        
        $time1 = strtotime("+" . $looped . " " . $interval, $time1);
        $diffs[$interval] = $looped;
    }
    
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
            break;
        }
        
        // Add value and interval 
        // if value is bigger than 0
        if ($value > 0) {
            // Add s if value is not 1
            if ($value != 1) {
                $interval .= "s";
            }
            
            // Add value and interval to times array
            $times[] = $value . " " . $interval;
            $count++;
        }
    }
 
    // Return string with times
    return implode(", ", $times);
}