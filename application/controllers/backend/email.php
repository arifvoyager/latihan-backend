<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_EMAIL';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Email';
            $data['content']         = 'email/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_email WHERE email_status = 'Y' AND email_lang = '".GET_DEFAULT_LANG()."' ORDER BY email_uid ASC");
            $strArray = array();
			foreach($GET_LANG->result() as $strObj) {
				$strArray[] = $strObj;
			}
				
			echo json_encode($strArray);
            
        } else {
            echo "Error load data";       
        }
    }
    
    public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_EMAIL_EDIT';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Edit Email';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['SELECTED']    = $this->db->get_where('cd_email', array('email_lock_code' => $LOCK_CODE));
            
            $data['content']         = 'email/edit.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    public function updated($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();
            
            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'cd_email')) {
                        $data[$field]     = $val;
                    }
                endforeach;
                
                //- UPDATE DATA
                $this->db->where('email_lock_code', $LOCK_CODE);
                $this->db->where('email_lang', $LANG->language_code);
                $this->db->update('cd_email', $data); 
            endforeach;
            
            //- REDIRECT
            redirect(base_url('cms/email'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    
}