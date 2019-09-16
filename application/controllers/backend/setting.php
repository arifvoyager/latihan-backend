<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_SETTING';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Company';
            $data['content']         = 'setting/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            //Update field
            foreach ($_POST as $name => $val) {
                $data['company_caption'] = trim($val);
                $this->db->where('company_tags', $name);
                $this->db->update('cd_company', $data);
            }
            
            //Update logo
            $logo['company_caption']         = $this->input->post('company_logo_temp');
            $this->load->library('upload');
            if($_FILES['company_logo']['error'] == 0) {
                //upload and update the file
                $config['upload_path'] 			= './pubs/uploads/';
                $config['allowed_types'] 		= 'png|jpg|jpeg|gif|bmp';
                $config['overwrite'] 			= false;
                $config['remove_spaces'] 		= true;
                $config['max_size']				= '5000';// in KB

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('company_logo')) {
                    echo $this->upload->display_errors();
                    
                } else {
                    $logo['company_caption']    = $this->upload->file_name;
                }
            }
            
            $this->db->where('company_tags', 'company_logo');
            $this->db->update('cd_company', $logo);
            
            //Direct
            redirect('jpanel/setting');
            
        } else {
            $this->load->view('backend/FormLogin');
        } 
    }
    
}