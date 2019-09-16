<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inbox extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_INBOX';
            $data['STR_MENU']        = 'Inbox';
            $data['TITLE_PAGE']      = 'Inbox';
            $data['content']         = 'inbox/data.php';
            
            //SET READ ALL IF OPEN
            $update['contact_status'] = 'R';
            $this->db->update('cd_message', $update);
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
	
	public function pages() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_INBOX';
            $data['STR_MENU']        = 'Inbox';
            $data['TITLE_PAGE']      = 'Inbox';
            
            //SET READ ALL IF OPEN
            $update['contact_status'] = 'R';
            $this->db->update('cd_message', $update);
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            $this->db->delete('cd_message', array('contact_uid' => $LOCK_CODE)); 
            echo "success";
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
}