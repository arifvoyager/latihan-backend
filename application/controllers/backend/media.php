<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        $this->load->model('mod_getdata');
        $this->load->model('mod_update');
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MEDIA';
            $data['STR_MENU']        = 'Media';
            $data['TITLE_PAGE']      = 'Media';
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
}