<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_DOWNLOAD';
            $data['STR_MENU']        = 'download';
            $data['TITLE_PAGE']      = 'Article';
            $data['content']         = 'download/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_posts A WHERE posts_type = 'download' AND posts_lang = '".GET_DEFAULT_LANG()."' GROUP BY posts_lock_code ORDER BY posts_date DESC");
            $strArray = array();
			foreach($GET_LANG->result() as $strObj) {
                if ($strObj->posts_visibility == 'M') {
                    $strObj->posts_visibility = 'Only Member';
                } elseif ($strObj->posts_visibility == 'P') {
                    $strObj->posts_visibility = 'Public';
                }
                
                if ($strObj->posts_locked == 'Y') {
                    $strObj->posts_locked = 'Yes';
                } elseif ($strObj->posts_locked == 'N') {
                    $strObj->posts_locked = 'No';
                }
				$strArray[] = $strObj;
			}
				
			echo json_encode($strArray);
            
        } else {
            echo "Error load data";       
        }
    }
	
	public function addnew() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_DOWNLOAD_ADDNEW';
            $data['STR_MENU']        = 'download';
            $data['TITLE_PAGE']      = 'Add New Article';
            $data['content']         = 'download/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();

            $data['posts_modified']         = getDateTime();
            $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
            $data['posts_type']             = 'download';
            $data['posts_lock_code']        = getRandom(15, 15);
            
            //UPLOAD IMAGES
            $data['posts_images']           = '';
            $this->load->library('upload');
            if($_FILES['posts_images']['error'] == 0) {
                //upload and update the file
                $config['upload_path'] 			= './pubs/uploads/images/';
                $config['allowed_types'] 		= 'png|jpg|jpeg|gif|bmp';
                $config['overwrite'] 			= false;
                $config['remove_spaces'] 		= true;
                $config['encrypt_name'] 		= true;
                $config['max_size']				= '5000';// in KB

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('posts_images')) {
                    echo $this->upload->display_errors();

                } else {

                    //Image Resizing
                    $cover['source_image'] 	    = $this->upload->upload_path.$this->upload->file_name;
                    $cover['maintain_ratio'] 	= FALSE;
                    
                    $this->load->library('image_lib', $cover);
                    if (!$this->image_lib->resize()) {
                        echo $this->upload->display_errors();

                    } else {
                        $data['posts_images']    = $this->upload->file_name;
                    }
                }
            }

            //UPLOAD FILE PDF
            $this->load->library('upload');
            $data['posts_file']    = '';
            if($_FILES['posts_file']['error'] == 0) {
                $config2['upload_path']         = './pubs/file/';
                $config2['allowed_types']       = 'pdf|xls|xlsx|doc|docx';
                $config2['encrypt_name'] 		= false;
                $this->upload->initialize($config2);
                if (!$this->upload->do_upload('posts_file')) {
                    echo $this->upload->display_errors();
                } else {
                    $data['posts_file']    = $this->upload->file_name;
                }
            }
            
            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'cd_posts')) {
                        $data[$field]     = $val;
                    }
                endforeach;
            
                if ($this->input->post('posts_visibility') == true) {
                    $data['posts_visibility']       = 'P';
                } else {
                    $data['posts_visibility']       = 'M';
                }

                if ($this->input->post('posts_locked') == true) {
                    $data['posts_locked']       = 'Y';
                } else {
                    $data['posts_locked']       = 'N';
                }
            
                $this->db->insert('cd_posts', $data); 
            endforeach;

            //- REDIRECT
            redirect(base_url('cms/download'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }  
	
	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_DOWNLOAD_ADDNEW';
            $data['STR_MENU']        = 'download';
            $data['TITLE_PAGE']      = 'Edit Article';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'download/edit.php';
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
            $data['posts_images']           = trim(strip_tags($this->input->post('posts_images_temp')));
            if ($_FILES['posts_images']['error'] == 0) {
                $this->load->library('upload');
                if($_FILES['posts_images']['error'] == 0) {
                    //upload and update the file
                    $config['upload_path'] 			= './pubs/uploads/images/';
                    $config['allowed_types'] 		= 'png|jpg|jpeg|gif|bmp';
                    $config['overwrite'] 			= true;
                    $config['remove_spaces'] 		= true;
                    $config['encrypt_name'] 		= false;

                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('posts_images')) {
                        echo $this->upload->display_errors();

                    } else {

                        //Image Resizing
                        $cover['source_image'] 	    = $this->upload->upload_path.$this->upload->file_name;
                        $cover['maintain_ratio'] 	= FALSE;

                        $this->load->library('image_lib', $cover);
                        if (!$this->image_lib->resize()) {
                            echo $this->upload->display_errors();

                        } else {
                            $data['posts_images']    = $this->upload->file_name;
                        }
                    }
                }
            }
            
            $data['posts_file']           = trim(strip_tags($this->input->post('posts_file_temp')));
            //UPLOAD FILE PDF
            $this->load->library('upload');
            if($_FILES['posts_file']['error'] == 0) {
                $data['posts_file']             = '';
                $config2['upload_path']         = './pubs/file/';
                $config2['allowed_types']       = 'pdf|xls|xlsx|doc|docx';
                $config2['encrypt_name'] 		= false;
                $this->upload->initialize($config2);
                if (!$this->upload->do_upload('posts_file')) {
                    echo $this->upload->display_errors();
                } else {
                    $data['posts_file']    = $this->upload->file_name;
                }
            }
            
            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'cd_posts')) {
                        $data[$field]     = $val;
                    }
                endforeach;

                if ($this->input->post('posts_visibility') == true) {
                    $data['posts_visibility']       = 'P';
                } else {
                    $data['posts_visibility']       = 'M';
                }

                if ($this->input->post('posts_locked') == true) {
                    $data['posts_locked']       = 'Y';
                } else {
                    $data['posts_locked']       = 'N';
                }
            
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
            redirect(base_url('cms/download'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
	
	public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            
            //-GET DATA
            $GET_FILENAME   = $this->db->get_where("cd_posts", array("posts_lock_code" => $LOCK_CODE));
            $FILE           = $GET_FILENAME->row()->posts_file;
            $IMG_COVER      = $GET_FILENAME->row()->posts_images;
            
            //-DELETE FILE
            $TFILENAME = './pubs/file/'.$FILE;
            if(file_exists($TFILENAME)) {
                unlink($TFILENAME);
            } 

            $TFILEIMG = './pubs/uploads/images/'.$IMG_COVER;
            if(file_exists($TFILEIMG)) {
                unlink($TFILEIMG);
            } 

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
                
                $GET_FILENAME = $this->db->get_where("cd_posts", array("posts_lock_code" => $ID_CODE));
                $FILE         = $GET_FILENAME->row()->posts_file;
                $IMG_COVER    = $GET_FILENAME->row()->posts_images;

                //-DELETE FILE
                $TFILENAME = './pubs/file/'.$FILE;
                if(file_exists($TFILENAME)) {
                    unlink($TFILENAME);
                } 
                
                $TFILEIMG = './pubs/uploads/images/'.$IMG_COVER;
                if(file_exists($TFILEIMG)) {
                    unlink($TFILEIMG);
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