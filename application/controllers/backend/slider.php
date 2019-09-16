<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_SLIDER';
            $data['STR_MENU']        = 'Slider';
            $data['TITLE_PAGE']      = 'Slider';
            $data['content']         = 'slider/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_posts WHERE posts_type = 'slider' AND posts_locked = 'N' AND posts_lang = '".GET_DEFAULT_LANG()."' GROUP BY posts_lock_code ORDER BY posts_sort ASC");
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
            
            $data['STR_PAGES']       = 'PAGE_SLIDER_ADDNEW';
            $data['STR_MENU']        = 'Slider';
            $data['TITLE_PAGE']      = 'Add New';
            $data['content']         = 'slider/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();
            
            if($this->input->post('posts_status') == TRUE) {
                $data['posts_status']       = 'Y';
            } else {
                $data['posts_status']       = 'N';
            }

            $data['posts_modified']         = getDateTime();
            $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
            $data['posts_type']             = 'slider';
            $data['posts_locked']           = 'N';
            $data['posts_visibility']       = 'P';
            $data['posts_lock_code']        = getRandom(15, 15);
            
            //UPLOAD IMAGES
            $data['posts_images']           = '';
            $upload_image                   = upload_image('posts_images', GET_GENERAL('slider_width'), GET_GENERAL('slider_height'));
            if ($upload_image != NULL) { $data['posts_images'] = $upload_image; }
            
            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'cd_posts')) {
                        $data[$field]     = $val;
                    }
                endforeach;
                $data['posts_lang']       = $LANG->language_code;
                
                $this->db->insert('cd_posts', $data); 
            endforeach;
            
            //- REDIRECT
            redirect(base_url('jpanel/slider'));
            
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
	
	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_SLIDER_ADDNEW';
            $data['STR_MENU']        = 'Slider';
            $data['TITLE_PAGE']      = 'Edit Slider';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'slider/edit.php';
            $data['SELECTED']        = $this->db->get_where('cd_posts', array('posts_lock_code' => $LOCK_CODE, "posts_lang" => GET_DEFAULT_LANG()));
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function updated($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            //UPLOAD IMAGES
            $data['posts_images']           = trim(strip_tags($this->input->post('posts_images_temp')));
            if ( $this->input->post('posts_images') != false ) {
                $upload_image                   = upload_image('posts_images', GET_GENERAL('slider_width'), GET_GENERAL('slider_height'));
                if ($upload_image != NULL || $upload_image != '') { $data['posts_images'] = $upload_image; }
            }

            if($this->input->post('posts_status') == TRUE) {
                $data['posts_status']       = 'Y';
            } else {
                $data['posts_status']       = 'N';
            }

            $GET_LANG = GET_LANG();
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
            redirect(base_url('jpanel/slider'));
            
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
	
	public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            
            //-GET DATA
            $GET_FILENAME = $this->db->get_where("cd_posts", array("posts_lock_code" => $LOCK_CODE));
            $IMG_COVER = $GET_FILENAME->row()->posts_images;
            
            //-DELETE FILE
            $TFILENAME = './pubs/uploads/'.$IMG_COVER;
            if(file_exists($TFILENAME)) {
                unlink($TFILENAME);
            } 
            
            //DELETE
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
                
                //-GET DATA
                $GET_FILENAME = $this->db->get_where("cd_posts", array("posts_lock_code" => $ID_CODE));
                $IMG_COVER = $GET_FILENAME->row()->posts_images;

                //-DELETE FILE
                $TFILENAME = './pubs/uploads/'.$IMG_COVER;
                if(file_exists($TFILENAME)) {
                    unlink($TFILENAME);
                } 
                
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