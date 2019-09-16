<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lang extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_LANGUAGE';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Language';
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->get('cd_language');
            $strArray = array();
			foreach($GET_LANG->result() as $strObj) {
				$strArray[] = $strObj;
			}
				
			echo json_encode($strArray);
            
        } else {
            echo "Error load data";       
        }
    }
    
    public function setStatus() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $UID    = $this->input->post('UID');
            $STATUS = $this->input->post('STATUS');
            
            if($STATUS == 'Y') {
                $data['language_status']  = 'N';  
                
            } else {
                $data['language_status']  = 'Y'; 
                
            }
            
            $this->db->update('cd_language', $data, array('language_uid' => $UID));
            echo "success";  
            
        } else {
            echo "Failed";       
        }
    }
    
    public function setDefault() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $UID    = $this->input->post('UID');
            $DEFAULT = $this->input->post('DEFAULT');
            
            $data['language_default']  = 'Y'; 
            $this->db->query("UPDATE cd_language SET language_default = 'N'");
            
            $this->db->update('cd_language', $data, array('language_uid' => $UID));
            echo "success";  
            
        } else {
            echo "Failed";       
        }
    }   
    
}