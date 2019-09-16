<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainpage extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        // SET LANGUAGE
    }
    
    //------------------------------------------------------------------------------------------------------------------------
    // CONSTRUKTOR
    //------------------------------------------------------------------------------------------------------------------------
    public function index() {
        
        $LANG		            = GET_CURRENT_LANG();
        $data['LANG']		    = $LANG;

        $uri_page                   = $this->uri->segment(1);
        $pages                      = $this->db->get_where('cd_posts', array('posts_lang' => $LANG['code'], 'posts_slug' => $uri_page));
        
        if ($uri_page == false) {
            $data['content']        = 'page_default.php';
        } else {
            $data['pages']          = $pages->row();
            $uri_slug               = $this->uri->segment(3);
            $uri_category           = $this->uri->segment(2);
            $slug                   = $this->db->get_where('cd_posts', array('posts_lang' => $LANG['code'], 'posts_slug' => $uri_slug))->row();
            $slug_about             = $this->db->get_where('cd_posts', array('posts_lang' => $LANG['code'], 'posts_slug' => $uri_category))->row();
            
            if($pages->num_rows() > 0) {
                if ($uri_slug == false) {
                    if ($this->uri->segment(1) == 'berita' || $this->uri->segment(1) == 'news') {
                        $data['content']        = 'page/'.$pages->row()->posts_file;
                    } elseif ($pages->row()->posts_file != 'about.php') {
                        if ($pages->num_rows() > 0) {
                            $data['content']        = 'page/'.$pages->row()->posts_file;
                        } else {
                            $data['content']        = 'page_404.php';
                        }
                    } else {
                        if($uri_category == false) {
                            $data['content']        = 'page/'.$pages->row()->posts_file;
                        } else {
                            redirect(base_url($uri_page.'/d/'.$uri_category));
                        }
                    }
                } else {
                    if ($this->uri->segment(2) == 'd') {
                        $data['content']        = 'page/'.$slug->posts_type.'_detail.php';
                    } else if ($this->uri->segment(2) == 'image' || $this->uri->segment(2) == 'video') {
                        $data['content']        = 'page/gallery_list.php';
                    } else if ($this->uri->segment(2) == 'profile') {
                        $data['content']        = 'page/organisasi_detail.php';
                    } else {
                        $data['content']        = 'page_default.php';
                    }
                }
            } else {
                $data['content']        = 'page_404.php';
            }
        }
        
        $this->load->view('index', $data);
    }
    
    
    public function sendMessage() {
        $contact_name        = trim(strip_tags($this->input->post('contact_name')));
        $contact_email       = trim(strip_tags($this->input->post('contact_email')));
        $contact_phone       = trim(strip_tags($this->input->post('contact_phone')));
        $contact_message     = trim(strip_tags($this->input->post('contact_message')));
        
        $CURRENT_LANG	     = GET_CURRENT_LANG();
        
        $layout_email        = $this->db->get_where('cd_email', array('email_flag' => 'EMAIL_FORM_CONTACT', 'email_lang' => $CURRENT_LANG['code']))->row();
        
        $email_nickname      = $layout_email->email_nickname;
        $email_sender        = $layout_email->email_sender;
        $email_receiver      = $layout_email->email_receiver;
        $email_subject       = $layout_email->email_subject;
        $email_cc            = $layout_email->email_cc;
        $email_bcc           = $layout_email->email_bcc;

        $content             = $layout_email->email_message;

        //-REPLACE CONTENT
        $content    = str_replace('[tag_name]', $contact_name, $content);
        $content    = str_replace('[tag_email]', $contact_email, $content);
        $content    = str_replace('[tag_mobile]', $contact_phone, $content);
        $content    = str_replace('[tag_email_content]', $contact_message, $content);

        //====================================================================================================
        sendEmail($email_nickname, $email_sender, $email_receiver, $email_subject, $content, $email_cc, $email_bcc);
        //====================================================================================================
        
        //INSERT INTO
        $insert['contact_name']     = $contact_name;
        $insert['contact_email']    = $contact_email;
        $insert['contact_phone']    = $contact_phone;
        $insert['contact_message']  = $contact_message;
        
        $this->db->insert('cd_message', $insert);

        echo 'success';
    }
    
    public function search() {
        $data['LANG']           = GET_CURRENT_LANG();
        $key    = '';

        if($this->input->post() != false) {
            $this->session->set_userdata('keyword', $this->input->post('search-key'));
            $key = $this->session->userdata('keyword');
        } else {
            if($this->session->userdata('keyword') != false) {
                $key = $this->session->userdata('keyword');
            } 
        }
        
        $search                 = $this->db->query('SELECT * FROM cd_posts WHERE (posts_type = "news" OR posts_type = "events" OR posts_type = "download" OR posts_type = "about") AND (posts_title LIKE "%'.$key.'%" OR posts_subtitle LIKE "%'.$key.'%" OR posts_shortdesc LIKE "%'.$key.'%" OR posts_content LIKE "%'.$key.'%" OR posts_slug LIKE "%'.$key.'%") AND posts_lang = "'.$data['LANG']['code'].'" ORDER BY posts_type, posts_title');
        
        $data['keyword']        = $key;
        $data['count']          = $search->num_rows();
        $data['result_search']  = $search;
        $data['content']        = 'page/search.php';
        $this->load->view('index', $data);
    }
    
    public function subscribe() {
        $data['subs_email']     = $this->input->post('subscribe_email');
        
        $check_subscriber       = $this->db->get_where('cd_subscribe', array('subs_email' => $data['subs_email']));
        
        if ($check_subscriber->num_rows() > 0) {
            echo 'email_already_exist';
        } else {
            $this->db->insert('cd_subscribe', $data); 
            echo 'success';
        }
    }
}