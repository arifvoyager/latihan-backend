<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        $this->load->model('mod_getdata');
        $this->load->model('mod_update');
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_POSTS';
            $data['STR_MENU']        = 'Post';
            $data['TITLE_PAGE']      = 'Posts';
            $data['content']         = 'posts/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT posts_lock_code, posts_title, (SELECT taxonomy_caption FROM jawata_taxonomy B WHERE B.taxonomy_flags = 'pages_category' AND B.taxonomy_lang = '".GET_DEFAULT_LANG()."' AND B.taxonomy_slug = A.posts_category) AS posts_category, posts_tags, posts_modified FROM jawata_posts A WHERE posts_type = 'posts' AND posts_locked = 'N' AND posts_lang = '".GET_DEFAULT_LANG()."' GROUP BY posts_lock_code ORDER BY posts_modified DESC");
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
            
            $data['STR_PAGES']       = 'PAGE_POSTS_ADDNEW';
            $data['STR_MENU']        = 'Post';
            $data['TITLE_PAGE']      = 'Add New';
            $data['content']         = 'posts/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();

            $TAGS_LOCKCODE = array();
            $TAGS = $this->input->post('posts_tags');
            if ($this->input->post('posts_tags') != false) {
                foreach($TAGS as $tag) {

                    //-GET LOCKCODE
                    $GET_LOCKCODE = $this->db->get_where("jawata_taxonomy", array("taxonomy_flags" => "post_tags", "taxonomy_lang" => GET_DEFAULT_LANG(), "taxonomy_slug" => $tag));
                    foreach($GET_LOCKCODE->result() as $rsTagsLockCode):
                        $TAGS_LOCKCODE[] = $rsTagsLockCode->taxonomy_lock_code;
                    endforeach;
                }
            }

            if($this->input->post('posts_status') == TRUE) {
                $data['posts_status']       = 'Y';
            } else {
                $data['posts_status']       = 'N';
            }
            
            $data['posts_file']             = trim(strip_tags($this->input->post('posts_file')));
            $data['posts_visibility']       = trim(strip_tags($this->input->post('posts_visibility')));
            $data['posts_modified']         = getDateTime();
            $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
            $data['posts_type']             = 'posts';
            $data['posts_lock_code']        = getRandom(15, 15);
            $data['posts_locked']       = 'N';
            
            //UPLOAD IMAGES
            $data['posts_images']           = '';
            $this->load->library('upload');
            if($_FILES['posts_images']['error'] == 0) {
                    //upload and update the file
                    $config['upload_path'] 			= './pubs/uploads/';
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

            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'jawata_posts')) {
                        $data[$field]     = $val;
                    }
                endforeach;
                
                if($this->input->post('posts_tags') == TRUE) {
                    $TAGS_SLUG = substr($TAGS_SLUG, 0, strlen($TAGS_SLUG) - 1);
                    $data['posts_tags']       = $TAGS_SLUG;
                } else {
                    $data['posts_tags']       = "";
                }

                //GET TAGS - LOOP TAGS CODE
                $TAGS_SLUG = '';
                foreach($TAGS_LOCKCODE as $lockCode):
                    //Get tags
                    $GET_TAGS = $this->db->get_where("jawata_taxonomy", array("taxonomy_flags" => "post_tags", "taxonomy_lang" => $rsLang->language_code, "taxonomy_lock_code" => $lockCode));
                    foreach($GET_TAGS->result() as $tags):
                        $TAGS_SLUG .= $tags->taxonomy_caption.";";
                    endforeach;
                endforeach;
            
                $this->db->insert('jawata_posts', $data); 
            endforeach;

            //- REDIRECT
            redirect(base_url('jpanel/posts'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }  
	
	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_POSTS_EDIT';
            $data['STR_MENU']        = 'Post';
            $data['TITLE_PAGE']      = 'Edit Posts';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'posts/edit.php';
            $data['SELECTED']        = $this->db->get_where('jawata_posts', array('posts_lock_code' => $LOCK_CODE, "posts_lang" => GET_DEFAULT_LANG()));
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    public function updated($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();
            
            $TAGS_LOCKCODE = array();
            $TAGS = $this->input->post('posts_tags');
            if($TAGS == true){
                foreach($TAGS as $tag) {
                    //-GET LOCKCODE
                    $GET_LOCKCODE = $this->db->get_where("jawata_taxonomy", array("taxonomy_flags" => "post_tags", "taxonomy_lang" => GET_DEFAULT_LANG(), "taxonomy_slug" => $tag));
                    foreach($GET_LOCKCODE->result() as $rsTagsLockCode):
                        $TAGS_LOCKCODE[] = $rsTagsLockCode->taxonomy_lock_code;
                    endforeach;
                }
            }

            if($this->input->post('posts_status') == TRUE) {
                $data['posts_status']       = 'Y';
            } else {
                $data['posts_status']       = 'N';
            }
            
            $data['posts_file']             = trim(strip_tags($this->input->post('posts_file')));
            $data['posts_visibility']       = trim(strip_tags($this->input->post('posts_visibility')));
            $data['posts_modified']         = getDateTime();
            $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
            $data['posts_type']             = 'posts';
            
            //UPLOAD IMAGES
            $data['posts_images']           = trim(strip_tags($this->input->post('posts_images_temp')));
            $this->load->library('upload');
            if($_FILES['posts_images']['error'] == 0) {
                //upload and update the file
                $config['upload_path'] 			= './pubs/uploads/';
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

                    $cover['width'] 			= 1366;
                    $cover['height'] 			= 425;

                    $this->load->library('image_lib', $cover);
                    if (!$this->image_lib->resize()) {
                        echo $this->upload->display_errors();

                    } else {
                        $data['posts_images']    = $this->upload->file_name;
                    }
                }
            }
            
            foreach ($GET_LANG->result() as $LANG):
                foreach ($this->input->post() as $key=>$val):
                    $field = (str_replace('_'.$LANG->language_code, '', $key));
                    if ($this->db->field_exists($field, 'jawata_posts')) {
                        $data[$field]     = $val;
                    }
                endforeach;
                
                $CHECK_POSTS        = $this->db->get_where('jawata_posts', array('posts_lang' => $LANG->language_code, 'posts_lock_code' => $LOCK_CODE));
                if ($CHECK_POSTS->num_rows() > 0) {
                    //- UPDATE DATA
                    $this->db->where('posts_lock_code', $LOCK_CODE);
                    $this->db->where('posts_lang', $LANG->language_code);
                    $this->db->update('jawata_posts', $data); 
                } else {
                    //- SAVE DATA
                    $data['posts_lock_code']    = $LOCK_CODE;
                    $this->db->insert('jawata_posts', $data);
                }

            endforeach;

            //- REDIRECT
            redirect(base_url('jpanel/posts'));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
	
	public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            $this->db->delete('jawata_posts', array('posts_lock_code' => $LOCK_CODE)); 
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
                $query      = $this->db->delete('jawata_posts', array('posts_lock_code' => $ID_CODE)); 
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