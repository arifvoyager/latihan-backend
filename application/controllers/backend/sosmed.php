<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sosmed extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_SOSMED';
            $data['STR_MENU']        = 'sosmed';
            $data['TITLE_PAGE']      = 'Sosial Media';
            
            $data['sosmed']          = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'social_media'));
            
            $data['content']         = 'sosmed/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            foreach ($this->input->post() as $key=>$val):
                $slug = (str_replace('taxonomy_value_', '', $key));

                $data['taxonomy_value']      = $val;
            
                $this->db->where('taxonomy_flags', 'social_media');
                $this->db->where('taxonomy_slug', $slug);
                $this->db->update('cd_taxonomy', $data); 
            endforeach;
                
            //Direct
            redirect('cms/sosmed');
            
        } else {
            $this->load->view('backend/FormLogin');
        } 
    }
    
}