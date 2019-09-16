<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MENUS';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Menus';
            $data['content']         = 'menus/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_taxonomy WHERE taxonomy_flags = 'group_menu' ORDER BY taxonomy_value ASC");
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
            
            $data['STR_PAGES']       = 'PAGE_MENUS_ADDNEW';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Add New';
            $data['content']         = 'menus/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function saved() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['taxonomy_lock_code']     = getRandom(15, 15);
            $data['taxonomy_flags']         = 'group_menu';
            $data['taxonomy_value']         = trim(strip_tags($this->input->post('taxonomy_value')));
            $data['taxonomy_lang']          = GET_DEFAULT_LANG();

            //- SAVE DATA
            $this->db->insert('cd_taxonomy', $data); 
            
            //- REDIRECT
            redirect(base_url('cms/menus'));
            
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }  
	
	public function editdata($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MENUS_EDIT';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Edit Menus';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'menus/edit.php';
            $this->session->set_userdata('sess_menus_lockcode', $LOCK_CODE);
            
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
	
	public function trash() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            $this->db->delete('cd_taxonomy', array('taxonomy_lock_code' => $LOCK_CODE)); 
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
                $query      = $this->db->delete('cd_taxonomy', array('taxonomy_lock_code' => $ID_CODE)); 
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
	
	public function addtomenu($LOCK_CODES) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            
            $data['menu_group']   = $this->input->post('group_menu');
            $PAGEMENU             = $this->input->post('page_menu');
            $data['menu_lock_code'] = getRandom(15, 15);
            
            //SAVE HOME MENU
            if($this->input->post('page_menu_home') == TRUE) {
                $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
                foreach($GET_LANG->result() as $rsLang):
                    $data['menu_caption']   = $rsLang->language_home;
                    $data['menu_link']      = '';
                    $data['menu_lang']      = $rsLang->language_code;
                    $data['menu_sort']      = 1;
                    $data['menu_type']      = 'P';

                    //- SAVE DATA
                    $this->db->insert('cd_menu', $data); 
                
                endforeach;
            }
            
            
            //SAVE PAGE MENU
            $iLoop = 2;
            foreach($PAGEMENU as $DATA_PAGEMENU){
                $LOCK_CODE = $DATA_PAGEMENU;
                $data['menu_lock_code'] = getRandom(15, 15);
                
                $GET_MENU_PAGE = $this->db->get_where('cd_posts', array('posts_lock_code' => $LOCK_CODE));
                foreach($GET_MENU_PAGE->result() as $rsMenuPost):
                
                    $data['menu_caption']   = $rsMenuPost->posts_title;
                    $data['menu_link']      = $rsMenuPost->posts_slug;
                    $data['menu_lang']      = $rsMenuPost->posts_lang;
                    $data['menu_sort']      = $iLoop;
                    $data['menu_type']      = 'P';
                
                    //- SAVE DATA
                    $this->db->insert('cd_menu', $data); 
                
                endforeach;
                
                $iLoop++;
            }
            
            //- REDIRECT
            redirect(base_url('cms/menus/editdata/'.$LOCK_CODES));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function addtomenulink($LOCK_CODES) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            //GET SORT MAX
            $this->db->select_max('menu_sort');
            $QMAX       = $this->db->get('cd_menu');
            $SORT_MAX   = $QMAX->row()->menu_sort + 1;
            
            $data['menu_link']   = $this->input->post('url_menu');
            $data['menu_group']  = $this->input->post('group_menu');
            $data['menu_lock_code'] = getRandom(15, 15);
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
            foreach($GET_LANG->result() as $rsLang):
                
                $data['menu_caption']   = $this->input->post('link_text_'.$rsLang->language_code);
                $data['menu_lang']      = $rsLang->language_code;
                $data['menu_sort']      = $SORT_MAX;
                $data['menu_type']      = 'U';
                    
                //- SAVE DATA
                $this->db->insert('cd_menu', $data); 
                
            endforeach;
            
            //- REDIRECT
            redirect(base_url('cms/menus/editdata/'.$LOCK_CODES));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function updatemenusort($LOCK_CODES) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $menu = json_decode(stripslashes($this->input->post('output-menu')), true);

            $PARENT_TEMP = '';
            $iLoop       = 1;
            
            //Start the loop through the menu array
            foreach ($menu as $parentHolder) {
                
                foreach ($parentHolder as $parentKey => $parent) {

                    //Checks to see when this jumps into the children array
                    if (!is_array($parent)) {                       

                        //Only run on the content key                                   
                        if ($parentKey == "id") {

                            if ($parent) {
                                $PARENT_TEMP = $parent;
                                
                                //UPDATE
                                $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
                                foreach($GET_LANG->result() as $rsLang):
                                    $data['menu_sort']      = $iLoop;
                                    $data['menu_parent']    = '0';
                                
                                    $this->db->where('menu_lock_code', $parent);
                                    $this->db->where('menu_lang', $rsLang->language_code);
                                    $this->db->update('cd_menu', $data); 
                                
                                endforeach;
                                
                            } //Only to array if not empty               

                        } //end check for content as key for the parents                                                    

                    } else {                                                        
 
                        $iLoopChild = 1;
                        //This is an array, which means this parent has children                                                                                                    
                        foreach ($parent as $childHolder) {  
                            foreach ($childHolder as $childKey => $child) { 

                                //Only run on the content key
                                if ($childKey == "id") {

                                    if ($child) { 
                                        
                                        //UPDATE
                                        $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
                                        foreach($GET_LANG->result() as $rsLang):
                                            $data['menu_sort']      = $iLoopChild;
                                            $data['menu_parent']    = $PARENT_TEMP;

                                            $this->db->where('menu_lock_code', $child);
                                            $this->db->where('menu_lang', $rsLang->language_code);
                                            $this->db->update('cd_menu', $data); 

                                        endforeach;
                                        
                                    } //Only to array if not empty

                                } //end check for content as key for the children
                                
                            } //End child foreach loop   
                            
                            $iLoopChild++;
                        } //end childholder foreach loop

                    } //Check if key is = content
                    
                } //end Parent loop 
                
                $iLoop++;
            } //end the main loop   
            
            //- REDIRECT
            redirect(base_url('cms/menus/editdata/'.$LOCK_CODES));
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function trashMenuSelected() {
		if($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $LOCK_CODE = trim(strip_tags($this->input->post('LOCK_CODE')));
            $this->db->delete('cd_menu', array('menu_lock_code' => $LOCK_CODE)); 
            echo "success";
            
		} else {
			$this->load->view('backend/FormLogin');
		}
	}  
	
	public function editmenus($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MENUS_EDIT_LIST';
            $data['STR_MENU']        = 'Apperance';
            $data['TITLE_PAGE']      = 'Edit Menus';
            $data['LOCK_CODE']       = $LOCK_CODE;
            $data['content']         = 'menus/edit_list.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
    
    public function updatelistmenu($LOCK_CODE) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            if($this->input->post('url_menu') == TRUE) {
                $data['menu_link']  = trim(strip_tags($this->input->post('url_menu')));
            }
            
            $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
            foreach($GET_LANG->result() as $rsLang):
                $data['menu_caption']    = trim(strip_tags($this->input->post('link_text_'.$rsLang->language_code)));

                $this->db->where('menu_lock_code', $LOCK_CODE);
                $this->db->where('menu_lang', $rsLang->language_code);
                $this->db->update('cd_menu', $data); 
            
            endforeach;
            
            //- REDIRECT
            redirect(base_url('cms/menus/editdata/'.$this->session->userdata('sess_menus_lockcode')));
            
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    } 
            
    
}