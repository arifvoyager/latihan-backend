<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_MENU']        = 'Gallery';
            $data['TITLE_PAGE']      = 'Gallery';
            $data['STR_PAGES']       = 'PAGE_GALLERY';
            $data['content']         = 'gallery/data.php';
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
	public function data() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_MENU']        = 'Gallery';
            
            if($this->uri->segment(4) == 'photo') {
                $data['STR_PAGES']       = 'PAGE_GALLERY_PHOTO';
                $data['TITLE_PAGE']      = 'Photo';
                $data['content']         = 'gallery/photo/data.php';
            } elseif ($this->uri->segment(4) == 'video') {
                $data['STR_PAGES']       = 'PAGE_GALLERY_VIDEO';
                $data['TITLE_PAGE']      = 'Gallery';
                $data['content']         = 'gallery/video/data.php';
            }
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            if ($this->uri->segment(4) != false) {
                $GET_LANG = $this->db->query("SELECT *, (SELECT taxonomy_name FROM cd_taxonomy B WHERE A.posts_tags = B.taxonomy_lock_code AND B.taxonomy_lang = '".GET_DEFAULT_LANG()."' ) as gallery_category_name FROM cd_posts A WHERE posts_type = 'gallery' AND posts_category = '".$this->uri->segment(4)."' AND posts_lang = '".GET_DEFAULT_LANG()."' GROUP BY posts_lock_code ORDER BY posts_modified DESC");
            } else {
                $GET_LANG = $this->db->query("SELECT * FROM cd_taxonomy WHERE taxonomy_flags = 'GALLERY_CATEGORY' AND taxonomy_lang = '".GET_DEFAULT_LANG()."' GROUP BY taxonomy_lock_code ORDER BY taxonomy_value DESC");
            }
            $strArray = array();
			foreach($GET_LANG->result() as $strObj) {
				$strArray[] = $strObj;
			}
				
			echo json_encode($strArray);
            
        } else {
            echo "Error load data";       
        }
    }

	public function loads($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_GALLERY_PHOTO';
            $data['STR_MENU']        = 'Gallery';
            $data['TITLE_PAGE']      = 'Gallery';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'gallery/photo/img/data.php';
            
            //SAVE SESSION
            $this->session->set_userdata('sess_gallery_photo_img', $LOCK_CODE);
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
	public function link($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_GALLERY_VIDEO';
            $data['STR_MENU']        = 'Gallery';
            $data['TITLE_PAGE']      = 'Link';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'gallery/video/link/data.php';
            
            //SAVE SESSION
            $this->session->set_userdata('sess_gallery_video_link', $LOCK_CODE);
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
	public function addnew() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_MENU']        = 'Gallery';
            $data['TITLE_PAGE']      = 'Add New';
            
            if ($this->uri->segment(4) == false) {
                $data['STR_PAGES']       = 'PAGE_GALLERY_ADDNEW';
                $data['content']         = 'gallery/addnew.php';
            } elseif ($this->uri->segment(4) == 'photo') {
                $data['STR_PAGES']       = 'PAGE_GALLERY_PHOTO';
                $data['content']         = 'gallery/photo/addnew.php';
            } elseif ($this->uri->segment(4) == 'video') {
                $data['STR_PAGES']       = 'PAGE_GALLERY_VIDEO';
                $data['content']         = 'gallery/video/addnew.php';
            } elseif ($this->uri->segment(4) == 'galley_img') {
                $data['STR_PAGES']       = 'PAGE_GALLERY_PHOTO';
                $data['content']         = 'gallery/photo/img/addnew.php';
            } elseif ($this->uri->segment(4) == 'galley_video') {
                $data['STR_PAGES']       = 'PAGE_GALLERY_VIDEO';
                $data['content']         = 'gallery/video/link/addnew.php';
            }
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();

            if ($this->uri->segment(4) == false) {
                $data['taxonomy_flags']         = 'GALLERY_CATEGORY';
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
                redirect(base_url('jpanel/gallery'));
                
            } elseif ($this->uri->segment(4) == 'gallery_video') {
                $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
                $data['posts_type']             = 'video';
                $data['posts_category']         = 'video-link';
                $data['posts_lock_code']        = getRandom(15, 15);
                $data['posts_parent']           = $this->session->userdata('sess_gallery_video_link');

                foreach ($this->input->post() as $key=>$val):
                    if ($this->db->field_exists($key, 'cd_posts')) {
                        $data[$key]     = $val;
                    }
                endforeach;

                $this->db->insert('cd_posts', $data); 
                
                redirect(base_url('jpanel/gallery/link/'.$this->session->userdata('sess_gallery_video_link')));
                
            } elseif ($this->uri->segment(4) == 'galley_img') {
                $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
                $data['posts_type']             = 'photo';
                $data['posts_category']         = 'image-file';
                $data['posts_lock_code']        = getRandom(15, 15);
                $data['posts_parent']           = $this->session->userdata('sess_gallery_photo_img');
                //$data['posts_tags']             = $this->db->get_where('cd_posts', array('posts_lock_code' => $this->session->userdata('sess_gallery_photo_img')))->row()->posts_tags;

                //UPLOAD IMAGES
                $upload_image                   = upload_image('posts_images');
                $data['posts_images']           = $upload_image;
                
                foreach ($this->input->post() as $key=>$val):
                    if ($this->db->field_exists($key, 'cd_posts')) {
                        $data[$key]     = $val;
                    }
                endforeach;

                $this->db->insert('cd_posts', $data); 
                
                redirect(base_url('jpanel/gallery/loads/'.$this->session->userdata('sess_gallery_photo_img')));
                
            } else {
                if ($this->uri->segment(4) == 'photo' || $this->uri->segment(4) == 'video') {
                    $data['posts_modified']         = getDateTime();
                    $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
                    $data['posts_type']             = 'gallery';
                    $data['posts_category']         = $this->uri->segment(4);
                    $data['posts_lock_code']        = getRandom(15, 15);

                    foreach ($GET_LANG->result() as $LANG):
                        foreach ($this->input->post() as $key=>$val):
                            $field = (str_replace('_'.$LANG->language_code, '', $key));
                            if ($this->db->field_exists($field, 'cd_posts')) {
                                $data[$field]     = $val;
                            }
                        endforeach;

                        $this->db->insert('cd_posts', $data); 
                    endforeach;
                    
                    //- REDIRECT
                    redirect(base_url('jpanel/gallery/data/'.$this->uri->segment(4)));
                } else {
                    if($this->input->post('posts_status') == TRUE) {
                        $data['posts_status']       = 'Y';
                    } else {
                        $data['posts_status']       = 'N';
                    }
                    $data['posts_modified']         = getDateTime();
                    $data['posts_author']           = $this->session->userdata('sess_cpanelx_uid');
                    $data['posts_type']             = 'pages';
                    $data['posts_lock_code']        = getRandom(15, 15);
                    $data['posts_locked']           = 'N';

                    //UPLOAD IMAGES
                    $upload_banner                  = upload_image('posts_images', 1364, 645);
                    $data['posts_images']           = $upload_banner;

                    foreach ($GET_LANG->result() as $LANG):
                        foreach ($this->input->post() as $key=>$val):
                            $field = (str_replace('_'.$LANG->language_code, '', $key));
                            if ($this->db->field_exists($field, 'cd_posts')) {
                                $data[$field]     = $val;
                            }
                        endforeach;

                        $this->db->insert('cd_posts', $data); 
                    endforeach;

                    //- REDIRECT
                    redirect(base_url('jpanel/pages'));
                }
            }
        } else {
            $this->load->view('backend/FormLogin');
        }
    }  
	
	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_GALLERY_EDIT';
            $data['STR_MENU']        = 'Gallery';
            $data['TITLE_PAGE']      = 'Edit Data';

            if ($this->uri->segment(5) == false) {
                $data['LOCK_CODE']   = $LOCK_CODE;
                $data['SELECTED']    = $this->db->get_where('cd_taxonomy', array('taxonomy_lock_code' => $LOCK_CODE));
                $data['content']     = 'gallery/edit.php';
            } elseif ($this->uri->segment(4) == 'photo') {
                $data['LOCK_CODE']   = $this->uri->segment(5);;
                
                $data['content']     = 'gallery/photo/edit.php';
            } elseif ($this->uri->segment(4) == 'video') {
                $data['LOCK_CODE']   = $this->uri->segment(5);;
                
                $data['content']     = 'gallery/video/edit.php';
            }
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    public function updated($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $GET_LANG = GET_LANG();

            if ($this->uri->segment(5) == false) {
                foreach ($GET_LANG->result() as $LANG):
                    foreach ($this->input->post() as $key=>$val):
                        $field = (str_replace('_'.$LANG->language_code, '', $key));
                        if ($this->db->field_exists($field, 'cd_taxonomy')) {
                            $data[$field]     = $val;
                        }
                    endforeach;


                    $CHECK_POSTS        = $this->db->get_where('cd_taxonomy', array('taxonomy_lang' => $LANG->language_code, 'taxonomy_lock_code' => $LOCK_CODE));
                    if ($CHECK_POSTS->num_rows() > 0) {
                        //- UPDATE DATA
                        $this->db->where('taxonomy_lock_code', $LOCK_CODE);
                        $this->db->where('taxonomy_lang', $LANG->language_code);
                        $this->db->update('cd_taxonomy', $data); 
                    } else {
                        //- SAVE DATA
                        $data['posts_lock_code']    = $LOCK_CODE;
                        $this->db->insert('cd_taxonomy', $data);
                    }

                endforeach;
                
                //- REDIRECT
                redirect(base_url('jpanel/gallery'));
            } else {
                if($this->input->post('posts_status') == TRUE) {
                    $data['posts_status']       = 'Y';
                } else {
                    $data['posts_status']       = 'N';
                }

                //UPLOAD IMAGES
                $data['posts_images'] = trim(strip_tags($this->input->post('posts_images_temp')));
                $upload_banner = upload_image('posts_images', 1364, 645);

                if ($upload_banner != NULL || $upload_banner != '') { $data['posts_images'] = $upload_banner; }

                foreach ($GET_LANG->result() as $LANG):
                    foreach ($this->input->post() as $key=>$val):
                        $field = (str_replace('_'.$LANG->language_code, '', $key));
                        if ($this->db->field_exists($field, 'cd_posts')) {
                            $data[$field]     = $val;
                        }
                    endforeach;

                    $CHECK_POSTS        = $this->db->get_where('cd_posts', array('posts_lang' => $LANG->language_code, 'posts_lock_code' => $this->uri->segment(5)));
                    if ($CHECK_POSTS->num_rows() > 0) {
                        //- UPDATE DATA
                        $this->db->where('posts_lock_code', $this->uri->segment(5));
                        $this->db->where('posts_lang', $LANG->language_code);
                        $this->db->update('cd_posts', $data); 
                    } else {
                        //- SAVE DATA
                        $data['posts_lock_code']    = $this->uri->segment(5);
                        $this->db->insert('cd_posts', $data);
                    }

                endforeach;
                
                //- REDIRECT
                redirect(base_url('jpanel/gallery/data/'.$this->uri->segment(4)));
            }
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
	
	public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));

            if ($this->uri->segment(4) == false) {
                //DELETE PAGE
                $this->db->delete('cd_taxonomy', array('taxonomy_lock_code' => $LOCK_CODE)); 
                
                echo "success";
            } elseif ($this->uri->segment(4) == 'galley_img') {
                $GET_FILENAME = $this->db->get_where("cd_posts", array("posts_lock_code" => $LOCK_CODE));
                $IMG_COVER  = $GET_FILENAME->row()->posts_images;

                //-DELETE FILE
                $TFILENAME = './pubs/uploads/'.$IMG_COVER;
                if(file_exists($TFILENAME)) {
                    unlink($TFILENAME);
                } 
                
                $this->db->delete('cd_posts', array('posts_lock_code' => $LOCK_CODE)); 
                echo "success";
            } elseif ($this->uri->segment(4) == 'video_link') {
                $this->db->delete('cd_posts', array('posts_lock_code' => $LOCK_CODE)); 
                echo "success";
            } else {
                $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));

                //DELETE PAGE
                $this->db->delete('cd_posts', array('posts_lock_code' => $LOCK_CODE)); 
                echo "success";
            }
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function trashSelected() {
		if($this->session->userdata('sess_cpanelx') == TRUE) {
            
            if ($this->uri->segment(4) == false) {
                $data = json_decode(stripslashes($_POST['data']));
                foreach($data as $d){
                    $ID_CODE    = $d;

                    //DELETE PAGE
                    $query      = $this->db->delete('cd_taxonomy', array('taxonomy_lock_code' => $ID_CODE)); 
                }
            } else {
                $data = json_decode(stripslashes($_POST['data']));
                foreach($data as $d){
                    $ID_CODE    = $d;

                    //DELETE ON MENU
                    $GET_SLUG = $this->db->get_where('cd_posts', array('posts_lock_code' => $ID_CODE));
                    foreach($GET_SLUG->result() as $rsPosts):
                        $this->db->delete('cd_menu', array('menu_link' => $rsPosts->posts_slug)); 
                    endforeach;

                    //DELETE PAGE
                    $query      = $this->db->delete('cd_posts', array('posts_lock_code' => $ID_CODE)); 
                }
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