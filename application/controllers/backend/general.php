<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_GENERAL';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'General Setting';
            $data['content']         = 'general/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_general GROUP BY general_lock_code");
            $strArray = array();
			foreach($GET_LANG->result() as $strObj) {
				$strArray[] = $strObj;
			}
				
			echo json_encode($strArray);
            
        } else {
            echo "Error load data";       
        }
    }
    
	public function addnew() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_GENERAL';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'General Setting';
            $data['content']         = 'general/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['general_lock_code']        = getRandom(15, 15);
            if ($this->input->post('general_multilanguage') == 'Y') {
                $GET_LANG = GET_LANG();
                
                foreach ($GET_LANG->result() as $LANG):
                    foreach ($this->input->post() as $key=>$val):
                        $field = (str_replace('_'.$LANG->language_code, '', $key));
                        if ($this->db->field_exists($field, 'cd_general')) {
                            $data[$field]     = $val;
                        }
                    endforeach;

                    $this->db->insert('cd_general', $data);
                endforeach;
            } else {
                foreach ($this->input->post() as $key=>$val):
                    if ($this->db->field_exists($key, 'cd_general')) {
                        $data[$key]     = $val;
                    }
                endforeach;

                $this->db->insert('cd_general', $data);
            }
            
            //Direct
            redirect('jpanel/general');
            
        } else {
            $this->load->view('backend/FormLogin');
        } 
    }

	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_GENERAL';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'General Setting';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'general/edit.php';
            $data['SELECTED']        = $this->db->get_where('cd_general', array('general_lock_code' => $LOCK_CODE));
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    public function updated($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();
                 
            if ($this->input->post('general_multilanguage') == 'Y') {
                foreach ($GET_LANG->result() as $LANG):
                    foreach ($this->input->post() as $key=>$val):
                        $field = (str_replace('_'.$LANG->language_code, '', $key));
                        if ($this->db->field_exists($field, 'cd_general')) {
                            $data[$field]     = $val;
                        }
                    endforeach;

                    $CHECK_POSTS        = $this->db->get_where('cd_general', array('general_lang' => $LANG->language_code, 'general_lock_code' => $LOCK_CODE));
                    if ($CHECK_POSTS->num_rows() > 0) {
                        //- UPDATE DATA
                        $this->db->where('general_lock_code', $LOCK_CODE);
                        $this->db->where('general_lang', $LANG->language_code);
                        $this->db->update('cd_general', $data); 
                    } else {
                        //- SAVE DATA
                        $data['general_lock_code']    = $LOCK_CODE;
                        $this->db->insert('cd_general', $data);
                    }
                endforeach;
            } else {
                foreach ($this->input->post() as $key=>$val):
                    if ($this->db->field_exists($key, 'cd_general')) {
                        $data[$key]     = $val;
                    }
                
                    $this->db->where('general_lock_code', $LOCK_CODE);
                    $this->db->update('cd_general', $data); 
                endforeach;
            }

            //- REDIRECT
            redirect(base_url('cms/general'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }    
}