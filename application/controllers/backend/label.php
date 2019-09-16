<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Label extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_LABEL';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Label';
            
            $data['content']         = 'label/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->get_where("cd_label", array('label_lang' => GET_DEFAULT_LANG()));
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
            
            $data['STR_PAGES']       = 'PAGE_LABEL_ADDNEW';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Add New';
            $data['content']         = 'label/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['label_lock_code']      = getRandom(15, 15);
            $GET_LANG = GET_LANG();
            foreach($GET_LANG->result() as $rsLang):
                $data['label_flag']       = trim(strip_tags($this->input->post('label_flag_'.$rsLang->language_code)));
                $data['label_caption']    = trim(strip_tags($this->input->post('label_caption_'.$rsLang->language_code)));
                $data['label_lang']       = $rsLang->language_code;

                //- SAVE DATA
                $this->db->insert('cd_label', $data); 
            
            endforeach;
            
            //- REDIRECT
            redirect(base_url('jpanel/label'));
            
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }  
	
	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_LABEL_EDIT';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Edit Label';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'label/edit.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    public function updated($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = GET_LANG();
            foreach($GET_LANG->result() as $rsLang):
                $data['label_flag']       = trim(strip_tags($this->input->post('label_flag_'.$rsLang->language_code)));
                $data['label_caption']    = trim(strip_tags($this->input->post('label_caption_'.$rsLang->language_code)));
                $data['label_lang']       = $rsLang->language_code;

                $CHECK_LABEL = $this->db->get_where('cd_label', array('label_lock_code' => $LOCK_CODE, 'label_lang' => $rsLang->language_code));
                if ($CHECK_LABEL->num_rows() > 0) {
                    //- UPDATE DATA
                    $this->db->where('label_lock_code', $LOCK_CODE);
                    $this->db->where('label_lang', $rsLang->language_code);
                    $this->db->update('cd_label', $data); 
                } else {
                    //- SAVE DATA
                    $data['label_lock_code']    = $LOCK_CODE;
                    $this->db->insert('cd_label', $data);
                }
            
            endforeach;
            
            //- REDIRECT
            redirect(base_url('jpanel/label'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
	
	public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            $this->db->delete('cd_label', array('label_lock_code' => $LOCK_CODE)); 
            echo "success";
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function trashSelected() {
		if($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data = json_decode(stripslashes($_POST['data']));
            foreach($data as $d){
                $ID_CODE    = $d;
                $query      = $this->db->delete('cd_label', array('label_lock_code' => $ID_CODE)); 
            }
            
            if($query == TRUE) {
                echo "success";
            } else {
                echo "error";
            }
            
		} else {
			$this->load->view('backend/FormLogin');
		}
	}
            
    
}