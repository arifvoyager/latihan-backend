<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mitra_cat extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MITRA_CAT';
            $data['STR_MENU']        = 'mitra';
            $data['TITLE_PAGE']      = 'Mitra';
            $data['content']         = 'mitra/categories/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_taxonomy A WHERE taxonomy_flags = 'mitra_cat' AND taxonomy_lang = '".GET_DEFAULT_LANG()."' GROUP BY taxonomy_lock_code ORDER BY taxonomy_value DESC");
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
            
            $data['STR_PAGES']       = 'PAGE_MITRA_CAT';
            $data['STR_MENU']        = 'mitra';
            $data['TITLE_PAGE']      = 'Add New';
            $data['content']         = 'mitra/categories/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();

            $data['taxonomy_flags']         = 'mitra_cat';
            $data['taxonomy_lock_code']     = getRandom(15, 15);
            

            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'cd_taxonomy')) {
                        $data[$field]     = $val;
                    }
                endforeach;
                            
                $this->db->insert('cd_taxonomy', $data); 
            endforeach;

            //- REDIRECT
            redirect(base_url('cms/mitra_cat'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }  
	
	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MITRA_CAT';
            $data['STR_MENU']        = 'mitra';
            $data['TITLE_PAGE']      = 'Edit News';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'mitra_cat/edit.php';
            $data['SELECTED']        = $this->db->get_where('cd_posts', array('posts_lock_code' => $LOCK_CODE));
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    public function updated($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();
            
            if($this->input->post('posts_status') == TRUE) {
                $data['posts_status']       = 'Y';
            } else {
                $data['posts_status']       = 'N';
            }
            
            $data['posts_modified']         = getDateTime();

            //UPLOAD IMAGES
            $data['posts_images'] = trim(strip_tags($this->input->post('posts_images_temp')));
            
            if ($_FILES['posts_images']['error'] == 0) {
                $upload_image = upload_image('posts_images');

                if ($upload_image != NULL || $upload_image != '') { $data['posts_images'] = $upload_image; }
            }
            
            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'cd_posts')) {
                        $data[$field]     = $val;
                    }
                endforeach;
                
                $CHECK_POSTS        = $this->db->get_where('cd_posts', array('posts_lang' => $LANG->language_code, 'posts_lock_code' => $LOCK_CODE));
                if ($CHECK_POSTS->num_rows() > 0) {
                    //- UPDATE DATA
                    $this->db->where('posts_lock_code', $LOCK_CODE);
                    $this->db->where('posts_lang', $LANG->language_code);
                    $this->db->update('cd_posts', $data); 
                } else {
                    //- SAVE DATA
                    $data['posts_lock_code']    = $LOCK_CODE;
                    $this->db->insert('cd_posts', $data);
                }

            endforeach;

            //- REDIRECT
            redirect(base_url('cms/mitra_cat'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
	
	public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            $this->db->delete('cd_posts', array('posts_lock_code' => $LOCK_CODE)); 
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
                $query      = $this->db->delete('cd_posts', array('posts_lock_code' => $ID_CODE)); 
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